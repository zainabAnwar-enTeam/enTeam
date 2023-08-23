<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use PDF;
use App\Models\User;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    // main dashboard
    public function index()
    {
        $date= Carbon::now()->format('d-m-Y');
        $admin = User::where('role_name', 'Admin')->count();    // Dashboard.blade.php per Admins count kr k lay kr ja rha hai
        $user = User::where('role_name', 'Employee')->count(); // Dashboard.blade.php per users count kr k lay kr ja rha hai
        $task = DB::table('tasks')->count();
        $pendingTask = DB::table('tasks')->where('status','pending')->count();
        $totalLeaves = DB::table('leaves_admins')->count();
        $todayLeaves = DB::table('leaves_admins')->where('from_date',$date)->count();
        $leaveList = DB::table('leaves_admins')->join('users', 'leaves_admins.user_id','=','users.user_id')->where('leaves_admins.from_date',$date)->select('leaves_admins.*','users.*')->take(1)->get();
        $pendingLeaves = DB::table('leaves_admins')->where('leave_status','Pending')->count();
        $declineLeaves = DB::table('leaves_admins')->where('leave_status','Declined')->count();
        $approvedLeaves = DB::table('leaves_admins')->where('leave_status','Approved')->count();
        $employees = DB::table('users')->where('role_name','Employee')->take(5)->get();
        $admins = DB::table('users')->where('role_name','Admin')->take(5)->get();
        return view('dashboard.dashboard', compact('user', 'admin','task','todayLeaves','totalLeaves','pendingLeaves','declineLeaves','approvedLeaves','employees','admins','leaveList','pendingTask')); // Compact wali line new add ki hai
    }
    // employee dashboard
    public function emDashboard()
    {
        $loggedInUserId = Auth::id();
        $leaves = DB::table('leaves_admins')
            ->join('users', 'users.user_id', '=', 'leaves_admins.user_id')
            ->where('users.role_name', 'employee') // Filter for "employee" user_role
            ->where('users.id', $loggedInUserId) // Filter for the logged-in user
            ->where('leaves_admins.leave_status', 'Approved')
            ->select('leaves_admins.*', 'users.position', 'users.name', 'users.avatar')
            ->count();
        $medicalLeaves = DB::table('leaves_admins')
            ->join('users', 'users.user_id', '=', 'leaves_admins.user_id')
            ->where('users.role_name', 'employee') // Filter for "employee" user_role
            ->where('users.id', $loggedInUserId) // Filter for the logged-in user
            ->where('leaves_admins.leave_type', 'Medical Leave')->where('leaves_admins.leave_status', 'Approved')->count();
        $lossOfPay = DB::table('leaves_admins')
            ->join('users', 'users.user_id', '=', 'leaves_admins.user_id')
            ->where('users.role_name', 'employee') // Filter for "employee" user_role
            ->where('users.id', $loggedInUserId) // Filter for the logged-in user
            ->where('leaves_admins.leave_type', 'Loss of Pay')->where('leaves_admins.leave_status', 'Approved')->count();
        $casualLeaves = DB::table('leaves_admins')
            ->join('users', 'users.user_id', '=', 'leaves_admins.user_id')
            ->where('users.role_name', 'employee') // Filter for "employee" user_role
            ->where('users.id', $loggedInUserId) // Filter for the logged-in user
            ->where('leaves_admins.leave_type', 'Casual Leave 12 Days')->where('leaves_admins.leave_status', 'Approved')
            ->count();
        $total = 12 - ($medicalLeaves + $lossOfPay + $casualLeaves);
        $today = Carbon::now()->format('d-m-Y') ;
        $holidays = DB::table('holidays')->where('date_holiday','>',$today)->select('holidays.*')->get();

        $loggedInUserName = Auth::user()->name; 
        $tasks = DB::table('tasks')
        ->join('users', 'users.name', '=', 'tasks.employee_name')
        ->where('users.name', $loggedInUserName)
        ->select('tasks.id as task_id', 'tasks.task_name', 'tasks.task_description', 'tasks.employee_name', 'tasks.department', 'tasks.worth_of_task', 'tasks.status', 'tasks.starting_date', 'tasks.ending_date', 'tasks.created_at', 'tasks.updated_at', 'users.id as user_id', 'users.name', 'users.email', 'users.join_date', 'users.phone_number', 'users.role_name', 'users.avatar', 'users.position', 'users.email_verified_at', 'users.password', 'users.remember_token')
        ->count();

        $taskcompleted = DB::table('tasks')
        ->join('users', 'users.name', '=', 'tasks.employee_name')
        ->where('users.name', $loggedInUserName)
        ->where('tasks.status','Complete')
        ->count();

        $taskpending = DB::table('tasks')
        ->join('users', 'users.name', '=', 'tasks.employee_name')
        ->where('users.name', $loggedInUserName)
        ->where('tasks.status','Pending')
        ->count();

        $dt        = Carbon::now();
        $todayDate = $dt->toDayDateTimeString();
        return view('dashboard.emdashboard', compact('todayDate', 'leaves', 'total','holidays','tasks','taskcompleted','taskpending'));
    }

    public function generatePDF(Request $request)
    {
        // $data = ['title' => 'Welcome to ItSolutionStuff.com'];
        // $pdf = PDF::loadView('payroll.salaryview', $data);
        // return $pdf->download('text.pdf');
        // selecting PDF view
        $pdf = PDF::loadView('payroll.salaryview');
        // download pdf file
        return $pdf->download('pdfview.pdf');
    }
}
