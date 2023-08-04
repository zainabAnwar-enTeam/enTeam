@extends('layouts.master')
@section('content')
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
                                    <th>No</th>
                                    <th>User ID </th>
                                    <th>Punch In</th>
                                    <th>Punch Out</th>
                                    <th>Role</th>
                                    <th>Total Hours</th>
                                    <th>Overtime</th>
                                </tr>
                            </thead>
                            <tbody>
                               @foreach ($result as $key=>$user)
                                <tr>
                                <td  class="ids">{{ $user->id }}</td>
                                <td class="id">{{ $user->user_id }}</td>
                                <td class="punchin">{{ $user->punch_in }}</td>
                                <td class="punchout">{{ $user->punch_out }}</td>
                                <td class="">{{ $user->status }}</td>
                                <td class="workinghours">{{$user->total_hours}} </td>
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
@endsection