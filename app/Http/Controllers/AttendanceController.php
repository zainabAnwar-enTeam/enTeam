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
           
            $loggedInUserId = Auth::id();    
            return view('form/attendanceemployee',compact('result','attendance'));
        }
        
        return view('form/attendance');

    }

    public function AttendanceEmployee()
    {
        $loggedInUserId = Auth::id();  
        $date = Carbon::now()->format('d-m-Y');
        $day = Carbon::now()->format('l');
        $today = Carbon::now()->format('Y-m-d');      
        $attendance = DB::table('attendance_employees')
        ->join('users', 'users.id', '=', 'attendance_employees.user_id')
        ->where('users.id', $loggedInUserId) // Filter for the logged-in user
        ->select('attendance_employees.*','users.*')
        ->get();
        $timediffer = DB::table('attendance_employees')
        ->join('users', 'users.id', '=', 'attendance_employees.user_id')
        ->where('users.id', $loggedInUserId) // Filter for the logged-in user
        ->where('attendance_employees.date',$today)->select('attendance_employees.total_hours')
        ->get();
       
        return view('form.attendanceemployee',compact('attendance','timediffer','date','day',));
    }
    
    
    public function punchIn()
    {
        $user = Auth::user();
    
        // Check if the user already punched in for the day
        if ($user->attendances()->whereDate('date', Carbon::today()->format('Y-m-d'))->exists()) {
            Toastr::error('You have already Punched in Today');
            return redirect()->route('attendance/page');
        }
        else{
            $attendance_employees = new AttendanceEmployee();
            $attendance_employees->user_id = $user->id;
            $attendance_employees->user_name = $user->name;
            $attendance_employees->status =  $user->role_name;
            $attendance_employees->punch_in = Carbon::now()->format('h:i:A');
            $attendance_employees->date = Carbon::now()->format('Y-m-d');
            $attendance_employees->save();

            Toastr::success('Punched in Successfully');
            return redirect()->route('attendance/page');
         }
    
        
    }
    
     
    public function punchOut()
    {
        $user = Auth::user();
    
        // Check if the user already punched out for the day
        if ($user->attendances()->whereDate('punch_out', Carbon::today())->exists())
        {
            Toastr::error('You have already Punched out for Today');
            return redirect()->route('attendance/page');
        }
        
        $attendance_employees = $user->attendances()->whereDate('date', Carbon::today())->first();   // Check if the user punch-in first or not before pressing the punch out button.
        if (!$attendance_employees) {
            Toastr::error('You must punch in first before punching out.');
            return redirect()->back();
        }
        $attendance_employees->punch_out = Carbon::now()->format('h:i:A');
        $punchIn = Carbon::createFromFormat('h:i:A', $attendance_employees->punch_in);
        $punchOut = Carbon::createFromFormat('h:i:A',$attendance_employees->punch_out);
        $timedifference = $punchOut->diff($punchIn);
        $attendance_employees->total_hours =  $timedifference->format('%h:%i:%s');
        $attendance_employees->save();
        return redirect()->back();
    }

    


    
}