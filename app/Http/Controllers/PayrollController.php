<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use App\Models\StaffSalary;
use Barryvdh\DomPDF\Facade\Pdf;
use Brian2694\Toastr\Facades\Toastr;


class PayrollController extends Controller
{
    // view page salary
    public function salary()
    {
        if (Auth::user()->role_name == 'Admin') {
            $users = DB::table('users')->join('staff_salaries', 'users.user_id', '=', 'staff_salaries.user_id')->select('users.*', 'staff_salaries.*')->get();
            $leaves = DB::table('leaves_admins')->join('users', 'leaves_admins.user_id', '=', 'users.user_id')->join('staff_salaries', 'leaves_admins.user_id', '=', 'staff_salaries.user_id')->where('leave_status', 'Approved')->count();
            $salaries = DB::table('staff_salaries')->get();
            $department = DB::table('departments')->get();
            $userList         = DB::table('users')->get();
            $permission_lists = DB::table('permission_lists')->get();
            return view('payroll.salary', compact('users', 'userList', 'permission_lists', 'leaves', 'salaries', 'department'));
        } else {
            $loggedInUserId = Auth::id();
            $users = DB::table('users')->join('staff_salaries', 'users.user_id', '=', 'staff_salaries.user_id')->where('users.id', $loggedInUserId)->select('users.*', 'staff_salaries.*')->get();
            $department = DB::table('departments')->get();
            $userList         = DB::table('users')->get();
            return view('payroll.employeesalary', compact('department', 'userList', 'users'));
        }
    }

    // save record
    public function saveRecord(Request $request)
    {
        DB::beginTransaction();
        $salary = new StaffSalary;
        $salary->name                   = $request->name;
        $salary->user_id                = $request->user_id;
        $salary->department            = $request->department;
        $salary->basic_salary           = $request->basic_salary;
        $salary->user_email             = $request->user_email;
        $salary->incentive_pay          = $request->incentive_pay;
        $salary->conveyance_allowance   = $request->conveyance_allowance;
        $salary->house_rent_allowance   = $request->house_rent_allowance;
        $salary->medical_allowance      = $request->medical_allowance;
        $salary->provident_fund         = $request->provident_fund;
        $salary->leaves                 = ($request->leaves) * 5;
        $salary->prof_tax               = $request->prof_tax;
        $salary->health_insurance       = $request->health_insurance;
        $salary->save();

        DB::commit();
        Toastr::success('Create new Salary successfully :)', 'Success');
        return redirect()->back();
    }

    // salary view detail
    public function salaryView($user_id)
    {
        $users = DB::table('staff_salaries')
            ->join('users', 'users.user_id', '=', 'staff_salaries.user_id')
            ->select('staff_salaries.*', 'users.*')->where('staff_salaries.user_id', $user_id)
            ->get();
        // dd($users->all());

        if (!empty($users)) {
            return view('payroll.salaryview', compact('users'));
        } else {
            Toastr::warning('Please update information user :)', 'Warning');
            return redirect()->route('profile_user');
        }
    }


    //Search Record
    public function searchRecord(Request $request)
    {
        if (Auth::user()->role_name == 'Admin') {
            //dd($request->all());
            $salaries = DB::table('staff_salaries')->get();
            $department = DB::table('departments')->get();
            $userList         = DB::table('users')->get();
            if ($request->name && $request->department) {
                $salaries = DB::table('staff_salaries')->where('name', $request->name)->where('department', $request->department)->get();
            } elseif ($request->name) {
                $salaries = DB::table('staff_salaries')->where('name', $request->name)->get();
                //   dd($result->all());
            } elseif ($request->department) {
                $salaries =  DB::table('staff_salaries')->where('department', $request->department)->get();
            }
            return view('payroll.employeesalary', compact('department', 'salaries', 'userList'));
        }
    }
    // update record
    public function updateRecord(Request $request)
    {
        DB::beginTransaction();
        try {
            $update = [
                'id' => $request->id,
                'user_id'      => $request->user_id,
                'user_email' => $request->user_email,
                'name'    => $request->name,
                'department'  => $request->department,
                'basic_salary'   => $request->basic_salary,
                'incentive_pay'      => $request->incentive_pay,
                'conveyance_allowance'     => $request->conveyance_allowance,
                'house_rent_allowance' => $request->house_rent_allowance,
                'medical_allowance'  => $request->medical_allowance,
                'provident_fund'  => $request->provident_fund,
                'leaves'  => $request->leaves,
                'prof_tax'  => $request->prof_tax,
                'health_insurance'   => $request->health_insurance,

            ];
            StaffSalary::where('id', $request->id)->update($update);
            DB::commit();
            Toastr::success('Salary updated successfully :)', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Salary update fail :)', 'Error');
            return redirect()->back();
        }
    }

    // delete record
    public function deleteRecord(Request $request)
    {
        DB::beginTransaction();
        try {
            StaffSalary::destroy($request->user_id);
            DB::commit();
            Toastr::success('Salary deleted successfully :)', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Salary deleted fail :)', 'Error');
            return redirect()->back();
        }
    }

    // payroll Items
    public function payrollItems()
    {
        return view('payroll.payrollitems');
    }
}
