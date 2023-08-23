<?php

namespace App\Http\Controllers;
use App\Models\Feedback;
use Brian2694\Toastr\Facades\Toastr;
use DB;
use Auth;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function index()
    {
        $getallemployee = DB::table('users')->where('role_name', 'Employee')->get();

        return view('form.feedback', compact('getallemployee'));
    }
    public function rateemployee(Request $request){
        $getusername=Auth::user();
        Feedback::create([
            'feedbackfrom'      => $getusername->name,
            'feedbackof'    => $request->feedbackof,
            'feedbackrating'     => $request->feedbackrating,
            'feedbackdescription' => $request->feedbackdescription
        ]);
        Toastr::success('Feedback Posted','Success');
        return redirect()->back();
    }
}
