@extends('layouts.master')
@section('content')
<div class="page-wrapper">
    <!-- Page Content -->
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Welcome {{ Session::get('name') }}!</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->
        <div class="row">
            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="card dash-widget">
                    <div class="card-body">
                    <div class="dash-widget-info">
                        <h3>EnTeam</h3> <span>FYP</span> 
                    </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="card dash-widget">
                    <div class="card-body"> <span class="dash-widget-icon"><i class="fa fa-user"></i></span>
                        <div class="dash-widget-info">
                            <h3>{{$admin}}</h3> <span>Admins</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="card dash-widget">
                    <div class="card-body"> <span class="dash-widget-icon"><i class="fa fa-diamond"></i></span>
                        <div class="dash-widget-info">
                            <h3>{{$task}}</h3> <span>Tasks</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="card dash-widget">
                    <div class="card-body"> <span class="dash-widget-icon"><i class="fa fa-user"></i></span>
                        <div class="dash-widget-info">
                            <h3>{{$user}}</h3> <span>Employees</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6 text-center">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title">Total Revenue</h3>
                                <div id="bar-charts"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 text-center">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title">Sales Overview</h3>
                                <div id="line-charts"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card-group m-b-30">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3">
                                <div> <span class="d-block">New Employees</span> </div>
                                <div> <span class="text-success">+10%</span> </div>
                            </div>
                            <h3 class="mb-3">10</h3>
                            <div class="progress mb-2" style="height: 5px;">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 70%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <p class="mb-0">Overall Employees: {{$user}}</p>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3">
                                <div> <span class="d-block">Earnings</span> </div>
                                <div> <span class="text-success">+12.5%</span> </div>
                            </div>
                            <h3 class="mb-3">$1,42,300</h3>
                            <div class="progress mb-2" style="height: 5px;">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 70%;" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <p class="mb-0">Previous Month <span class="text-muted">$1,15,852</span></p>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3">
                                <div> <span class="d-block">Expenses</span> </div>
                                <div> <span class="text-danger">-2.8%</span> </div>
                            </div>
                            <h3 class="mb-3">$8,500</h3>
                            <div class="progress mb-2" style="height: 5px;">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 70%;" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <p class="mb-0">Previous Month <span class="text-muted">$7,500</span></p>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3">
                                <div> <span class="d-block">Profit</span> </div>
                                <div> <span class="text-danger">-75%</span> </div>
                            </div>
                            <h3 class="mb-3">$1,12,000</h3>
                            <div class="progress mb-2" style="height: 5px;">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 70%;" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <p class="mb-0">Previous Month <span class="text-muted">$1,42,000</span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- message --}}
        {!! Toastr::message() !!}
        <!-- Statistics Widget -->
        <div class="row">
            <div class="col-md-12 col-lg-12 col-xl-4 d-flex">
                <div class="card flex-fill">
                    <div class="card-body">
                    <h4 class="card-title">Leaves Statistics</h4>
                        <div class="statistics">
                            <div class="row">
                                <div class="col-md-6 col-6 text-center">
                                    <div class="stats-box mb-4">
                                        <p>Total Leaves</p>
                                        <h3>{{$totalLeaves}}</h3>
                                    </div>
                                </div>
                                <div class="col-md-6 col-6 text-center">
                                    <div class="stats-box mb-4">
                                        <p>Today Leaves</p>
                                        <h3>{{$todayLeaves}}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <?php $competedTask = $task - $pendingTask ?>
                            <p><i class="fa fa-dot-circle-o text-purple mr-2"></i>Total Leaves <span class="float-right">{{$totalLeaves}}</span></p>
                            <p><i class="fa fa-dot-circle-o text-success mr-2"></i>Approved Leaves <span class="float-right">{{$approvedLeaves}}</span></p>
                            <p><i class="fa fa-dot-circle-o text-warning mr-2"></i>Pending Leaves <span class="float-right">{{$pendingLeaves}}</span></p>
                            <p><i class="fa fa-dot-circle-o text-danger  mr-2"></i>Declined Leaves <span class="float-right">{{$declineLeaves}}</span></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-6 col-xl-4 d-flex">
                <div class="card flex-fill">
                    <div class="card-body">
                        <h4 class="card-title">Task Statistics</h4>
                        <div class="statistics">
                            <div class="row">
                                <div class="col-md-6 col-6 text-center">
                                    <div class="stats-box mb-4">
                                        <p>Total Tasks</p>
                                        <h3>{{$task}}</h3>
                                    </div>
                                </div>
                                <div class="col-md-6 col-6 text-center">
                                    <div class="stats-box mb-4">
                                        <p>Pending Task</p>
                                        <h3>{{$pendingTask}}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <?php $competedTask = $task - $pendingTask ?>
                            <p><i class="fa fa-dot-circle-o text-purple mr-2"></i>Total Tasks <span class="float-right">{{$task}}</span></p>
                            <p><i class="fa fa-dot-circle-o text-success  mr-2"></i>Completed Tasks <span class="float-right">{{$competedTask}}</span></p>
                            <p><i class="fa fa-dot-circle-o text-danger mr-2"></i>Pending Tasks <span class="float-right">{{$pendingTask}}</span></p>
                            <p><i class="fa fa-dot-circle-o text-warning mr-2"></i>Inprogress Tasks <span class="float-right">{{$pendingTask}}</span></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-6 col-xl-4 d-flex">
                <div class="card flex-fill">
                    <div class="card-body">
                        <h4 class="card-title">Today Absent <span class="badge bg-inverse-danger ml-2">{{$todayLeaves}}</span></h4>
                        <div class="leave-info-box">
                            @foreach($leaveList as $list)
                            <div class = "stats-info " >
                            <div class="col-6">
                               <h5>{{$list->name}}</h5>
                            </div >
                            <div class="row align-items-center mt-3">
                                <div class="col-6 ">
                                    <h6 class="mb-0">{{$list->from_date}}</h6> <span class="text-sm text-muted">Leave Date</span>
                                </div>
                                <div class="col-6 text-right"> <span class="badge bg-inverse-danger">{{$list->leave_status}}</span> </div>
                            </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="load-more text-center"> <a class="text-dark" href="{{route('form/leaves/new')}}">Load More</a> </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Statistics Widget -->
        <div class="row">
            <div class="col-md-6 d-flex">
                <div class="card card-table flex-fill">
                    <div class="card-header">
                        <h3 class="card-title mb-0">Users</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table custom-table mb-0">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Status</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($employees as $employee)
                                    <tr>
                                        <td>{{$employee->name}} <br><span>{{$employee->position}}</span></td>
                                        <td>{{$employee->email}}</td>
                                        <td>
                                            <div class="dropdown action-label">
                                                @if ($employee->status=='Active')
                                                <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa fa-dot-circle-o text-success"></i>
                                                    <span class="statuss">{{ $employee->status }}</span>
                                                </a>
                                                @elseif ($employee->status=='Inactive')
                                                <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa fa-dot-circle-o text-info"></i>
                                                    <span class="statuss">{{ $employee->status }}</span>
                                                </a>
                                                @elseif ($employee->status=='Disable')
                                                <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa fa-dot-circle-o text-danger"></i>
                                                    <span class="statuss">{{ $employee->status }}</span>
                                                </a>
                                                @elseif ($employee->status=='')
                                                <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa fa-dot-circle-o text-dark"></i>
                                                    <span class="statuss">N/A</span>
                                                </a>
                                                @endif

                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="#">
                                                        <i class="fa fa-dot-circle-o text-success"></i> Active
                                                    </a>
                                                    <a class="dropdown-item" href="#">
                                                        <i class="fa fa-dot-circle-o text-warning"></i> Inactive
                                                    </a>
                                                    <a class="dropdown-item" href="#">
                                                        <i class="fa fa-dot-circle-o text-danger"></i> Disable
                                                    </a>
                                                </div>
                                            </div>
                                        </td>

                                        @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer"> <a href="{{ route('all/employee/card') }}">View all Employees</a> </div>
                </div>
            </div>
            <div class="col-md-6 d-flex">
                <div class="card card-table flex-fill">
                    <div class="card-header">
                        <h3 class="card-title mb-0">Admins</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table custom-table mb-0">
                                <thead>
                                    <tr>
                                        <th>Name </th>
                                        <th>Email</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($admins as $admin)
                                    <tr>
                                        <td>{{$admin->name}} <br><span>{{$admin->position}}</span></td>
                                        <td>{{$admin->email}}</td>
                                        <td>
                                            <div class="dropdown action-label">
                                                @if ($admin->status=='Active')
                                                <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa fa-dot-circle-o text-success"></i>
                                                    <span class="statuss">{{ $admin->status }}</span>
                                                </a>
                                                @elseif ($admin->status=='Inactive')
                                                <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa fa-dot-circle-o text-info"></i>
                                                    <span class="statuss">{{ $admin->status }}</span>
                                                </a>
                                                @elseif ($admin->status=='Disable')
                                                <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa fa-dot-circle-o text-danger"></i>
                                                    <span class="statuss">{{ $admin->status }}</span>
                                                </a>
                                                @elseif ($admin->status=='')
                                                <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa fa-dot-circle-o text-dark"></i>
                                                    <span class="statuss">N/A</span>
                                                </a>
                                                @endif

                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="#">
                                                        <i class="fa fa-dot-circle-o text-success"></i> Active
                                                    </a>
                                                    <a class="dropdown-item" href="#">
                                                        <i class="fa fa-dot-circle-o text-warning"></i> Inactive
                                                    </a>
                                                    <a class="dropdown-item" href="#">
                                                        <i class="fa fa-dot-circle-o text-danger"></i> Disable
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!--   <div class="card-footer">
                            <a href="projects.html">View all Admins</a>
                        </div>-->
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 d-flex">
                <div class="card card-table flex-fill">
                    <div class="card-header">
                        <h3 class="card-title mb-0">Invoices</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-nowrap custom-table mb-0">
                                <thead>
                                    <tr>
                                        <th>Invoice ID</th>
                                        <th>Client</th>
                                        <th>Due Date</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><a href="invoice-view.html">#INV-0001</a></td>
                                        <td>
                                            <h2><a href="#">Global Technologies</a></h2>
                                        </td>
                                        <td>11 Mar 2019</td>
                                        <td>$380</td>
                                        <td> <span class="badge bg-inverse-warning">Partially Paid</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><a href="invoice-view.html">#INV-0002</a></td>
                                        <td>
                                            <h2><a href="#">Delta Infotech</a></h2>
                                        </td>
                                        <td>8 Feb 2019</td>
                                        <td>$500</td>
                                        <td>
                                            <span class="badge bg-inverse-success">Paid</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><a href="invoice-view.html">#INV-0003</a></td>
                                        <td>
                                            <h2><a href="#">Cream Inc</a></h2>
                                        </td>
                                        <td>23 Jan 2019</td>
                                        <td>$60</td>
                                        <td>
                                            <span class="badge bg-inverse-danger">Unpaid</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="invoices.html">View all invoices</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 d-flex">
                <div class="card card-table flex-fill">
                    <div class="card-header">
                        <h3 class="card-title mb-0">Payments</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table custom-table table-nowrap mb-0">
                                <thead>
                                    <tr>
                                        <th>Invoice ID</th>
                                        <th>Client</th>
                                        <th>Payment Type</th>
                                        <th>Paid Date</th>
                                        <th>Paid Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><a href="invoice-view.html">#INV-0001</a></td>
                                        <td>
                                            <h2><a href="#">Global Technologies</a></h2>
                                        </td>
                                        <td>Paypal</td>
                                        <td>11 Mar 2019</td>
                                        <td>$380</td>
                                    </tr>
                                    <tr>
                                        <td><a href="invoice-view.html">#INV-0002</a></td>
                                        <td>
                                            <h2><a href="#">Delta Infotech</a></h2>
                                        </td>
                                        <td>Paypal</td>
                                        <td>8 Feb 2019</td>
                                        <td>$500</td>
                                    </tr>
                                    <tr>
                                        <td><a href="invoice-view.html">#INV-0003</a></td>
                                        <td>
                                            <h2><a href="#">Cream Inc</a></h2>
                                        </td>
                                        <td>Paypal</td>
                                        <td>23 Jan 2019</td>
                                        <td>$60</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="payments.html">View all payments</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- /Page Content -->
</div>
@section('style')
<style>
    .progress {
    width: 80%;
    margin: 50px auto;
    border: 1px solid #ccc;
    height: 20px;
}
    .progress-bar {
    width: 0;
    height: 100%;
    background-color: #4caf50;
    transition: width 0.3s;
}
</style>
@section('script')

<script> 
$(document).ready(function() {
    Morris.Line({
		element: 'line-charts',
		data: [
			{ y: '2006', a: 50, b: 90 },
			{ y: '2007', a: 75,  b: 65 },
			{ y: '2008', a: 50,  b: 40 },
			{ y: '2009', a: 75,  b: 65 },
			{ y: '2010', a: 50,  b: 40 },
			{ y: '2011', a: 75,  b: 65 },
			{ y: '2012', a: 100, b: 50 }
		],
		xkey: 'y',
		ykeys: ['a', 'b'],
		labels: ['Total Sales', 'Total Revenue'],
		lineColors: ['#f43b48','#453a94'],
		lineWidth: '3px',
		resize: true,
		redraw: true
	});
});
</script>
@endsection
@endsection