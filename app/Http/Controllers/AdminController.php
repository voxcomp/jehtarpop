<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Exports\CorrespondenceRegistrationsExport;
use App\Exports\DonationsExport;
use App\Exports\EventRegistrationsExport;
use App\Exports\OnlineRegistrationsExport;
use App\Exports\RegistrationsExport;
use App\Imports\CorrespondenceImport;
use App\Imports\CoursesImport;
use App\Imports\CustomersImport;
use App\Imports\EventsImport;
use App\Imports\OnlineImport;
use App\Imports\StudentsImport;
use App\Imports\TicketsImport;
use App\Models\CorrespondenceCourse;
use App\Models\Coupon;
use App\Models\Course;
use App\Models\Customer;
use App\Models\Description;
use App\Models\Donation;
use App\Models\Event;
use App\Models\OnlineCourse;
use App\Models\Registration;
use App\Models\Sponsoritem;
use App\Models\Student;
use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware('admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(): View
    {
        // $status=array();
        // $status['settings']['general']=(object)$this->settings->getGroup('general')->pluck('s_value','s_name')->all();
        // $status['settings']['editor']=(object)$this->settings->getGroup('editor')->pluck('s_value','s_name')->all();
        // $status['settings']['status']=(object)$this->settings->getGroup('status')->pluck('s_value','s_name')->all();
        // $status['settings']['donation']=(object)$this->settings->getGroup('donation')->pluck('s_value','s_name')->all();
        // $status['settings']['agreement']=(object)$this->settings->getGroup('agreement')->pluck('s_value','s_name')->all();
        // $status['settings']['api']=(object)$this->settings->getGroup('api')->pluck('s_value','s_name')->all();
        // $status['customers'] = Customer::where('inhouse',0)->orderby('name','ASC')->get()->pluck('name','id')->toArray();
        // $status['customersih'] = Customer::where('inhouse',1)->orderby('name','ASC')->get()->pluck('name','id')->toArray();
        // $status['sponsoritems'] = Sponsoritem::get();
        // $status['classlist'] = array_merge([0=>"Choose Class"],Course::orderBy('courseid')->get()->pluck('courseid','id')->toArray());
        // $status['eventitems'] = Event::where('event',1)->get()->pluck('name','id');
        // $status['eventlist'] = Event::orderBy('name','ASC')->get()->pluck('name','id')->toArray();
        $registrations = Registration::whereDate('created_at', '>=', Carbon::now()->subDays(90)->toDateTimeString())->get();

        // $companies = Registration::where('coid','<>',7617)->where('paytype','<>','hold')->whereDate('created_at', ">=", Carbon::now()->subDays(60)->toDateTimeString())->get();
        // $individuals = Registration::where('coid',7617)->where('paytype','<>','hold')->whereDate('created_at', ">=", Carbon::now()->subDays(60)->toDateTimeString())->get();
        // $hold = Registration::where('paytype','hold')->whereDate('created_at', ">=", Carbon::now()->subDays(60)->toDateTimeString())->get();
        return view('home', compact('registrations'));
    }

    public function settingsGeneral(): View
    {
        $status = [];
        $status['settings']['general'] = (object) $this->settings->getGroup('general')->pluck('s_value', 's_name')->all();
        $status['settings']['donation'] = (object) $this->settings->getGroup('donation')->pluck('s_value', 's_name')->all();
        $status['settings']['api'] = (object) $this->settings->getGroup('api')->pluck('s_value', 's_name')->all();
        $status['sponsoritems'] = Sponsoritem::get();

        return view('admin.settings.general', $status);
    }

    public function settingsContent(): View
    {
        $hd_company = $this->settings->get('hd_company', 'editor');
        if (is_null($hd_company)) {
            $this->settings->set('Company Information Help', 'hd_company', '', 'editor', '', '', 'text');
            $this->settings->set('Registrant Help', 'hd_registrant', '', 'editor', '', '', 'text');
            $this->settings->set('Billing Help', 'hd_billing', '', 'editor', '', '', 'text');
            $this->settings->set('Payment Help', 'hd_payment', '', 'editor', '', '', 'text');
            $this->settings->set('Individual Help', 'hd_individual', '', 'editor', '', '', 'text');
        }
        $status = [];
        $status['settings']['editor'] = (object) $this->settings->getGroup('editor')->pluck('s_value', 's_name')->all();

        return view('admin.settings.content', $status);
    }

    public function settingsRegistration(): View
    {
        $status = [];
        $status['settings']['status'] = (object) $this->settings->getGroup('status')->pluck('s_value', 's_name')->all();
        $status['customers'] = Customer::where('inhouse', 0)->orderby('name', 'ASC')->get()->pluck('name', 'id')->toArray();
        $status['customersih'] = Customer::where('inhouse', 1)->orderby('name', 'ASC')->get()->pluck('name', 'id')->toArray();
        $status['eventitems'] = Event::where('event', 1)->get()->pluck('name', 'id');
        $status['eventlist'] = Event::orderBy('name', 'ASC')->get()->pluck('name', 'id')->toArray();

        return view('admin.settings.registration', $status);
    }

    public function settingsRegistrationContent(): View
    {
        $status = [];
        $status['settings']['editor'] = (object) $this->settings->getGroup('editor')->pluck('s_value', 's_name')->all();
        $status['settings']['agreement'] = (object) $this->settings->getGroup('agreement')->pluck('s_value', 's_name')->all();
        $status['classlist'] = array_merge([0 => 'Choose Class'], Course::orderBy('courseid')->get()->pluck('courseid', 'id')->toArray());

        return view('admin.settings.registrationcontent', $status);
    }

    public function registrationStatus(Request $request)
    {
        $all = $request->all();
        unset($all['_token']);
        foreach ($all as $key => $value) {
            $this->settings->update($key, 'status', $value);
            //		    \DB::table('settings')->where('name',$key)->update(['value'=>$each]);
        }

        return redirect()->route('settings.registration')->with('message', 'Registration status updated');
        //		return $this->index();
    }

    public function paymentAgree(Request $request)
    {
        if (isset($request->paymentAgree)) {
            $this->settings->update('paymentAgree', 'editor', $request->paymentAgree);
            //			\DB::table('settings')->where('name','paymentAgree')->update(['value'=>htmlentities($request->paymentAgree)]);
        }

        return redirect()->route('settings.registrationContent')->with('message', 'Payment agreement updated');
        //		return $this->index();
    }

    public function confirmationEmail(Request $request)
    {
        if (isset($request->tradeConfirmation)) {
            $this->settings->update('tradeconfirmation', 'editor', $request->tradeConfirmation);
        }
        if (isset($request->correspondenceConfirmation)) {
            $this->settings->update('correspondenceconfirmation', 'editor', $request->correspondenceConfirmation);
        }
        if (isset($request->eventConfirmation)) {
            $this->settings->update('eventconfirmation', 'editor', $request->eventConfirmation);
        }
        if (isset($request->onlineConfirmation)) {
            $this->settings->update('onlineconfirmation', 'editor', $request->onlineConfirmation);
        }
        if (isset($request->trainingConfirmation)) {
            $this->settings->update('trainingconfirmation', 'editor', $request->trainingConfirmation);
        }

        return redirect()->route('settings.content')->with('message', 'Registration confirmation email updated');
        //		return $this->index();
    }

    public function eventsMark(Request $request)
    {
        Event::query()->update(['event' => 0]);
        if ($request->events) {
            Event::whereIn('id', $request->events)->update(['event' => 1]);
        }

        return redirect()->route('settings.registration')->with('message', 'Events updated');
        // return $this->index();
    }

    public function customerAddInHouse(Request $request)
    {
        if ($request->customers) {
            Customer::whereIn('id', $request->customers)->update(['inhouse' => 1]);
        }

        return redirect()->route('settings.registration')->with('message', 'In-House updated');
        //		return $this->index();
    }

    public function customerRemoveInHouse(Request $request)
    {
        Customer::whereIn('id', $request->customers)->update(['inhouse' => 0]);

        return redirect()->route('settings.registration')->with('message', 'In-House updated');
        //		return $this->index();
    }

    public function fundraising(Request $request)
    {
        $this->settings->update('fund_goal', 'donation', $request->fund_goal);
        //		\DB::table('settings')->where('name','fund_goal')->update(['value'=>$request->fund_goal]);
        $this->settings->update('payment_limit', 'donation', $request->payment_limit);

        //		\DB::table('settings')->where('name','payment_limit')->update(['value'=>$request->payment_limit]);
        return redirect()->route('settings.general')->with('message', 'Fundraising amounts updated');
        //		return $this->index();
    }

    public function adminEmail(Request $request)
    {
        if (isset($request->ADMIN_EMAIL)) {
            $this->settings->update('ADMIN_EMAIL', 'general', $request->ADMIN_EMAIL);
            //		    \DB::table('settings')->where('name','ADMIN_EMAIL')->update(['value'=>$request->ADMIN_EMAIL]);
        }

        //	    if(isset($request->ADMIN_EMAIL2)) {
        //			$this->settings->update('ADMIN_EMAIL2','general',$request->ADMIN_EMAIL2);
        //		    \DB::table('settings')->where('name','ADMIN_EMAIL2')->update(['value'=>$request->ADMIN_EMAIL2]);
        //		}
        return redirect()->route('settings.general')->with('message', 'Administrator email updated');
        //		return $this->index();
    }

    public function adminAPI(Request $request)
    {
        if (isset($request->api_login)) {
            $this->settings->update('api_login', 'api', $request->api_login);
            //		    \DB::table('settings')->where('name','api_login')->update(['value'=>\Crypt::encrypt($request->api_login)]);
        }
        if (isset($request->transaction_key)) {
            $this->settings->update('transaction_key', 'api', $request->transaction_key);
            //		    \DB::table('settings')->where('name','transaction_key')->update(['value'=>\Crypt::encrypt($request->transaction_key)]);
        }

        return redirect()->route('settings.general')->with('message', 'API updated');
        //		return $this->index();
    }

    public function uploads(): View
    {
        return view('admin.uploads');
    }

    public function customerUpload(Request $request)
    {

        if ($request->file('customers')->isValid()) {
            Customer::truncate();

            \Excel::import(new CustomersImport, $request->file('customers'));
        }

        return \Redirect::route('admin.uploads')->with('message', 'Company/Customer upload completed successfully');
    }

    public function studentUpload(Request $request)
    {

        if ($request->file('students')->isValid()) {
            Student::truncate();

            \Excel::import(new StudentsImport, $request->file('students'));
        }

        return \Redirect::route('admin.uploads')->with('message', 'Students upload completed successfully');
    }

    public function courseUpload(Request $request)
    {
        if ($request->file('courses')->isValid()) {
            Course::truncate();

            \Excel::import(new CoursesImport, $request->file('courses'));
        }

        return \Redirect::route('admin.uploads')->with('message', 'Course upload completed successfully');
    }

    public function onlineClassUpload(Request $request)
    {

        if ($request->file('courses')->isValid()) {
            OnlineCourse::truncate();

            \Excel::import(new OnlineImport, $request->file('courses'));
        }

        return \Redirect::route('admin.uploads')->with('message', 'Online class upload completed successfully');
    }

    public function correspondenceClassUpload(Request $request)
    {

        if ($request->file('courses')->isValid()) {
            CorrespondenceCourse::truncate();

            \Excel::import(new CorrespondenceImport, $request->file('courses'));
        }

        return \Redirect::route('admin.uploads')->with('message', 'Correspondence class upload completed successfully');
    }

    public function eventUpload(Request $request)
    {

        if ($request->file('events')->isValid()) {
            Event::truncate();

            \Excel::import(new eventsImport, $request->file('events'));
        }

        return \Redirect::route('admin.uploads')->with('message', 'Event upload completed successfully');
    }

    public function ticketUpload(Request $request)
    {

        if ($request->file('tickets')->isValid()) {
            Ticket::truncate();

            \Excel::import(new ticketsImport, $request->file('tickets'));
        }

        return \Redirect::route('admin.uploads')->with('message', 'Ticket upload completed successfully');
    }

    public function donationsViewPage(): View
    {
        return view('admin.view-donations-dashboard');
    }

    public function donationsView(Request $request)
    {
        $this->validate($request, [
            'start' => 'required|date_format:m/d/Y|max:10',
            'end' => 'required|date_format:m/d/Y|max:10',
        ]);

        $query = Donation::where('created_at', '>=', date('Y/m/d', strtotime($request->input('start'))).' 0:01:00')->where('created_at', '<=', date('Y/m/d', strtotime($request->input('end'))).' 23:59:00');
        if (isset($request->hold) && $request->hold == 1) {
            $query->where('paytype', '=', 'hold');
        } else {
            $query->where('paytype', '<>', 'hold');
        }
        $donations = $query->get();
        if (is_null($donations)) {
            return \Redirect::route('admin.viewDonationsPage')->with('message', 'There are no donations to view for the chosen time period.');
        }

        return view('admin.view-donations', compact('donations'));
    }

    public function registrationViewPage(): View
    {
        return view('admin.view-registrations-dashboard');
    }

    public function registrationView(Request $request)
    {
        $this->validate($request, [
            'start' => 'required|date_format:m/d/Y|max:10',
            'end' => 'required|date_format:m/d/Y|max:10',
        ]);
        // ->where('paytype','<>','none')
        $query = Registration::where('regtype', \Crypt::decrypt($request->input('regtype')))->where('created_at', '>=', date('Y/m/d', strtotime($request->input('start'))).' 0:01:00')->where('created_at', '<=', date('Y/m/d', strtotime($request->input('end'))).' 23:59:00');
        if (isset($request->hold) && $request->hold == 1) {
            $query->where('paytype', '=', 'hold');
        } else {
            $query->where('paytype', '<>', 'hold');
        }
        $registrations = $query->get();
        if (is_null($registrations) || $registrations->count() == 0) {
            return \Redirect::route('admin.viewRegistrations')->with('message', 'There are no '.\Crypt::decrypt($request->input('regtype')).' registrations to view for the chosen time period.');
        }
        if (\Crypt::decrypt($request->input('regtype')) == 'trade') {
            return view('admin.view-registrations', compact('registrations'));
        } elseif (\Crypt::decrypt($request->input('regtype')) == 'event' || \Crypt::decrypt($request->input('regtype')) == 'training') {
            return view('admin.view-event-registrations', compact('registrations'));
        } elseif (\Crypt::decrypt($request->input('regtype')) == 'online') {
            return view('admin.view-online-registrations', compact('registrations'));
        } elseif (\Crypt::decrypt($request->input('regtype')) == 'correspondence') {
            return view('admin.view-correspondence-registrations', compact('registrations'));
        }
    }

    public function downloads(): View
    {
        return view('admin.downloads');
    }

    public function donationsDownload(Request $request)
    {
        $this->validate($request, [
            'start' => 'required|date_format:m/d/Y|max:10',
            'end' => 'required|date_format:m/d/Y|max:10',
        ]);
        $donations = Donation::where('paytype', '<>', 'hold')->where('created_at', '>=', date('Y/m/d', strtotime($request->input('start'))).' 0:01:00')->where('created_at', '<=', date('Y/m/d', strtotime($request->input('end'))).' 23:59:00')->get();
        if (is_null($donations)) {
            return \Redirect::route('admin.downloads')->with('message', 'There are no donations to download for the chosen time period.');
        }

        return \Excel::download(new DonationsExport($request->start, $request->end), 'tempWebDonations.xlsx');
    }

    public function registrationDownload(Request $request)
    {
        $this->validate($request, [
            'start' => 'required|date_format:m/d/Y|max:10',
            'end' => 'required|date_format:m/d/Y|max:10',
        ]);
        // ->where('paytype','<>','none')
        $query = Registration::where('regtype', \Crypt::decrypt($request->input('regtype')))->where('created_at', '>=', date('Y/m/d', strtotime($request->input('start'))).' 0:01:00')->where('created_at', '<=', date('Y/m/d', strtotime($request->input('end'))).' 23:59:00');
        if (isset($request->hold) && $request->hold == 1) {
            $query->where('paytype', '=', 'hold');
        } else {
            $query->where('paytype', '<>', 'hold');
        }
        $registrations = $query->get();
        // $registrations = Registration::where('regtype',\Crypt::decrypt($request->input('regtype')))->where('paytype','<>','hold')->where('created_at','>=',date("Y/m/d",strtotime($request->input('start'))).' 0:01:00')->where('created_at','<=',date("Y/m/d",strtotime($request->input('end'))).' 23:59:00')->get();
        if (is_null($registrations) || $registrations->count() == 0) {
            return \Redirect::route('admin.downloads')->with('message', 'There are no '.\Crypt::decrypt($request->input('regtype')).' registrations to download for the chosen time period.');
        }
        $hold = (isset($request->hold) && $request->hold == 1) ? true : false;
        if (\Crypt::decrypt($request->input('regtype')) == 'trade') {
            return \Excel::download(new RegistrationsExport($request->start, $request->end, $hold), 'tempWebRegEdu.xlsx');
        } elseif (\Crypt::decrypt($request->input('regtype')) == 'event' || \Crypt::decrypt($request->input('regtype')) == 'training') {
            return \Excel::download(new EventRegistrationsExport(\Crypt::decrypt($request->input('regtype')), $request->start, $request->end, $hold), 'tempWebReg.xlsx');
        } elseif (\Crypt::decrypt($request->input('regtype')) == 'correspondence') {
            return \Excel::download(new CorrespondenceRegistrationsExport($request->start, $request->end, $hold), 'tempWebRegEdu.xlsx');
        } elseif (\Crypt::decrypt($request->input('regtype')) == 'online') {
            return \Excel::download(new OnlineRegistrationsExport($request->start, $request->end, $hold), 'tempWebRegEdu.xlsx');
        }
    }

    public function classDescription(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
            'description' => 'required|max:1000',
        ]);

        Description::updateOrCreate(['courseid' => $request->id], ['courseid' => $request->id, 'description' => $request->description]);
        echo 'Class description updated.';
        exit();
    }

    public function addAgreement(Request $request)
    {
        $this->validate($request, [
            'trade' => 'required',
            'message' => 'required|max:400',
        ]);

        $this->settings->set('t_'.$request->trade, 't_'.$request->trade, $request->message, 'agreement', '', '', 'text');
        // \DB::table('settings')->insert([
        // 	'name'=>'t_'.$request->trade,
        // 	'value'=>htmlentities($request->message)
        // ]);

        return \Redirect::route('settings.registrationContent')->with('message', 'Agreement checkbox saved successfully.');
    }

    public function removeAgreement($id)
    {
        // \DB::table('settings')->where('id',$id)->delete();
        $this->settings->delete('t_'.$id, 'agreement');

        return \Redirect::route('settings.registrationContent')->with('message', 'Agreement checkbox removed.');
    }

    public function sendRegistrationMail($start)
    {
        $registrations = Registration::skip($start)->take(10)->get();

        $i = 0;
        foreach ($registrations as $registration) {
            if (! empty($registration->cemail)) {
                $message = '';
                \Mail::to($registration->cemail)->send(new \App\Mail\RegistrationMail($registration, $message, false));
                foreach ($registration->registrants as $registrant) {
                    $message = '';
                    if (! empty($registrant->email)) {
                        \Mail::to($registrant->email)->send(new \App\Mail\IndRegistrationMail($registrant, $message, false));
                    }
                }
            } else {
                $message = '';
                if (! empty($registration->registrants->first()->email)) {
                    \Mail::to($registration->registrants->first()->email)->send(new \App\Mail\IndRegistrationMail($registration->registrants->first(), $message, true));
                }
            }
            $start++;
            $i++;
        }
        echo "<p>Batch sent ($start)</p>";
        sleep(5);
        if ($i < 10) {
            echo '<p>'.$start.' Registrations sent</p>';
        } else {
            return \Redirect::route('resend', $start);
        }
    }

    public function saveContent(Request $request)
    {
        if (isset($request->fp_correspondence)) {
            $this->settings->update('fp_correspondence', 'editor', $request->fp_correspondence);
        }
        if (isset($request->fp_online)) {
            $this->settings->update('fp_online', 'editor', $request->fp_online);
        }
        if (isset($request->fp_trade)) {
            $this->settings->update('fp_trade', 'editor', $request->fp_trade);
        }
        if (isset($request->fp_training)) {
            $this->settings->update('fp_training', 'editor', $request->fp_training);
        }
        if (isset($request->fp_events)) {
            $this->settings->update('fp_event', 'editor', $request->fp_events);
        }

        return \Redirect::route('settings.content')->with('message', 'Content updated successfully');
    }

    public function saveHelpDesk(Request $request)
    {
        if (isset($request->hd_company)) {
            $this->settings->update('hd_company', 'editor', $request->hd_company);
        }
        if (isset($request->hd_registrant)) {
            $this->settings->update('hd_registrant', 'editor', $request->hd_registrant);
        }
        if (isset($request->hd_billing)) {
            $this->settings->update('hd_billing', 'editor', $request->hd_billing);
        }
        if (isset($request->hd_payment)) {
            $this->settings->update('hd_payment', 'editor', $request->hd_payment);
        }
        if (isset($request->hd_individual)) {
            $this->settings->update('hd_individual', 'editor', $request->hd_individual);
        }

        return \Redirect::route('settings.content')->with('message', 'Help Desk content updated successfully');
    }

    /**
     * Show coupon page.  If coupon code id sent, populate form fields
     *
     * @return \Illuminate\Http\Response
     */
    public function coupons(Coupon $coupon): View
    {
        $coupons = Coupon::all();
        if (! is_null($coupon->id)) {
            $existing = ['id' => $coupon->id, 'name' => $coupon->name, 'amount' => $coupon->amount, 'discount_type' => $coupon->discount_type, 'valid_from' => date('m/d/Y', $coupon->valid_from), 'valid_to' => date('m/d/Y', $coupon->valid_to), 'maxuse' => $coupon->maxuse, 'active' => $coupon->active];

            return view('admin.coupons', compact('existing', 'coupons'));
        } else {
            return view('admin.coupons', compact('coupons'));
        }
    }

    /**
     * Save new coupon from form.
     *
     * @param  App\Http\Requests  $request
     * @return \Illuminate\Http\Response
     */
    public function couponCreate(Request $request)
    {
        // validate post vars from form
        $this->validate($request, [
            'name' => 'required|string|max:25|unique:coupons',
            'amount' => 'required|numeric',
            'maxuse' => 'required|integer',
            'valid_from' => 'required|date_format:m/d/Y|max:10',
            'valid_to' => 'required|date_format:m/d/Y|max:10|after:'.$request->valid_from,
            'discount_type' => 'required|string|max:8|in:dollar,percent',
            'active' => 'required|integer|max:1',
        ]);

        // create new coupon
        $coupon = new Coupon;
        $coupon->name = $request->name;
        $coupon->amount = $request->amount;
        $coupon->maxuse = $request->maxuse;
        $coupon->valid_from = strtotime($request->valid_from);
        $coupon->valid_to = strtotime($request->valid_to);
        $coupon->active = $request->active;
        $coupon->discount_type = $request->discount_type;
        $coupon->save();

        return back()->with('message', 'Discount Code has been saved.');
    }

    /**
     * Save updated coupon from form.
     *
     * @param  App\Http\Requests  $request
     * @return \Illuminate\Http\Response
     */
    public function couponSave(Request $request): RedirectResponse
    {
        $coupon = Coupon::where('id', '=', $request->id)->first();
        if (! empty($coupon)) {
            // validate post vars from form
            $this->validate($request, [
                'name' => 'required|string|max:25',
                'amount' => 'required|numeric',
                'maxuse' => 'required|integer',
                'valid_from' => 'required|date_format:m/d/Y|max:10',
                'valid_to' => 'required|date_format:m/d/Y|max:10|after:'.$request->valid_from,
                'discount_type' => 'required|string|max:8|in:dollar,percent',
                'active' => 'required|integer|max:1',
            ]);

            // update coupon
            $updatable = [
                'name' => $request->name,
                'amount' => $request->amount,
                'maxuse' => $request->maxuse,
                'valid_from' => strtotime($request->valid_from),
                'valid_to' => strtotime($request->valid_to),
                'active' => $request->active,
                'discount_type' => $request->discount_type,
            ];
            $coupon->update($updatable);
        }

        return redirect()->route('admin.coupons')->with('message', 'Discount Code has been saved.');
    }

    /**
     * Delete coupon.
     */
    public function couponDelete(Coupon $coupon)
    {
        $coupon->delete();
        echo 'confirm';
    }

    public function test() {}
}
