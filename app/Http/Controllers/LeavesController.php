<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\LeavesAdmin;
use Illuminate\Support\Facades\DB;
use DateTime;
use Auth;
class LeavesController extends Controller
{
    //
    public function leaves()
    {
        $leaves = DB::table('leaves_admins')
                    ->join('users', 'users.user_id', '=', 'leaves_admins.user_id')
                    ->select('leaves_admins.*', 'users.position','users.name','users.avatar')
                    ->get();

        $totalLeaves = DB::table('leaves_admins')->count();
        $pendingLeaves = DB::table('leaves_admins')->where('leave_status','pending')->count();
        $approvedLeaves = DB::table('leaves_admins')->where('leave_status','Approved')->count();
        $declinedLeaves = DB::table('leaves_admins')->where('leave_status','Declined')->count();

        return view('form.leaves',compact('leaves','totalLeaves','pendingLeaves','approvedLeaves','declinedLeaves'));
    }


      //update Status From Admin of Leave
      public function editstatus(Request $request)
      {
          DB::beginTransaction();
          try {
             
              LeavesAdmin::where('id', $request->id)->update(['leave_status' => $request->status]);
              DB::commit();
              Toastr::success('Status Updated successfully :)','Success');
              return redirect()->back();
          }
          catch(\Exception $e) {
              DB::rollback();
              Toastr::error('Update Status fail :)','Error');
              return redirect()->back();
          }
         
      }
    // save record
    public function saveRecord(Request $request)
    {
        $request->validate([
            'leave_type'   => 'required|string|max:255',
            'from_date'    => 'required|string|max:255',
            'to_date'      => 'required|string|max:255',
            'leave_reason' => 'required|string|max:255',
        ]);

        DB::beginTransaction();
        try {

            $from_date = new DateTime($request->from_date);
            $to_date = new DateTime($request->to_date);
            $day     = $from_date->diff($to_date);
            $days    = $day->d;

            $leaves = new LeavesAdmin;
            $leaves->user_id        = $request->user_id;
            $leaves->leave_type    = $request->leave_type;
            $leaves->from_date     = $request->from_date;
            $leaves->to_date       = $request->to_date;
            $leaves->day           = $days;
            $leaves->leave_reason  = $request->leave_reason;
            $leaves->save();
            
            DB::commit();
            Toastr::success('Create new Leaves successfully :)','Success');
            return redirect()->back();
        } catch(\Exception $e) {
            DB::rollback();
            Toastr::error('Add Leaves fail :)','Error');
            return redirect()->back();
        }
    }

    // edit record
    public function editRecordLeave(Request $request)
    {
        DB::beginTransaction();
        try {

            $from_date = new DateTime($request->from_date);
            $to_date = new DateTime($request->to_date);
            $day     = $from_date->diff($to_date);
            $days    = $day->d;

            $update = [
                'id'           => $request->id,
                'leave_type'   => $request->leave_type,
                'from_date'    => $request->from_date,
                'to_date'      => $request->to_date,
                'day'          => $days,
                'leave_reason' => $request->leave_reason,
            ];

            LeavesAdmin::where('id',$request->id)->update($update);
            DB::commit();
            Toastr::success('Updated Leaves successfully :)','Success');
            return redirect()->back();
        } catch(\Exception $e) {
            DB::rollback();
            Toastr::error('Update Leaves fail :)','Error');
            return redirect()->back();
        }
    }

    // delete record
    public function deleteLeave(Request $request)
    {
        try {

            LeavesAdmin::destroy($request->id);
            Toastr::success('Leaves admin deleted successfully :)','Success');
            return redirect()->back();
        
        } catch(\Exception $e) {

            DB::rollback();
            Toastr::error('Leaves admin delete fail :)','Error');
            return redirect()->back();
        }
    }

    // leaveSettings
    public function leaveSettings()
    {
        return view('form.leavesettings');
    }

    // attendance admin
    public function attendanceIndex()
    {
        return view('form.attendance');
    }

    // attendance employee
    public function AttendanceEmployee()
    {
        return view('form.attendanceemployee');
    }

    // leaves Employee
    public function leavesEmployee()
    {
        $loggedInUserId = Auth::id();        
        $leaves = DB::table('leaves_admins')
        ->join('users', 'users.user_id', '=', 'leaves_admins.user_id')
        ->where('users.role_name', 'employee') // Filter for "employee" user_role
        ->where('users.id', $loggedInUserId) // Filter for the logged-in user
        ->select('leaves_admins.*', 'users.position', 'users.name', 'users.avatar')
        ->get();
        
      //  $medical = $leaves::where('leave_type','Medical Leave')->count();

        return view('form.leavesemployee',compact('leaves'));
    }

    // shiftscheduling
    public function shiftScheduLing()
    {
        return view('form.shiftscheduling');
    }

    // shiftList
    public function shiftList()
    {
        return view('form.shiftlist');
    }
}
