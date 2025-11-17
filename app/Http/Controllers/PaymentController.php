<?php

namespace App\Http\Controllers;

use App\Events\RegistrationProcessed;
use App\Http\Repositories\hostedPaymentRepository;
use App\Http\Requests\CardVerificationRequest;
use App\Models\Coupon;
use App\Models\Payment;
use App\Models\Registrant;
use App\Models\Registration;
use App\Models\Student;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Omnipay\Omnipay;

class PaymentController extends Controller
{
    public $gateway;

    public function __construct()
    {
        parent::__construct();
        // $this->gateway = Omnipay::create('AuthorizeNetApi_Api');
        // $this->gateway->setAuthName(\Crypt::decrypt(\DB::table('settings')->select('value')->where('name','api_login')->first()->value));  //env('ANET_API_LOGIN_ID'));
        // $this->gateway->setTransactionKey(\Crypt::decrypt(\DB::table('settings')->select('value')->where('name','transaction_key')->first()->value));    //env('ANET_TRANSACTION_KEY'));
        // if(env('ANET_TESTING')=='true') {
        // 	$this->gateway->setTestMode(true); //comment this line when move to 'live'
        // }
    }

    private function floatvalue($val)
    {
        $val = str_replace(',', '.', $val);
        $val = preg_replace('/\.(?=.*\.)/', '', $val);

        return floatval($val);
    }

    // $payment - array[total, due, paid, paytype, cardno, ponum, responsible]
    private function saveRegistration($path, $payment, $registration)
    {
        $reg = new Registration;
        $reg->coid = (isset($registration['coid'])) ? $registration['coid'] : '0000';
        $reg->name = $registration['name'];
        $reg->phone = $registration['phone'];
        $reg->address = $registration['address'];
        $reg->city = $registration['city'];
        $reg->state = $registration['state'];
        $reg->zip = $registration['zip'];
        $reg->contact = $registration['contactfname'].' '.$registration['contactlname'];
        $reg->contactfname = $registration['contactfname'];
        $reg->contactlname = $registration['contactlname'];
        $reg->cphone = $registration['cphone'];
        $reg->cemail = $registration['cemail'];
        $reg->registrantcount = count($registration['registrants']);
        $reg->paytype = $payment['paytype'];
        $reg->cardno = $payment['cardno'];
        $reg->cardtype = $payment['cardtype'];
        $reg->total = $payment['total'];
        $reg->due = $payment['due'];
        $reg->paid = $payment['paid'];
        $reg->balance = $payment['total'] - $payment['paid'];
        $reg->member = $registration['member'];
        $reg->ponum = $payment['ponum'];
        $reg->responsible = $payment['responsible'];
        $reg->regtype = $path;
        $reg->coupon = ((isset($registration['coupon'])) ? $registration['coupon'] : '');
        $reg->discount = ((isset($payment['discount'])) ? $payment['discount'] : 0);
        $reg->payagree = 1;
        $reg->clientip = \Request::ip();
        $reg->save();

        foreach ($registration['registrants'] as $registrant) {
            $tosave = [
                'registration_id' => $reg->id,
                'firstname' => $registrant['firstname'],
                'lastname' => $registrant['lastname'],
                'dob' => (isset($registrant['dob']) && $registrant['dob'] > 0) ? strtotime($registrant['dob']) : 0,
                'address' => $registrant['address'],
                'city' => $registrant['city'],
                'state' => $registrant['state'],
                'zip' => $registrant['zip'],
                'mobile' => $registrant['mobile'],
                'mobilecarrier' => (isset($registrant['mobilecarrier'])) ? $registrant['mobilecarrier'] : '',
                'email' => $registrant['email'],
                'fee' => $registrant['cost'],
                'map' => (isset($registrant['map'])) ? $registrant['map'] : 0,
                'das' => (isset($registrant['das'])) ? $registrant['das'] : 0];
            if (isset($registrant['indid']) && ! empty($registrant['indid'])) {
                $tosave['indid'] = $registrant['indid'];
            }
            switch ($path) {
                case 'training':
                case 'event':
                    $ticket = Ticket::where('id', $registrant['ticket_id'])->first();
                    $tosave['event_id'] = $ticket->event->event_id;
                    $tosave['event'] = $ticket->event->name;
                    $tosave['ticket_id'] = $ticket->ticket_id;
                    $tosave['ticket'] = $ticket->name;
                    break;
                case 'trade':
                    $tosave['program'] = $registrant['course-trade'];
                    $tosave['location'] = $registrant['course-location'];
                    $tosave['course'] = $registrant['class'];
                    $tosave['schoolyear'] = $registrant['schoolyear'];
                    break;
                case 'online':
                    $tosave['course'] = $registrant['class'];
                    $tosave['schoolyear'] = $registrant['schoolyear'];
                    break;
                case 'correspondence':
                    $tosave['program'] = $registrant['course-trade'];
                    $tosave['course'] = $registrant['class'];
                    $tosave['schoolyear'] = $registrant['schoolyear'];
                    break;
            }
            $reg->registrants()->save(new Registrant($tosave));
        }

        return $reg;
    }

