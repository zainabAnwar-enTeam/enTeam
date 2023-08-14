<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
class AttendanceRecordController extends Controller
{
    public function index()
    {
        if (Auth::user()->role_name=='Admin')
        {
            $result = DB::table('attendance_employees')->get();
            return view('form/attendanceRecord',compact('result'));
        }
        return view('form/attendanceRecord');
    } 





}
 