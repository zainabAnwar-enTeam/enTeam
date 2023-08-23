@extends('layouts.master')
@section('content')
<!-- Page Wrapper -->
<div class="page-wrapper">
    <!-- Page Content -->
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Leaves <span id="year"></span></h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Leaves</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_leave"><i class="fa fa-plus"></i> Add Leave</a>
                </div>
            </div>
        </div>

        <!-- Leave Statistics -->
        <div class="row">
            <div class="col-md-3">
                <div class="stats-info">
                    <h6>Annual Leave</h6>
                    <h4>12</h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-info">
                    <h6>Medical Leave</h6>
                    <h4>{{$medicalLeaves}}</h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-info">
                    <h6>Other Leave</h6>
                    <?php 
                        $otherLeaves = $lossOfPay + $casualLeaves;
                        $remainingLeaves = 12 - $medicalLeaves - $otherLeaves;
                    ?>
                    <h4>{{$otherLeaves}}</h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-info">
                    <h6>Remaining Leave</h6>
                    <h4>{{$remainingLeaves}}</h4>
                </div>
            </div>
        </div>
        <!-- /Leave Statistics -->

        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-striped custom-table mb-0 datatable">
                        <thead>
                            <tr>
                                <th>Leave Type</th>
                                <th>From</th>
                                <th>To</th>
                                <th>No of Days</th>
                                <th>Reason</th>
                                <th class="text-center">Status</th>
                                <th class="text-right">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @if(!empty($leaves))
                            @foreach ($leaves as $items )
                            <tr>
                                <td hidden class="id">{{ $items->id }}</td>
                                <td class="leave_type">{{$items->leave_type}}</td>
                                <td hidden class="from_date">{{ $items->from_date }}</td>
                                <td>{{date('d F, Y',strtotime($items->from_date)) }}</td>
                                <td hidden class="to_date">{{$items->to_date}}</td>
                                <td>{{date('d F, Y',strtotime($items->to_date)) }}</td>
                                <td class="day">{{$items->day}} Day</td>
                                <td class="leave_reason">{{$items->leave_reason}}</td>
                                <td class="text-center">
                                    <div class="dropdown action-label">
                                        <?php
                                        if ($items->leave_status == 'Incomplete') {
                                            $design = "fa fa-dot-circle-o text-danger";
                                        }
                                        else if ($items->leave_status == 'Complete') {
                                            $design = "fa fa-dot-circle-o text-success";
                                        }
                                        else
                                        {
                                            $design = "fa fa-dot-circle-o text-purple";
                                        }
                                        ?>
                                        <a class="btn btn-white btn-sm btn-rounded" href="#" data-toggle="dropdown" aria-expanded="false">
                                            <i class="{{$design}}"></i> {{$items->leave_status}}
                                        </a>
                                    </div>
                                </td>
                                <td class="text-right">
                                    <div class="dropdown dropdown-action">
                                        <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item leaveUpdate" data-toggle="modal" data-id="'.$items->id.'" data-target="#edit_leave"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                            <a class="dropdown-item leaveDelete" href="#" data-toggle="modal" data-target="#delete_approve"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
    <!-- /Page Content -->

    <!-- Add Leave Modal -->
    <div id="add_leave" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Leave</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('form/leaves/save') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Leave Type <span class="text-danger">*</span></label>
                            <select class="select" id="leaveType" name="leave_type">
                                <option selected disabled>Select Leave Type</option>
                                <option value="Casual Leave 12 Days">Casual Leave 12 Days</option>
                                <option value="Medical Leave">Medical Leave</option>
                                <option value="Loss of Pay">Loss of Pay</option>
                            </select>
                        </div>
                        <input type="hidden" class="form-control" id="user_id" name="user_id" value="{{ Auth::user()->user_id }}">
                        <div class="form-group">
                            <label>From <span class="text-danger">*</span></label>
                            <div class="cal-icon">
                                <input type="text" class="form-control datetimepicker" id="from_date" name="from_date">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>To <span class="text-danger">*</span></label>
                            <div class="cal-icon">
                                <input type="text" class="form-control datetimepicker" id="to_date" name="to_date">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Leave Reason <span class="text-danger">*</span></label>
                            <textarea rows="4" class="form-control" id="leave_reason" name="leave_reason"></textarea>
                        </div>
                        <div class="submit-section">
                            <button type="submit" class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Add Leave Modal -->

    <!-- Edit Leave Modal -->
    <div id="edit_leave" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Leave</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label>Leave Type <span class="text-danger">*</span></label>
                            <select class="select">
                                <option>Select Leave Type</option>
                                <option>Casual Leave 12 Days</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>From <span class="text-danger">*</span></label>
                            <div class="cal-icon">
                                <input class="form-control datetimepicker" value="01-01-2019" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>To <span class="text-danger">*</span></label>
                            <div class="cal-icon">
                                <input class="form-control datetimepicker" value="01-01-2019" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Number of days <span class="text-danger">*</span></label>
                            <input class="form-control" readonly type="text" value="2">
                        </div>
                        <div class="form-group">
                            <label>Remaining Leaves <span class="text-danger">*</span></label>
                            <input class="form-control" readonly value="12" type="text">
                        </div>
                        <div class="form-group">
                            <label>Leave Reason <span class="text-danger">*</span></label>
                            <textarea rows="4" class="form-control">Going to hospital</textarea>
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Edit Leave Modal -->

    <!-- Delete Leave Modal -->
    <div class="modal custom-modal fade" id="delete_approve" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-header">
                        <h3>Delete Leave</h3>
                        <p>Are you sure want to Cancel this leave?</p>
                    </div>
                    <div class="modal-btn delete-action">
                        <div class="row">
                            <div class="col-6">
                                <a href="javascript:void(0);" class="btn btn-primary continue-btn">Delete</a>
                            </div>
                            <div class="col-6">
                                <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-primary cancel-btn">Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Delete Leave Modal -->

</div>
<!-- /Page Wrapper -->
@endsection