    private function savePayment($registration, $amount = 0, $payment_status = 'Notified', $transaction_id = 'check', $payee = null)
    {
        $registration->payment()->create([
            'name' => (! is_null($payee)) ? $payee['firstname'].' '.$payee['lastname'] : '',
            'firstname' => (! is_null($payee)) ? $payee['firstname'] : '',
            'lastname' => (! is_null($payee)) ? $payee['lastname'] : '',
            'address' => (! is_null($payee)) ? $payee['address'] : '',
            'city' => (! is_null($payee)) ? $payee['city'] : '',
            'state' => (! is_null($payee)) ? $payee['state'] : '',
            'zip' => (! is_null($payee)) ? $payee['zip'] : '',
            'transaction_id' => $transaction_id,
            'amount' => $amount,
            'currency' => 'USD',
            'payment_status' => $payment_status]);
    }

    public function paymentPage($path)
    {
        if (session()->has($path.'registration')) {
            $registration = session()->get($path.'registration');

            $total = 0;
            foreach ($registration['registrants'] as $key => $registrant) {
                $total += $registrant['cost'];
            }

            if ($total > 0) {
                return view('registration.payment', compact('path', 'registration'));
            } else {
                if (isset($registration['registrants']) && count($registration['registrants']) > 0) {
                    $payment = [
                        'total' => 0,
                        'due' => 0,
                        'paid' => 0,
                        'paytype' => 'none',
                        'cardno' => '',
                        'cardtype' => '',
                        'ponum' => '',
                        'responsible' => 'none'];
                    $reg = $this->saveRegistration($path, $payment, $registration);
                    // $this->savePayment($reg);
                    if (session()->has($path.'registration')) {
                        session()->forget($path.'registration');
                    }
                    RegistrationProcessed::dispatch($path, $reg);

                    return \Redirect::route('registration.confirmation', [$path, $reg->id]);
                } else {
                    return \Redirect::route('registration.registrant', $path);
                }
            }
        } else {
            return \Redirect::route('registration.company', $path);
        }
    }

    public function alternatePayment(Request $request, $path)
    {
        if (session()->has($path.'registration')) {
            $registration = session()->get($path.'registration');

            $total = 0;
            $discount = 0;
            $registration['coupon'] = (isset($request->coupon)) ? $request->input('coupon') : '';
            foreach ($registration['registrants'] as $key => $registrant) {
                $total += $registrant['cost'];
            }
            if (! empty($request->coupon)) {
                $coupon = Coupon::where('name', $request->input('coupon'))->first();
                if (! is_null($coupon)) {
                    if ($coupon->useCoupon()) {
                        $discount = $coupon->value($total);
                        $total = $coupon->appliedTotal($total);
                    }
                }
            }
            $cost = 0;
            if (! empty($request->applied)) {
                $request->applied = $this->floatvalue($request->applied);
                $cost = ($request->applied > $total) ? $total : $request->applied;
            } else {
                $cost = $total;
            }

            // $payment - array[total, due, paid, paytype, cardno, ponum, responsible]
            $payment = [
                'total' => $total,
                'discount' => $discount,
                'due' => $cost,
                'paid' => 0,
                'paytype' => $request->method,
                'cardno' => '',
                'cardtype' => '',
                'ponum' => $request->input('ponum'),
                'responsible' => $request->input('responsible')];
            $reg = $this->saveRegistration($path, $payment, $registration);
            // $this->savePayment($reg);
            if (session()->has($path.'registration')) {
                session()->forget($path.'registration');
            }
            RegistrationProcessed::dispatch($path, $reg);

            return \Redirect::route('registration.confirmation', [$path, $reg->id]);
        }
    }

