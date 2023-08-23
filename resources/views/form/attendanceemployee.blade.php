<?php

use App\Models\AttendanceEmployee;

$a = Auth::user();
?>
@extends('layouts.master')
@section('content')
   
{{-- message --}}
{!! Toastr::message() !!}
    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <!-- Page Content -->
        <div class="content container-fluid">
            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title">Attendance</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Attendance</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            <div class="row">
                <div class="col-md-6">
                    <div class="card punch-status">
                        <div class="card-body">
                            <h5 class="card-title">Timesheet <small class="text-muted"   >  {{$date}}  </small></h5>
                            <div class="punch-det">
                                <h5>Punch In at</h5>
                                    <div  class="text-muted"  >{{$day}}</div>
                                    
                            </div>
                            
                            <div class="punch-hours" id="clock"> </div>
                            
                            <div class="d-flex justify-content-around">
                                <div  class="punch-btn-section">
                                    <form action="{{ route('attendance123') }}" method="POST" >
                                        @csrf
                                        <button type="submit" class="btn btn-primary punch-btn">Punch In</button>
                                    </form>
                                </div>
                             
                                <div class="punch-btn-section">
                                    <form action="{{ route('attendance1234') }}" method="POST">
                                    @csrf
                                        <button type="submit" class="btn btn-primary punch-btn">Punch Out</button>
                                    </form>
                                </div>
                            </div>
                            
                            <div class="statistics">
                                <div class="row">
                                    <div class="col-md-12 col-12 text-center">
                                        <div class="stats-box"> 
                                            <p>Today Spend Hours</p>
                                            @foreach($timediffer as $employee)
                                            <h6>{{$employee->total_hours}} </h6>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="card att-statistics">
                        <div class="card-body">
                            <h5 class="card-title">Statistics</h5>
                            <div class="stats-list">
                                <div class="stats-info">
                                    <p>Today <strong>@foreach($timediffer as $employee)
                                            {{$employee->total_hours}} 
                                            @endforeach <small>/ 8 hrs</small></strong></p>
                                    <div class="progress">
                                        
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: 31%" aria-valuenow="31" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="stats-info">
                                    <p>This Week <strong>28 <small>/ 40 hrs</small></strong></p>
                                    <div class="progress">
                                        <div class="progress-bar bg-warning" role="progressbar" style="width: 31%" aria-valuenow="31" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="stats-info">
                                    <p>This Month <strong>90 <small>/ 160 hrs</small></strong></p>
                                    <div class="progress">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 62%" aria-valuenow="62" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="stats-info">
                                    <p>Remaining <strong>90 <small>/ 160 hrs</small></strong></p>
                                    <div class="progress">
                                        <div class="progress-bar bg-danger" role="progressbar" style="width: 62%" aria-valuenow="62" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="stats-info">
                                    <p>Overtime <strong>4</strong></p>
                                    <div class="progress">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: 22%" aria-valuenow="22" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>    
            </div>
            <!-- Search Filter -->
            <div class="row filter-row">
                <div class="col-sm-3">  
                    <div class="form-group form-focus">
                        <div class="cal-icon">
                            <input type="text" class="form-control floating datetimepicker">
                        </div>
                        <label class="focus-label">Date</label>
                    </div>
                </div>
                <div class="col-sm-3"> 
                    <div class="form-group form-focus select-focus">
                        <select class="select floating"> 
                            <option>-</option>
                            <option>Jan</option>
                            <option>Feb</option>
                            <option>Mar</option>
                            <option>Apr</option>
                            <option>May</option>
                            <option>Jun</option>
                            <option>Jul</option>
                            <option>Aug</option>
                            <option>Sep</option>
                            <option>Oct</option>
                            <option>Nov</option>
                            <option>Dec</option>
                        </select>
                        <label class="focus-label">Select Month</label>
                    </div>
                </div>
                <div class="col-sm-3"> 
                    <div class="form-group form-focus select-focus">
                        <select class="select floating"> 
                            <option>-</option>
                            <option>2019</option>
                            <option>2018</option>
                            <option>2017</option>
                            <option>2016</option>
                            <option>2015</option>
                        </select>
                        <label class="focus-label">Select Year</label>
                    </div>
                </div>
                <div class="col-sm-3">  
                    <a href="#" class="btn btn-success btn-block"> Search </a>  
                </div>     
            </div>
            <!-- /Search Filter -->
            
            <div class="row">
                <div class="col-lg-12">
                    <div class="table-responsive">
                        <table class="table table-striped custom-table datatable">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Name </th>
                                    <th>Punch In</th>
                                    <th>Punch Out</th>
                                    <th>Today Spending Time</th>
                                </tr>
                            </thead>
                            <tbody>
                               @foreach($attendance as $employee)
                                <tr>
                                <td>{{$employee->date}}</td>
                                <td>{{$employee->name}}</td>
                                <td> {{$employee->punch_in}} </td>
                                <td> {{$employee->punch_out}} </td>
                                 <td> {{$employee->total_hours}} </td>
                                </tr>
                             @endforeach                               
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Content -->

        </div>
        <!-- /Page Content -->

   
    </div>
    <!-- /Page Wrapper -->

   
    @section('script')
    

    <script>
        // JavaScript code to display the current date and day
        document.getElementById('currentDate').textContent = new Date().toLocaleDateString();
        document.getElementById('currentDay').textContent = new Date().toLocaleString('en-us', { weekday: 'long' });
    </script>

<script>
document.getElementById("getTimeButton").addEventListener("click", function() {
  var currentTime = new Date();
  var currentTimeString = currentTime.toLocaleTimeString(); // Format the time as a string
  document.getElementById("currentTime").textContent = "Current Time: " + currentTimeString;
});
</script>
<script>function updateClock() {
    var now = new Date();
    var hours = now.getHours();
    var minutes = now.getMinutes();
    var seconds = now.getSeconds();

    var ampm = hours >= 12 ? 'PM' : 'AM';
    hours = hours % 12 || 12;
    // Format the time with leading zeros
    var formattedTime = `${hours}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')} ${ampm}`;

    // Update the clock's content
    document.getElementById('clock').textContent = formattedTime;
}

// Initial call to update the clock
updateClock();

// Update the clock every second
setInterval(updateClock, 1000);</script>
    @endsection
@endsection
