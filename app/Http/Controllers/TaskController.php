<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Auth;
use DB;
use Session;

class TaskController extends Controller
{
    public function index()
    {
        if(Auth::user()->role_name=='Admin')
        {
        $employee = DB::table('users')->get();
        $departments = DB::table('departments')->get();
        $task = DB::table('tasks')->get();
        $totalTask = DB::table('tasks')->count();
        $completeTask = DB::table('tasks')->where('status','Complete')->count();
        $incompleteTask = DB::table('tasks')->where('status','InComplete')->count();
        $pendingTask = DB::table('tasks')->where('status','Pending')->count();
        return view('task/task',compact('employee','departments','task','totalTask','completeTask','incompleteTask','pendingTask'));
        }
        else
        {
        $loggedInUserName = Auth::user()->name; 
        $tasks = DB::table('tasks')
        ->join('users', 'users.name', '=', 'tasks.employee_name')
        ->where('users.name', $loggedInUserName)
        ->select('tasks.id as task_id', 'tasks.task_name', 'tasks.task_description', 'tasks.employee_name', 'tasks.department', 'tasks.worth_of_task', 'tasks.status', 'tasks.starting_date', 'tasks.ending_date', 'tasks.created_at', 'tasks.updated_at', 'users.id as user_id', 'users.name', 'users.email', 'users.join_date', 'users.phone_number', 'users.role_name', 'users.avatar', 'users.position', 'users.email_verified_at', 'users.password', 'users.remember_token')
        ->get();
        return view('task/taskemployee',compact('tasks'));
        }
    }
    public function saveRecord(Request $request )
    {
        DB::beginTransaction();
        $task = new Task;   // Create a new Task instance and assign properties
        $task->task_name        = $request->task_name;
        $task->task_description = $request->task_description;
        $task->employee_name    = $request->employee_name;
        $task->department       = $request->department;            
        $task->starting_date    = $request->starting_date;            
        $task->ending_date      = $request->ending_date;             
        $task->worth_of_task    = $request->worth_of_task;            
        $task->save();
        DB::commit();   // Commit the transaction if everything is successful
        return redirect()->back();        
    }

   

    public function editstatus(Request $request)
    {

    DB::beginTransaction();
    try {
        Task::where('id', $request->id)->update(['status' => $request->status]);
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
}