    public function paymentToCC(Request $request, $path)
    {
        // dd($request->all(),$path);

        if (session()->has($path.'registration')) {

            $isRegistrationExist = Registration::where('clientip', \Request::ip())->where('created_at', '>', Carbon::now()->subMinutes(1)->toDateTimeString())->first();
            if (! $isRegistrationExist) {
                $registration = session()->get($path.'registration');

                $total = 0;
                $discount = 0;
                $coupon = (isset($request->coupon)) ? $request->input('coupon') : '';
                $registration['coupon'] = $coupon;
                foreach ($registration['registrants'] as $key => $registrant) {
                    $total += $registrant['cost'];
                }
                if (isset($request->coupon)) {
                    $coupon = Coupon::where('name', $request->input('coupon'))->first();
                    if (! is_null($coupon)) {
                        if ($coupon->useCoupon()) {
                            $discount = $coupon->value($total);
                            $total = $coupon->appliedTotal($total);
                        }
                    }
                }
                $amount = 0;
                if (! empty($request->applied)) {
                    $request->applied = $this->floatvalue($request->applied);
                    $amount = ($request->applied > $total) ? $total : $request->applied;
                } else {
                    $amount = $total;
                }
                $cost = $amount;

                // save reg and go to CC page
                $payment = [
                    'total' => $total,
                    'discount' => $discount,
                    'due' => $total,
                    'paid' => 0,
                    'paytype' => ($amount != 0) ? 'hold' : 'check',
                    'cardno' => null,
                    'ponum' => $request->input('ponum'),
                    'responsible' => $request->responsible,
                    'cardtype' => null];
                $reg = $this->saveRegistration($path, $payment, $registration);
                if (session()->has($path.'registration')) {
                    session()->forget($path.'registration');
                }
                $payee = [
                    'name' => $request->input('firstname').' '.$request->input('lastname'),
                    'firstname' => $request->input('firstname'),
                    'lastname' => $request->input('lastname'),
                    'address' => $request->input('address'),
                    'city' => $request->input('city'),
                    'state' => $request->input('state'),
                    'zip' => $request->input('zip'),
                ];
                if ($amount > 0) {
                    $this->savePayment($reg, $amount, 'hold', rand(100000000, 999999999), $payee);

                    return redirect()->route('registration.payment.post', [$path, $reg->id]);
                } else {
                    $this->savePayment($reg, $amount, 'check', rand(100000000, 999999999), $payee);
                    RegistrationProcessed::dispatch($path, $reg);

                    return \Redirect::route('registration.confirmation', [$path, $reg->id]);
                }
            } else {
                // if(session()->has($path.'registration')) {
                // 	session()->forget($path.'registration');
                // }
                return redirect()->route('registration.company', $path)->with('message', 'It appears you have already registered in the last five minutes.  Please wait longer before registering again.');
            }

        } else {
            return \Redirect::route('registration.company', $path)->with('message', 'It appears your session expired.');
        }
    }

    public function paymentPost(Request $request, $path, Registration $registration)
    {
        $payment = $registration->payment()->where('payment_status', 'hold')->first();
        if ($registration->balance > 0 && ! is_null($payment)) {
            $anpay = new hostedPaymentRepository;
            $token = $anpay->getHostedFormTokenFromPayment($payment);

            return view('registration.payment-auth', compact('token', 'registration', 'path', 'payment'));
        } else {
            return \Redirect::route('registration.company', $path)->with('message', 'Your registration does not have a balance due.');
        }
    }

    public function paymentResponse()
    {
        return view('registration.payment-response');
    }

