<?php

namespace App\Http\Controllers;

use App\CorrespondenceCourse;
use App\Coupon;
use App\Course;
use App\Customer;
use App\Description;
use App\Event;
use App\OnlineCourse;
use App\Registration;
use App\Student;
use App\Ticket;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // $content = \DB::table('settings')->where('name','like','fp_%')->get()->pluck('value','name');
        $events = Event::where('event', 1)->count();

        return view('welcome', compact('events'));
    }

    public function getCompanyList($partial)
    {
        $customers = Customer::select('id', 'name')->where('name', 'like', '%'.$partial.'%')->get(['id', 'name'])->toArray();

        echo json_encode($customers);

        exit();
    }

    public function getCompanyInformation(Customer $customer)
    {

        echo json_encode($customer->toArray());

        exit();
    }

    public function getStudentInformation(Student $student)
    {

        echo json_encode($student->toArray());

        exit();
    }

    public function getStudentList($partial, $first = '')
    {
        if (! empty($first)) {
            $students = Student::select('id', 'first', 'last', 'mobile')->where('first', $first)->where('last', 'like', $partial.'%')->get()->toArray();
        } else {
            $students = Student::select('id', 'first', 'last', 'mobile')->where('last', 'like', $partial.'%')->get()->toArray();
        }

        echo json_encode($students);

        exit();
    }

    public function getCompanyMatch(Request $request)
    {
        $input = $request->all();

        $customer = Customer::whereRaw('lower(replace(replace(replace(replace(replace(replace(replace(name,"&",""),".",""),",",""),"'."'".'",""),";",""),"#","")," ","")) = ?', strtolower(str_replace([' ', '#', '&', '.', ',', "'", ';'], ['', '', '', '', '', '', ''], $request->input('name'))))
            ->orWhereRaw('replace(replace(replace(replace(replace(phone," ",""),"(",""),")",""),"-",""),".","") = ?', str_replace(['(', ')', '-', '.', ' '], ['', '', '', '', ''], $request->input('phone')))
            ->orWhere(function ($query) use ($input) {
                $query->whereRaw('replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(address," ",""),"-",""),",",""),".",""),"#",""),"Street","St"),"Road","Rd"),"Avenue","Ave"),"Drive","Dr"),"Ste","Suite"),"Hwy","Highway"),"Court","Ct"),"Ln","Lane") = ?', str_replace(['#', '.', ',', '-', ' ', 'Street', 'Road', 'Avenue', 'Drive', 'Ste', 'Hwy', 'Court', 'Ln'], ['', '', '', '', '', 'St', 'Rd', 'Ave', 'Dr', 'Suite', 'Highway', 'Ct', 'Lane'], $input['address']))->where('zip', '=', $input['zip']);
            })->first();
        if (is_null($customer)) {
            echo json_encode([]);
        } else {
            echo json_encode($customer->toArray());
        }

        exit();
    }

    public function getCourseLocations($trade)
    {
        $ret = [];
        if (! session()->has('trade'.'registration')) {
            $company = null;
        } else {
            $registration = session()->get('trade'.'registration');
            if (isset($registration['company'])) {
                $company = Customer::where('id', $registration['company'])->first();
            } else {
                $company = null;
            }
        }
        if (is_null($company) || $company->inhouse == 0) {
            $locations = Course::distinct()->select('location')->where('location', 'not like', 'In House%')->where('trade', $trade)->orderBy('location')->get()->pluck('location', 'location');
        } else {
            $locations = Course::distinct()->select('location')->where('trade', $trade)->orderBy('location')->get()->pluck('location', 'location');
        }
        $ret['locations'] = $locations;

        $agreement = $this->settings->get('t_'.$trade, 'agreement');
        if (! empty($agreement)) {
            $ret['agreements'] = [$agreement];
        }
        // $agreements = \DB::table('settings')->where('name','t_'.$trade)->get()->pluck('value');
        // if($agreements) {
        // 	$ret['agreements'] = $agreements->all();
        // 	foreach($ret['agreements'] as &$agreement) {
        // 		$agreement = html_entity_decode($agreement);
        // 	}
        // }

        echo json_encode($ret);

        exit();
    }

    public function getCourseIDs($path, $trade, $location = '')
    {
        switch ($path) {
            case 'trade':
                $courses = Course::distinct()->select('id', 'courseid')->where('trade', $trade)->where('location', $location)->orderBy('courseid')->get()->pluck('courseid', 'id');
                break;
            case 'correspondence':
                $courses = CorrespondenceCourse::distinct()->select('id', 'courseid')->where('trade', $trade)->orderBy('courseid')->get()->pluck('courseid', 'id');
                break;
        }

        echo json_encode(['courses' => $courses]);

        exit();
    }

    public function getStudentCourseCost(Course $course, ?Customer $customer = null)
    {
        if (! is_null($customer) && $customer->member == 'Member') {
            $cost = $course->member;
        } else {
            $cost = $course->nonmember;
        }

        echo $cost;

        exit();
    }

    public function getCourseCost($path, $course)
    {
        switch ($path) {
            case 'trade':
                $course = Course::where('id', $course)->first();
                break;
            case 'online':
                $course = OnlineCourse::where('id', $course)->first();
                break;
            case 'correspondence':
                $course = CorrespondenceCourse::where('id', $course)->first();
                break;
        }
        $registration = session()->get($path.'registration');

        if (! is_null($course)) {
            try {
                if (isset($registration['member']) && $registration['member']) {
                    $cost = $course->member;
                } else {
                    $cost = $course->nonmember;
                }

                echo $cost;
            } catch (\Exception $e) {
                echo 'error';
            }
        } else {
            echo 'error';
        }

        exit();
    }

    public function getEventTickets(Event $event)
    {
        if (! is_null($event)) {
            $tickets = Ticket::select('id', 'name')->where('event_id', $event->id)->orderBy('nonmember')->get()->pluck('name', 'id');
            echo json_encode(['tickets' => $tickets]);
        } else {
            echo 'false';
        }
    }

    public function getEventCost(Ticket $ticket, ?Customer $customer, Request $request)
    {
        $member = false;
        $path = 'event';
        if (isset($request->path)) {
            $path = $request->path;
        }
        if (is_null($customer)) {
            $registration = session()->get($path.'registration');
            $member = (isset($registration['member'])) ? $registration['member'] : false;
        } else {
            if ($customer->member == 'Member') {
                $member = true;
            }
        }
        if ($member) {
            $cost = $ticket->member;
        } else {
            $cost = $ticket->nonmember;
        }

        echo $cost;

        exit();
    }

    public function getClassDescription(Course $course)
    {
        //		$description = Description::where('courseid',$course->courseid)->first();
        if (! empty($course->description)) {
            echo json_encode((object) ['id' => $course->courseid, 'description' => $course->description->description]);
        } else {
            echo json_encode((object) ['id' => $course->courseid, 'notfound' => true]);
        }
        exit();
    }

    /*
        public function getEventCost(Ticket $ticket, Customer $customer=null) {
            if(!is_null($customer) && $customer->member=='Member') {
                $cost = $ticket->member;
            } else {
                $cost = $ticket->nonmember;
            }

            print $cost;

            die();
        }
    */
    public function balancePayment(Student $student)
    {
        if ($student->balance > 0) {
            return view('balancePayment', compact('student'));
        } else {
            return view('welcome');
        }
    }

    public function freePayment()
    {
        return view('freePayment');
    }

    /**
     * Check coupon code.  Prints true if usable.
     *
     * @param  string  $coupon
     */
    public function coupon($coupon = null, $path = 'event')
    {
        $cost = 0;
        if (! session()->has($path.'registration')) {
            echo json_encode(['status' => false]);
            exit();
        } else {
            $registration = session()->get($path.'registration');
            foreach ($registration['registrants'] as $key => $registrant) {
                $cost += $registrant['cost'];
            }
        }
        if (! is_null($coupon)) {
            $coupon = Coupon::where('name', '=', $coupon)->first();
            if (! empty($coupon)) {
                if ($coupon->isUsable()) {
                    /*
                                        $registration['coupon'] = $coupon->name;
                                        session()->put($path.'registration',$registration);
                    */
                    echo json_encode(['status' => true, 'value' => $coupon->value($cost), 'total' => $coupon->appliedTotal($cost)]);
                    exit();
                }
            }
        }
        /*
                $registration['coupon'] = '';
                session()->put($path.'registration',$registration);
        */
        echo json_encode(['status' => false, 'total' => $cost]);
        exit();
    }

    public function test($path = null)
    {
        // $settings=\DB::table('settings')->get();
        // foreach($settings as $set) {
        // 	\DB::table('settings')->where('id',$set->id)->update([
        // 		's_name'=>$set->name,
        // 		's_value'=>$set->value
        // 	]);
        // }
        $register = session()->get('training'.'registration');
        dd($register);

        return view('test');
    }

    public function ajaxSendResponse(Request $request, Registration $registration)
    {
        // \Mail::to("gwgci@voxcomp.com")->send(new \App\Mail\SendPaymentResponse($registration,$request->response));
    }

    public function ajaxSendConfirmation(Registration $registration)
    {
        // \Mail::to("gwgci@voxcomp.com")->send(new \App\Mail\SendPaymentConfirmation($registration));
    }
}
