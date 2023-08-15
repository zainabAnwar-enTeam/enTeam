<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\DB;
use App\Models\Employee;
use App\Models\department;
use App\Models\designation;
use App\Models\User;
use App\Models\module_permission;

class DesignationController extends Controller
{
    Public function index()
    {
        $designationss = DB::table('designations')->get();
        $departmentss = DB::table('departments')->get();
        return view('form.designations',compact('designationss','departmentss'));
    }
    
    public function saveRecordDesignations(Request $request)
    {
        $request->validate([
            'designation => required|string|max:255',
            'department => required|string|max:255',
        ]);
        
        dd($request->all());
        DB::beginTransaction();
        try{
            $designation = designation::where('designations',$request->designations)->first();

            if($designation === null)
            {
                $designation = new designation;
                $designation->designations = $request->designation;
                $designation->department = $request->department;
                $designation->save();
                DB::commit();
                Toastr::success('Add new designation successfully :)','sucess');
                return redirect()->back();
             }
             else{
                DB::rollBack();
                Toastr::error('Add new Designation Exits', 'Error');
                return redirect()->back();
              }


         }
         catch(\Exception $e)
         {DB::rollback();
            Toastr::error('Add new Designation fail :)','Error');
            return redirect()->back();}

    }

    public function updateRecordDesignation(Request $request)
    {
        DB::beginTransaction();
        try{
            // update table departments
            $designation = [
                'id'=>$request->id,
                'designation'=>$request->designation,
                'department'=>$request->department,
            ];
            designation::where('id',$request->id)->update($designation);
        
            DB::commit();
            Toastr::success('updated record successfully :)','Success');
            return redirect()->back();
        } catch(\Exception $e) {
            DB::rollback();
            Toastr::error('updated record fail :)','Error');
            return redirect()->back();
        }
    }

    public function deleteRecordDesignations(Request $request) 
    {
        try {

            designation::destroy($request->id);
            Toastr::success('Designation deleted successfully :)','Success');
            return redirect()->back();
        
        } catch(\Exception $e) {

            DB::rollback();
            Toastr::error('Designation delete fail :)','Error');
            return redirect()->back();
        }
    }


}