    public function paymentComplete(Request $request, $path, Registration $registration)
    {
        $registration->paytype = (($request->cardtype == 'eCheck') ? 'eCheck' : 'credit');
        $registration->paid = $request->paid;
        $registration->due = $registration->balance = $registration->total - $request->paid;
        $registration->cardno = substr($request->card, -4);
        $registration->save();
        $payee = [
            'name' => $request->input('firstname').' '.$request->input('lastname'),
            'firstname' => $request->input('firstname'),
            'lastname' => $request->input('lastname'),
            'address' => $request->input('address'),
            'city' => $request->input('city'),
            'state' => $request->input('state'),
            'zip' => $request->input('zip'),
        ];
        $payment = $registration->payment()->where('payment_status', 'hold')->first();
        if ($payment) {
            $payment->transaction_id = $request->input('transactionid');
            $payment->amount = $request->input('paid');
            $payment->payment_status = 'Captured';
            $payment->save();
        }
        // $this->savePayment($registration, $request->paid, 'Captured', $request->transactionid, $payee);
        RegistrationProcessed::dispatch($path, $registration);

        return \Redirect::route('registration.confirmation', [$path, $registration->id]);
    }

    public function paymentSave(CardVerificationRequest $request, $path)
    {
        $validatedData = $request->validated();

        $newCard = (object) [];

        $newCard->card_number = str_replace(' ', '', $request->input('card_number'));
        $newCard->expiration_month = $validatedData['expiration_month'];
        $newCard->expiration_year = $validatedData['expiration_year'];
        $newCard->cvc = $validatedData['cvc'];

        if (session()->has($path.'registration')) {
            try {
                $registration = session()->get($path.'registration');
                if ($request->input('responsible') == 'company') {
                    $creditCard = new \Omnipay\Common\CreditCard([
                        'number' => $newCard->card_number,
                        'expiryMonth' => $newCard->expiration_month,
                        'expiryYear' => $newCard->expiration_year,
                        'cvv' => $newCard->cvc,
                        'firstName' => $request->input('firstname'),
                        'lastName' => $request->input('lastname'),
                        'billingCompany' => $request->input('company'),
                        'billingAddress1' => $request->input('address'),
                        'billingCity' => $request->input('city'),
                        'billingState' => $request->input('state'),
                        'billingPostcode' => $request->input('zip'),
                        'billingCountry' => 'US',
                        'billingPhone' => $request->input('phone'),
                        'email' => $request->input('email'),
                    ]);
                } else {
                    $creditCard = new \Omnipay\Common\CreditCard([
                        'number' => $newCard->card_number,
                        'expiryMonth' => $newCard->expiration_month,
                        'expiryYear' => $newCard->expiration_year,
                        'cvv' => $newCard->cvc,
                        'firstName' => $request->input('firstname'),
                        'lastName' => $request->input('lastname'),
                        'billingPostcode' => $request->input('zip'),
                        'email' => $request->input('email'),
                    ]);
                }

                // Generate a unique merchant site transaction ID.
                $transactionId = rand(100000000, 999999999);

                $total = 0;
                $discount = 0;
                $coupon = (isset($request->coupon)) ? $request->input('coupon') : '';
                $registration['coupon'] = $coupon;
                foreach ($registration['registrants'] as $key => $registrant) {
                    $total += $registrant['cost'];
                }
                if (isset($request->coupon)) {
                    $coupon = Coupon::where('name', $request->input('coupon'))->first();
                    if (! is_null($coupon)) {
                        if ($coupon->useCoupon()) {
                            $discount = $coupon->value($total);
                            $total = $coupon->appliedTotal($total);
                        }
                    }
                }

                $amount = 0;
                if (! empty($request->applied)) {
                    $request->applied = $this->floatvalue($request->applied);
                    $amount = ($request->applied > $total) ? $total : $request->applied;
                } else {
                    $amount = $total;
                }

                try {
                    $response = $this->gateway->authorize([
                        'amount' => (! empty($request->applied)) ? $request->applied : $amount,
                        'currency' => 'USD',
                        'transactionId' => $transactionId,
                        'card' => $creditCard,
                    ])->send();
                } catch (\Exception $e) {
                    return \Redirect::back()->withInput()->withErrors(['card' => $e->getMessage()]);
                }

                if ($response->isSuccessful()) {

                    // Captured from the authorization response.
                    $transactionReference = $response->getTransactionReference();

                    $response = $this->gateway->capture([
                        'amount' => $amount,
                        'currency' => 'USD',
                        'transactionReference' => $transactionReference,
                    ])->send();

                    $transaction_id = $response->getTransactionReference();

                    // Insert transaction data into the database
                    $isPaymentExist = Payment::where('transaction_id', $transaction_id)->first();

                    if (! $isPaymentExist) {
                        $payment = [
                            'total' => $total,
                            'discount' => $discount,
                            'due' => $total - $amount,
                            'paid' => $amount,
                            'paytype' => 'credit',
                            'cardno' => substr($newCard->card_number, -4),
                            'ponum' => $request->input('ponum'),
                            'responsible' => $request->input('responsible')];
                        switch (substr($newCard->card_number, 0, 1)) {
                            case '3': $payment['cardtype'] = 'American Express';
                                break;
                            case '4': $payment['cardtype'] = 'Visa';
                                break;
                            case '5': $payment['cardtype'] = 'MasterCard';
                                break;
                            case '6': $payment['cardtype'] = 'Discover';
                                break;
                        }
                        $reg = $this->saveRegistration($path, $payment, $registration);
                        $payee = [
                            'name' => $request->input('firstname').' '.$request->input('lastname'),
                            'firstname' => $request->input('firstname'),
                            'lastname' => $request->input('lastname'),
                            'address' => $request->input('address'),
                            'city' => $request->input('city'),
                            'state' => $request->input('state'),
                            'zip' => $request->input('zip'),
                        ];
                        $this->savePayment($reg, $amount, 'Captured', $transaction_id, $payee);
                        RegistrationProcessed::dispatch($path, $reg);
                    }

                    return \Redirect::route('registration.confirmation', [$path, $reg->id]);
                } else {
                    // dd($response);
                    return \Redirect::back()->withInput()->with('errormessage', 'The payment was not successful.');
                }
            } catch (Exception $e) {
                return \Redirect::back()->withInput()->with('message', $e->getMessage());
            }
        } else {
            return \Redirect::route('registration.company', $path);
        }
    }

