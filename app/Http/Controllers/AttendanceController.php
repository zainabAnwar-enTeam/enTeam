<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\AttendanceEmployee;
use DB;
use DateTime;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Session;
use Auth;
use Brian2694\Toastr\Facades\Toastr;




class AttendanceController extends Controller
{
    //
    public function index()
    {
        if (Auth::user()->role_name=='Admin')
        {
            $result = DB::table('attendance_employees')->get();
            return view('form/attendanceemployee',compact('result'));
        }
        
        return view('form/attendance');

    }
    public function DateTime()
    {
        $date = new DateTime();
        $date->format("d-m-y");
     }
    
    

    public function punchIn()
    {
        $user = Auth::user();
    
        // Check if the user already punched in for the day
        if ($user->attendances()->whereDate('punch_in', Carbon::today())->exists()) {
            return redirect()->route('attendance/employee/page')->with('error', 'You have already punched in for today.');
        }
        else{
            $attendance_employees = new AttendanceEmployee();
            $attendance_employees->user_id = $user->id;
            $attendance_employees->status =  $user->role_name;
            $attendance_employees->punch_in = Carbon::now();
            $attendance_employees->save();

        
            return redirect()->route('attendance/employee/page')->with('success', 'Punched in successfully.');
         }
    
        
    }
    
    public function punchOut()
    {
        $user = Auth::user();
    
        // Check if the user already punched out for the day
        if ($user->attendances()->whereDate('punch_out', Carbon::today())->exists())
        {
            return redirect()->route('attendance/employee/page')->with('error', 'You have already punched out for today.');
        }
        
        $attendance_employees = $user->attendances()->whereDate('punch_in', Carbon::today())->first();
        if (!$attendance_employees) {
            return redirect()->back()->with('error', 'You must punch in first before punching out.');
        }
    
        $attendance_employees->punch_out = Carbon::now();
        $timedifference = $attendance_employees->punch_out->diff($attendance_employees->punch_in)->format('%H:%I:%S');
        $attendance_employees->total_hours =  $timedifference;
        $attendance_employees->save();
    
        return redirect()->back();
    }

    
}
