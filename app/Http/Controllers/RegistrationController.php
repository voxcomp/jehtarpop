<?php

namespace App\Http\Controllers;

use App\Http\Repositories\hostedPaymentRepository;
use App\Models\CorrespondenceCourse;
use App\Models\Course;
use App\Models\Customer;
use App\Models\Event;
use App\Models\OnlineCourse;
use App\Models\Registrant;
use App\Models\Registration;
use App\Models\Student;
use App\Models\Ticket;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function cancelRegistration($path)
    {
        if (session()->has($path.'registration')) {
            session()->forget($path.'registration');
        }

        return \Redirect::route('front');
    }

    public function cancelRegistrationID($path, Registration $registration)
    {
        if (session()->has($path.'registration')) {
            session()->forget($path.'registration');
        }
        $registration->registrants()->delete();
        $registration->delete();

        return \Redirect::route('front');
    }

    // ********************************************
    // ************ COMPANY

    public function showCompany($path, $id = null)
    {
        if (! $this->settings->get($path.'registration', 'status')) {
            return view('closed', ['statusmessage' => $this->settings->get($path.'message', 'status')]);
        } else {
            if (! is_null($id) && $path == 'event') {
                $event = Event::where('event_id', $id)->first();
                if (! is_null($event)) {
                    session()->put('eventid', $event->id);
                }
            }
            //
            // 	    if(session()->has($path.'registration')) {
            // 		    session()->forget($path.'registration');
            // 		}

            if (session()->has($path.'registration')) {
                $register = session()->get($path.'registration');
                if (isset($register['coid']) && $register['coid'] == '7617') {
                    return \Redirect::route('registration.individual', $path);
                } else {
                    if (isset($register['name'])) {
                        return view('registration.company', ['path' => $path, 'customers' => Customer::all(), 'register' => $register]);
                    } else {
                        return view('registration.company', ['path' => $path, 'customers' => Customer::all()]);
                    }
                }
            } else {
                return view('registration.company', ['path' => $path, 'customers' => Customer::all()]);
            }
        }
    }

    public function saveCompany(Request $request, $path)
    {
        $this->validate($request, [
            'name' => 'nullable|string|max:200',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:200',
            'city' => 'required|string|max:200',
            'state' => 'required|string|max:50',
            'zip' => 'required|string|max:11',
            'contactfname' => 'required|string|max:100',
            'contactlname' => 'required|string|max:100',
            'cphone' => 'required|string|max:20',
            'cemail' => 'required|email:rfc,dns|max:200',
        ]);
        $check = $this->checkCompanyBalance($request);
        if ($check !== false) {
            return back()->withInput()->with('errormessage', 'This company has an outstanding balance and cannot register until that balance is paid in full.<br><strong>Please contact our office at 781-270-9990.</strong>');
        }

        $registration = $request->all();
        if (isset($registration['company']) && $registration['company'] != 0) {
            $company = Customer::select('coid', 'name', 'member')->where('id', $registration['company'])->get()->first();
            $registration['coid'] = $company->coid;
            $registration['name'] = $company->name;
            if (! empty($company->member)) {
                $registration['member'] = true;
            } else {
                $registration['member'] = false;
            }
        } else {
            $registration['member'] = false;
        }
        $registration['registrants'] = [];
        $request->session()->put($path.'registration', $registration);

        return \Redirect::route('registration.registrant', $path);
    }

    public function updateCompany(Request $request, $path)
    {
        $this->validate($request, [
            'name' => 'nullable|string|max:200',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:200',
            'city' => 'required|string|max:200',
            'state' => 'required|string|max:50',
            'zip' => 'required|string|max:11',
            'contactfname' => 'required|string|max:100',
            'contactlname' => 'required|string|max:100',
            'cphone' => 'required|string|max:20',
            'cemail' => 'required|email|max:200',
        ]);
        $check = $this->checkCompanyBalance($request);
        if ($check !== false) {
            return back()->withInput()->with('errormessage', 'This company has an outstanding balance and cannot register until that balance is paid in full.<br><strong>Please contact our office at 781-270-9990.</strong>');
        }

        $registration = $request->session()->get($path.'registration');
        $updates = $request->all();
        foreach ($updates as $key => $update) {
            if (strpos($key, '_') === false) {
                $registration[$key] = $update;
            }
        }

        if ($request->company != 0) {
            $company = Customer::select('coid', 'name', 'member')->where('id', $request->company)->get()->first();
            $registration['coid'] = $company->coid;
            $registration['name'] = $company->name;
            if (! empty($company->member)) {
                $registration['member'] = true;
            } else {
                $registration['member'] = false;
            }
        } else {
            $registration['member'] = false;
        }
        $request->session()->put($path.'registration', $registration);

        return \Redirect::route('registration.registrant', $path);
    }

    // ********************************************
    // ************ REGISTRANT

    public function registrantShow($path = 'event')
    {
        if (! session()->has($path.'registration')) {
            return \Redirect::route('registration.company', $path);
        }
        $registration = session()->get($path.'registration');
        switch ($path) {
            case 'trade':
                $classes = Course::distinct()->get()->pluck('tradedesc', 'trade')->toArray();
                break;
            case 'event': $classes = Event::select('id', 'name')->where('event', 1)->get()->pluck('name', 'id')->toArray();
                break;
            case 'training': $classes = Event::select('id', 'name')->where('event', 0)->get()->pluck('name', 'id')->toArray();
                break;
            case 'online': $classes = OnlineCourse::distinct()->get()->pluck('courseid', 'id')->toArray();
                break;
            case 'correspondence': $classes = CorrespondenceCourse::distinct()->where('trade', '<>', '')->get()->pluck('tradedesc', 'trade')->toArray();
                break;
                break;
        }
        $first = (empty($registration['registrants'])) ? true : false;

        $eventid = '';
        if (session()->has('eventid')) {
            $eventid = session()->get('eventid');
        }

        if (isset($registration['coid']) && ! empty($registration['coid'])) {
            $students = Student::select('id')->selectRaw('concat(last,", ",first) as name')->where('coid', $registration['coid'])->orderBy('last', 'asc')->orderBy('first', 'asc')->get()->pluck('name', 'id')->toArray();
        } else {
            $students = [];
        }

        return view('registration.registrant', compact('path', 'registration', 'classes', 'first', 'eventid', 'students'));
    }

    public function registrantSave(Request $request, $path)
    {
        $validate = [
            'firstname' => 'required|string|max:100',
            'lastname' => 'required|string|max:100',
            'mobile' => 'required|string|max:20',
            'email' => 'required|email|max:200',
            'address' => 'required|string|max:200',
            'city' => 'required|string|max:200',
            'state' => 'required|string|max:50',
            'zip' => 'required|string|max:11',
            /* 'cost' => 'required|numeric', */
        ];
        switch ($path) {
            case 'training':
            case 'event':
                $validate['event-ticket'] = 'required|not_in:0';
                break;
            case 'trade':
                $validate['dob'] = 'required|date_format:m/d/Y|max:10';
                $validate['course-id'] = 'required|integer|min:1';
                break;
            case 'online':
                $validate['course-id'] = 'required|integer|min:1';
                break;
            case 'correspondence':
                $validate['course-id'] = 'required|integer|min:1';
                break;
        }
        $this->validate($request, $validate);
        $check = $this->checkStudentBalance($request);
        if ($check !== false) {
            return back()->withInput()->with('errormessage', 'This person has an outstanding balance and cannot be registered until that balance is paid in full.<br><a href="/balance/'.$check.'">The balance can be paid online here.</a>');
        }

        $registration = $request->session()->get($path.'registration');
        $registration['registrants'][] = $request->all();
        /*
                switch($path) {
                    case "event":
                        $registration['registrants'][array_key_last($registration['registrants'])]['ticket_id'] = $request->input('event-ticket');
                        $ticket = Ticket::where('id',$request->input('event-ticket'))->first();
                        $registration['registrants'][array_key_last($registration['registrants'])]['ticket'] = $ticket->name;
                        $registration['registrants'][array_key_last($registration['registrants'])]['class'] = $ticket->event->name;
                        break;
                    case "trade":
                        $registration['registrants'][array_key_last($registration['registrants'])]['class'] = Course::where('id',$request->input('course-id'))->get('courseid')->pop()->courseid;
                        $registration['registrants'][array_key_last($registration['registrants'])]['schoolyear'] = Course::where('id',$request->input('course-id'))->get('schoolyear')->pop()->courseid;
                        break;
                    case "online":
                        $registration['registrants'][array_key_last($registration['registrants'])]['class'] = OnlineCourse::where('id',$request->input('course-id'))->get('courseid')->pop()->courseid;
                        $registration['registrants'][array_key_last($registration['registrants'])]['schoolyear'] = OnlineCourse::where('id',$request->input('course-id'))->get('schoolyear')->pop()->schoolyear;
                        break;
                    case "correspondence":
                        $registration['registrants'][array_key_last($registration['registrants'])]['class'] = CorrespondenceCourse::where('id',$request->input('course-id'))->get('courseid')->pop()->courseid;
                        $registration['registrants'][array_key_last($registration['registrants'])]['schoolyear'] = CorrespondenceCourse::where('id',$request->input('course-id'))->get('schoolyear')->pop()->schoolyear;
                        break;
                }
        */
        try {
            switch ($path) {
                case 'training':
                case 'event':
                    $registration['registrants'][array_key_last($registration['registrants'])]['ticket_id'] = $request->input('event-ticket');
                    $ticket = Ticket::where('id', $request->input('event-ticket'))->first();
                    $registration['registrants'][array_key_last($registration['registrants'])]['ticket'] = $ticket->name;
                    $registration['registrants'][array_key_last($registration['registrants'])]['class'] = $ticket->event->name;
                    $registration['registrants'][array_key_last($registration['registrants'])]['cost'] = ($registration['member'] === false) ? $ticket->nonmember : $ticket->member;
                    break;
                case 'trade':
                    $course = Course::where('id', $request->input('course-id'))->first();
                    $registration['registrants'][array_key_last($registration['registrants'])]['class'] = $course->courseid;
                    $registration['registrants'][array_key_last($registration['registrants'])]['schoolyear'] = $course->schoolyear;
                    $registration['registrants'][array_key_last($registration['registrants'])]['cost'] = ($registration['member'] === false) ? $course->nonmember : $course->member;
                    /*
                                        $registration['registrants'][array_key_last($registration['registrants'])]['class'] = Course::where('id',$request->input('course-id'))->get('courseid')->pop()->courseid;
                                        $registration['registrants'][array_key_last($registration['registrants'])]['schoolyear'] = Course::where('id',$request->input('course-id'))->get('schoolyear')->pop()->courseid;
                    */
                    break;
                case 'online':
                    $course = OnlineCourse::where('id', $request->input('course-id'))->first();
                    $registration['registrants'][array_key_last($registration['registrants'])]['class'] = $course->courseid;
                    $registration['registrants'][array_key_last($registration['registrants'])]['schoolyear'] = $course->schoolyear;
                    $registration['registrants'][array_key_last($registration['registrants'])]['cost'] = ($registration['member'] === false) ? $course->nonmember : $course->member;
                    /*
                                        $registration['registrants'][array_key_last($registration['registrants'])]['class'] = OnlineCourse::where('id',$request->input('course-id'))->get('courseid')->pop()->courseid;
                                        $registration['registrants'][array_key_last($registration['registrants'])]['schoolyear'] = OnlineCourse::where('id',$request->input('course-id'))->get('schoolyear')->pop()->schoolyear;
                    */
                    break;
                case 'correspondence':
                    $course = CorrespondenceCourse::where('id', $request->input('course-id'))->first();
                    $registration['registrants'][array_key_last($registration['registrants'])]['class'] = $course->courseid;
                    $registration['registrants'][array_key_last($registration['registrants'])]['schoolyear'] = $course->schoolyear;
                    $registration['registrants'][array_key_last($registration['registrants'])]['cost'] = ($registration['member'] === false) ? $course->nonmember : $course->member;
                    /*
                                        $registration['registrants'][array_key_last($registration['registrants'])]['class'] = CorrespondenceCourse::where('id',$request->input('course-id'))->get('courseid')->pop()->courseid;
                                        $registration['registrants'][array_key_last($registration['registrants'])]['schoolyear'] = CorrespondenceCourse::where('id',$request->input('course-id'))->get('schoolyear')->pop()->schoolyear;
                    */
                    break;
            }
        } catch (\Exception $e) {
            return back()->withInput()->with('errormessage', 'Course selected was not found.');
        }
        $request->session()->put($path.'registration', $registration);

        if (isset($request->step) && $request->step == 'add') {
            return \Redirect::route('registration.registrant', $path);
        } else {
            return \Redirect::route('registration.payment', $path);
        }
    }

    public function registrantRemove($path, $index)
    {
        if (session()->has($path.'registration')) {
            $registration = session()->get($path.'registration');

            if (isset($registration['registrants'][$index])) {
                unset($registration['registrants'][$index]);
            }
            session()->put($path.'registration', $registration);

            return \Redirect::route('registration.registrant', [$path])->with('message', 'Registrant has been removed.');
        }

        return \Redirect::route('registration.registrant', [$path]);
    }

    // ********************************************
    // ************ INDIVIDUAL

    public function individualShow($path)
    {
        if (! $this->settings->get($path.'registration', 'status')) {
            return view('closed', ['statusmessage' => $this->settings->get($path.'message', 'status')]);
        } else {
            $customers = Customer::all();
            switch ($path) {
                case 'trade': $classes = Course::distinct()->get()->pluck('tradedesc', 'trade')->toArray();
                    break;
                case 'event': $classes = Event::select('id', 'name')->where('event', 1)->get()->pluck('name', 'id')->toArray();
                    break;
                case 'training': $classes = Event::select('id', 'name')->where('event', 0)->get()->pluck('name', 'id')->toArray();
                    break;
                    //				case 'event': $classes = Event::select('id','name')->get()->pluck('name','id')->toArray(); break;
                case 'online': $classes = OnlineCourse::distinct()->get()->pluck('courseid', 'id')->toArray();
                    break;
                case 'correspondence': $classes = CorrespondenceCourse::distinct()->where('trade', '<>', '')->get()->pluck('tradedesc', 'trade')->toArray();
                    break;
                    break;
            }
            $eventid = '';
            if (session()->has('eventid')) {
                $eventid = session()->get('eventid');
            }

            if (session()->has($path.'registration')) {
                $register = session()->get($path.'registration');
                if (isset($register['coid']) && $register['coid'] != '7617') {
                    return \Redirect::route('registration.company', $path);
                }
                $registrant = array_shift($register['registrants']);

                return view('registration.individual', compact('path', 'registrant', 'customers', 'classes', 'eventid'));
            } else {
                return view('registration.individual', compact('path', 'customers', 'classes', 'eventid'));
            }
        }
    }

    public function individualSave(Request $request, $path)
    {
        $validate = [
            'firstname' => 'required|string|max:100',
            'lastname' => 'required|string|max:100',
            'mobile' => 'required|string|max:20',
            'email' => 'required|email|max:200',
            'address' => 'required|string|max:200',
            'city' => 'required|string|max:200',
            'state' => 'required|string|max:50',
            'zip' => 'required|string|max:11',
            'cost' => 'required|numeric',
        ];
        switch ($path) {
            case 'training':
            case 'event':
                $validate['event-ticket'] = 'required|not_in:0';
                break;
            case 'trade':
                $validate['dob'] = 'required|date_format:m/d/Y|max:10';
                $validate['course-id'] = 'required|integer|min:1';
                break;
            case 'online':
                $validate['course-id'] = 'required|integer|min:1';
                break;
            case 'correspondence':
                $validate['course-id'] = 'required|integer|min:1';
                break;
        }
        $this->validate($request, $validate);

        $check = $this->checkStudentBalance($request);
        if ($check !== false) {
            return back()->withInput()->with('errormessage', 'You have an outstanding balance and cannot register. <a href="/balance/'.$check.'">Click here to pay the balance online</a> to continue registering.');
        }

        $registrant = $request->all();
        $registration = [];
        $registration['name'] = 'Self Students';
        $registration['coid'] = '7617';
        $registration['phone'] = '';
        $registration['address'] = '';
        $registration['city'] = '';
        $registration['state'] = '';
        $registration['zip'] = '';
        $registration['contactfname'] = '';
        $registration['contactlname'] = '';
        $registration['cphone'] = '';
        $registration['cemail'] = '';
        $registration['member'] = false;
        $registration['registrants'] = [];
        unset($registrant['company']);
        $registration['registrants'][] = $registrant;
        try {
            switch ($path) {
                case 'training':
                case 'event':
                    $registration['registrants'][array_key_last($registration['registrants'])]['ticket_id'] = $request->input('event-ticket');
                    $ticket = Ticket::where('id', $request->input('event-ticket'))->first();
                    $registration['registrants'][array_key_last($registration['registrants'])]['ticket'] = $ticket->name;
                    $registration['registrants'][array_key_last($registration['registrants'])]['class'] = $ticket->event->name;
                    $registration['registrants'][array_key_last($registration['registrants'])]['cost'] = ($registration['member'] === false) ? $ticket->nonmember : $ticket->member;
                    break;
                case 'trade':
                    $course = Course::where('id', $request->input('course-id'))->first();
                    $registration['registrants'][array_key_last($registration['registrants'])]['class'] = $course->courseid;
                    $registration['registrants'][array_key_last($registration['registrants'])]['schoolyear'] = $course->schoolyear;
                    $registration['registrants'][array_key_last($registration['registrants'])]['cost'] = ($registration['member'] === false) ? $course->nonmember : $course->member;
                    /*
                                        $registration['registrants'][array_key_last($registration['registrants'])]['class'] = Course::where('id',$request->input('course-id'))->get('courseid')->pop()->courseid;
                                        $registration['registrants'][array_key_last($registration['registrants'])]['schoolyear'] = Course::where('id',$request->input('course-id'))->get('schoolyear')->pop()->courseid;
                    */
                    break;
                case 'online':
                    $course = OnlineCourse::where('id', $request->input('course-id'))->first();
                    $registration['registrants'][array_key_last($registration['registrants'])]['class'] = $course->courseid;
                    $registration['registrants'][array_key_last($registration['registrants'])]['schoolyear'] = $course->schoolyear;
                    $registration['registrants'][array_key_last($registration['registrants'])]['cost'] = ($registration['member'] === false) ? $course->nonmember : $course->member;
                    /*
                                        $registration['registrants'][array_key_last($registration['registrants'])]['class'] = OnlineCourse::where('id',$request->input('course-id'))->get('courseid')->pop()->courseid;
                                        $registration['registrants'][array_key_last($registration['registrants'])]['schoolyear'] = OnlineCourse::where('id',$request->input('course-id'))->get('schoolyear')->pop()->schoolyear;
                    */
                    break;
                case 'correspondence':
                    $course = CorrespondenceCourse::where('id', $request->input('course-id'))->first();
                    $registration['registrants'][array_key_last($registration['registrants'])]['class'] = $course->courseid;
                    $registration['registrants'][array_key_last($registration['registrants'])]['schoolyear'] = $course->schoolyear;
                    $registration['registrants'][array_key_last($registration['registrants'])]['cost'] = ($registration['member'] === false) ? $course->nonmember : $course->member;
                    /*
                                        $registration['registrants'][array_key_last($registration['registrants'])]['class'] = CorrespondenceCourse::where('id',$request->input('course-id'))->get('courseid')->pop()->courseid;
                                        $registration['registrants'][array_key_last($registration['registrants'])]['schoolyear'] = CorrespondenceCourse::where('id',$request->input('course-id'))->get('schoolyear')->pop()->schoolyear;
                    */
                    break;
            }
        } catch (\Exception $e) {
            return back()->withInput()->with('errormessage', 'Course selected was not found.');
        }
        $request->session()->put($path.'registration', $registration);

        return \Redirect::route('registration.payment', $path);
    }

    // ********************************************
    // ************ BILLING
    public function billing($path, Registration $registration)
    {
        $payment = $registration->payment()->where('payment_status', 'hold')->first();
        if ($registration->balance > 0 && ! is_null($payment)) {
            return view('registration.billing', compact('path', 'registration', 'payment'));
        } else {
            return \Redirect::route('registration.company', $path)->with('message', 'The specified registration already has a payment applied.');
        }
    }

    public function saveBilling($path, Registration $registration, Request $request)
    {
        $this->validate($request, [
            'firstname' => 'required|string|max:200',
            'lastname' => 'required|string|max:200',
            'address' => 'required|string|max:200',
            'city' => 'required|string|max:200',
            'state' => 'required|string|max:50',
            'zip' => 'required|string|max:11',
        ]);
        $payment = $registration->payment()->where('payment_status', 'hold')->first();
        if ($registration->balance > 0 && ! is_null($payment)) {
            $payment->name = $request->firstname.' '.$request->lastname;
            $payment->firstname = $request->firstname;
            $payment->lastname = $request->lastname;
            $payment->address = $request->address;
            $payment->city = $request->city;
            $payment->state = $request->state;
            $payment->zip = $request->zip;
            $payment->save();

            $anpay = new hostedPaymentRepository;
            $token = $anpay->getHostedFormTokenFromPayment($payment);

            return view('registration.payment-auth', compact('token', 'registration', 'path', 'payment'));
        } else {
            return \Redirect::route('registration.company', $path)->with('message', 'The specified registration already has a payment applied.');
        }
    }

    // ********************************************
    // ************ CONFIRMATION

    public function confirmation($path, Registration $registration)
    {
        // \Mail::to("gwgci@voxcomp.com")->send(new \App\Mail\SendPaymentConfirmation($registration));
        return view('registration.confirmation', compact('path', 'registration'));
    }
}