    public function balancePayment(Request $request, Student $student)
    {
        if ($student->balance > 0) {
            $anpay = new hostedPaymentRepository;

            $token = $anpay->getHostedFormToken($request, $student->balance);

            return view('balancePayment-auth', compact('token', 'student'));
        } else {
            return view('balancePayment-confirmation', ['nobalance' => 'true']);
        }
    }

    public function balanceComplete(Request $request, Student $student)
    {
        if ($student->balance > 0) {
            $isPaymentExist = Payment::where('transaction_id', $request->transactionid)->first();

            if (! $isPaymentExist) {
                $amount = $student->balance;
                $student->balance = 0;
                $student->save();

                $payment = new Payment;
                $payment->registration_id = 0;
                $payment->name = $request->input('firstname').' '.$request->input('lastname');
                $payment->firstname = $request->input('firstname');
                $payment->lastname = $request->input('lastname');
                $payment->address = $request->input('address');
                $payment->city = $request->input('city');
                $payment->state = $request->input('state');
                $payment->zip = $request->input('zip');
                $payment->email = $request->input('email');
                $payment->transaction_id = $request->transactionid;
                $payment->amount = $amount;
                $payment->currency = 'USD';
                $payment->payment_status = 'Paid';
                $payment->save();

                foreach (explode(',', getSetting('ADMIN_EMAIL', 'general')) as $email) {
                    \Mail::to(trim($email))->send(\App\Mail\BalancePaidMail($student, $payment));
                }

                // \Mail::to($this->settings->get('ADMIN_EMAIL','general'))->send(new \App\Mail\BalancePaidMail($student,$payment));
                // \Mail::to($this->settings->get('ADMIN_EMAIL2','general'))->send(new \App\Mail\BalancePaidMail($student,$payment));
            }

            return view('balancePayment-confirmation', compact('payment'));
        } else {
            return view('balancePayment-confirmation', ['nobalance' => 'true']);
        }
    }

