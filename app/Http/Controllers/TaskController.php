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
        return view('task/task',compact('employee','departments','task'));
        }
        return view('task/task');
    }

    public function saveRecord(Request $request )
    {
       /* $request->validate([
            'task_name'         => 'required|string|max:255',
            'employee_name'     => 'required|string|max:255',
            'department'        => 'required|string|max:255',
            'worth_of_task'     => 'required|string|max:255',
            'starting_date'     => 'required|string|max:255',
            'ending_date'       => 'required|string|max:255',
            'task_description'  => 'required|string|max:255',
        ]);*/
       
       //dd($request->all());
        DB::beginTransaction();
        //try{
            $task = new Task;   // Create a new Task instance and assign properties
            $task->task_name        = $request->task_name;
            $task->task_description = $request->task_description;
            $task->employee_name    = $request->employee_name;
            $task->department       = $request->department;
            $task->starting_date    = $request->starting_date;
            $task->ending_date      = $request->ending_date;
            $task->status ='Pending';
            $task->worth_of_task    = $request->worth_of_task;
            $task->save();
            DB::commit();   // Commit the transaction if everything is successful
            return redirect()->back();
     //   }
       // catch(\Exception $e) {
            
        //    return redirect()->back()->with('success','New task Created');  // Redirect back with a success message
       // }
         
        
    }
}
