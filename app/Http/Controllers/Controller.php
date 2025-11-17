<?php

namespace App\Http\Controllers;

use App\Http\Repositories\Settings;
use App\Models\Customer;
use App\Models\Student;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $settings;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->settings = new Settings;
    }

    public function checkStudentBalance($request)
    {
        if (! empty($request->mobile)) {
            $mobile = trim(str_replace([' ', '(', ')', '-', '.'], ['', '', '', '', ''], $request->mobile));
            $mobile = '('.substr($mobile, 0, 3).') '.substr($mobile, 3, 3).'-'.substr($mobile, 6);
            $student = Student::where('last', $request->lastname)->where('mobile', $mobile)->first();
            if (is_null($student) || empty($student)) {
                $student = Student::where('first', $request->firstname)->where('last', $request->lastname)->where('email', $request->email)->first();
            }
            if (is_null($student) || empty($student)) {
                return false;
            } else {
                if ($student->balance > 0) {
                    return $student->id;
                } else {
                    return false;
                }
            }
        } else {
            $student = Student::where('first', $request->firstname)->where('last', $request->lastname)->where('email', $request->email)->first();
            if (is_null($student) || empty($student)) {
                return false;
            } else {
                if ($student->balance > 0) {
                    return $student->id;
                } else {
                    return false;
                }
            }
        }
    }

    public function checkCompanyBalance($request)
    {
        if ($request->company != 0) {
            $company = Customer::where('id', $request->company)->first();
            if ($company->balance > 0) {
                return $company->id;
            } else {
                return false;
            }
        } else {
            if (! empty($request->phone)) {
                $phone = trim(str_replace([' ', '(', ')', '-', '.'], ['', '', '', '', ''], $request->phone));
                $phone = '('.substr($phone, 0, 3).') '.substr($phone, 3, 3).'-'.substr($phone, 6);
                $company = Customer::where('name', $request->name)->where('phone', $phone)->first();
                if (is_null($company) || empty($company)) {
                    $company = Customer::where('name', $request->name)->where('address', $request->address)->first();
                }
                if (is_null($company) || empty($company)) {
                    return false;
                } else {
                    if ($company->balance > 0) {
                        return $company->id;
                    } else {
                        return false;
                    }
                }
            } else {
                $company = Customer::where('name', $request->name)->where('address', $request->address)->first();
                if (is_null($company) || empty($company)) {
                    return false;
                } else {
                    if ($company->balance > 0) {
                        return $company->id;
                    } else {
                        return false;
                    }
                }
            }
        }
    }
}