    /*
        public function balancePayment(CardVerificationRequest $request, Student $student) {
            $validatedData = $request->validated();

            $newCard = (object)[];

            $newCard->card_number = str_replace(" ","",$request->input('card_number'));
            $newCard->expiration_month = $validatedData["expiration_month"];
            $newCard->expiration_year = $validatedData["expiration_year"];
            $newCard->cvc = $validatedData["cvc"];
            try {
                if($student->balance > 0) {
                    $creditCard = new \Omnipay\Common\CreditCard([
                        'number' => $newCard->card_number,
                        'expiryMonth' => $newCard->expiration_month,
                        'expiryYear' => $newCard->expiration_year,
                        'cvv' => $newCard->cvc,
                        "firstName" => $request->input('firstname'),
                        "lastName" => $request->input('lastname'),
                        "billingAddress1" => $request->input('address'),
                        "billingCity" => $request->input('city'),
                        "billingState" => $request->input('state'),
                        "billingPostcode" => $request->input('zip'),
                        "billingCountry" => "USA",
                        "billingPhone" => $request->input('phone'),
                        "email" => $request->input('email')
                    ]);

                    // Generate a unique merchant site transaction ID.
                    $transactionId = rand(100000000, 999999999);
                    $amount = $student->balance;

                    try {
                        $response = $this->gateway->authorize([
                            'amount' => $amount,
                            'currency' => 'USD',
                            'transactionId' => $transactionId,
                            'card' => $creditCard,
                        ])->send();
                    } catch(\Exception $e) {
                        return \Redirect::back()->withInput()->withErrors(['card'=>$e->getMessage()]);
                    }

                    if($response->isSuccessful()) {

                        // Captured from the authorization response.
                        $transactionReference = $response->getTransactionReference();

                        $response = $this->gateway->capture([
                            'amount' => $amount,
                            'currency' => 'USD',
                            'transactionReference' => $transactionReference,
                            ])->send();

                        $transaction_id = $response->getTransactionReference();

                        // Insert transaction data into the database
                        $isPaymentExist = Payment::where('transaction_id', $transaction_id)->first();

                        if(!$isPaymentExist)
                        {
                            $student->balance = 0;
                            $student->save();

                            $payment = new Payment;
                            $payment->registration_id = 0;
                            $payment->name = $request->input('firstname')." ".$request->input('lastname');
                            $payment->firstname = $request->input('firstname');
                            $payment->lastname = $request->input('lastname');
                            $payment->address = $request->input('address');
                            $payment->city = $request->input('city');
                            $payment->state = $request->input('state');
                            $payment->zip = $request->input('zip');
                            $payment->transaction_id = $transaction_id;
                            $payment->amount = $amount;
                            $payment->currency = 'USD';
                            $payment->payment_status = 'Captured';
                            $payment->save();

                            $query=\DB::table('settings')->where('name','like','ADMIN_EMAIL%')->get();
                            foreach($query as $item) {
                                \Mail::to($item->value)->send(new \App\Mail\BalancePaidMail($student,$payment));
                            }
                        }
                        return view('balancePayment-confirmation',compact('payment'));
                    } else {
                        return \Redirect::back()->withInput()->withErrors(['card_number'=>[$response->getMessage()]]);
                    }
                } else {
                    return view('balancePayment-confirmation',['nobalance'=>'true']);
                }
            } catch(Exception $e) {
                return \Redirect::back()->withInput()->with('message',$e->getMessage());
            }
        }
        public function freePayment(CardVerificationRequest $request) {
            $validatedData = $request->validated();

            $amount = (float)$validatedData["amount"];
            $newCard = (object)[];

            $newCard->card_number = str_replace(" ","",$request->input('card_number'));
            $newCard->expiration_month = $validatedData["expiration_month"];
            $newCard->expiration_year = $validatedData["expiration_year"];
            $newCard->cvc = $validatedData["cvc"];
            try {
                    $creditCard = new \Omnipay\Common\CreditCard([
                        'number' => $newCard->card_number,
                        'expiryMonth' => $newCard->expiration_month,
                        'expiryYear' => $newCard->expiration_year,
                        'cvv' => $newCard->cvc,
                        "firstName" => $request->input('firstname'),
                        "lastName" => $request->input('lastname'),
                        "billingAddress1" => $request->input('address'),
                        "billingCity" => $request->input('city'),
                        "billingState" => $request->input('state'),
                        "billingPostcode" => $request->input('zip'),
                        "billingCountry" => "USA",
                        "billingPhone" => $request->input('phone'),
                        "email" => $request->input('email')
                    ]);

                    // Generate a unique merchant site transaction ID.
                    $transactionId = rand(100000000, 999999999);

                    try {
                        $response = $this->gateway->authorize([
                            'amount' => $amount,
                            'currency' => 'USD',
                            'transactionId' => $transactionId,
                            'card' => $creditCard,
                        ])->send();
                    } catch(\Exception $e) {
                        return \Redirect::back()->withInput()->withErrors(['card'=>$e->getMessage()]);
                    }

                    if($response->isSuccessful()) {

                        // Captured from the authorization response.
                        $transactionReference = $response->getTransactionReference();

                        $response = $this->gateway->capture([
                            'amount' => $amount,
                            'currency' => 'USD',
                            'transactionReference' => $transactionReference,
                            ])->send();

                        $transaction_id = $response->getTransactionReference();

                        // Insert transaction data into the database
                        $isPaymentExist = Payment::where('transaction_id', $transaction_id)->first();

                        if(!$isPaymentExist)
                        {
                            $payment = new Payment;
                            $payment->registration_id = 0;
                            $payment->name = $request->input('firstname')." ".$request->input('lastname');
                            $payment->firstname = $request->input('firstname');
                            $payment->lastname = $request->input('lastname');
                            $payment->address = $request->input('address');
                            $payment->city = $request->input('city');
                            $payment->state = $request->input('state');
                            $payment->zip = $request->input('zip');
                            $payment->reference = $request->input('reference');
                            $payment->transaction_id = $transaction_id;
                            $payment->amount = $amount;
                            $payment->currency = 'USD';
                            $payment->payment_status = 'Captured';
                            $payment->email = $request->input('email');
                            $payment->save();

                            $query=\DB::table('settings')->where('name','like','ADMIN_EMAIL%')->get();
                            foreach($query as $item) {
                                \Mail::to($item->value)->send(new \App\Mail\FreePaidMail($payment));
                            }
                        }
                        return view('freePayment-confirmation',compact('payment'));
                    } else {
                        return \Redirect::back()->withInput()->withErrors(['card_number'=>[$response->getMessage()]]);
                    }
            } catch(Exception $e) {
                return \Redirect::back()->withInput()->with('message',$e->getMessage());
            }
        }
        */
    public function freePayment(Request $request)
    {
        $reference = $request->reference;
        $amount = (float) str_replace(',', '', $request->amount);

        if ($amount > 0) {
            $anpay = new hostedPaymentRepository;

            $token = $anpay->getHostedFormToken($request, $amount);

            return view('freePayment-auth', compact('token', 'reference', 'amount'));
        } else {
            return \Redirect::route('freePaymentForm')->with('message', 'The amount must be greater than zero.');
        }
    }

    public function freePaymentComplete(Request $request)
    {
        if ($request->amount > 0) {
            $isPaymentExist = Payment::where('transaction_id', $request->transactionid)->first();

            if (! $isPaymentExist) {
                $payment = new Payment;
                $payment->registration_id = 0;
                $payment->name = $request->input('firstname').' '.$request->input('lastname');
                $payment->firstname = $request->input('firstname');
                $payment->lastname = $request->input('lastname');
                $payment->address = $request->input('address');
                $payment->city = $request->input('city');
                $payment->state = $request->input('state');
                $payment->zip = $request->input('zip');
                $payment->reference = $request->input('reference');
                $payment->transaction_id = $request->transactionid;
                $payment->amount = $request->amount;
                $payment->email = $request->input('email');
                $payment->currency = 'USD';
                $payment->payment_status = 'Paid';
                $payment->save();

                foreach (explode(',', getSetting('ADMIN_EMAIL', 'general')) as $email) {
                    \Mail::to(trim($email))->send(new \App\Mail\FreePaidMail($payment));
                }
                // \Mail::to($this->settings->get('ADMIN_EMAIL','general'))->send(new \App\Mail\FreePaidMail($payment));
                // \Mail::to($this->settings->get('ADMIN_EMAIL2','general'))->send(new \App\Mail\FreePaidMail($payment));
            }

            return view('freePayment-confirmation', compact('payment'));
        } else {
            return \Redirect::route('freePaymentForm')->with('message', 'The amount must be greater than zero.');
        }
    }
}
