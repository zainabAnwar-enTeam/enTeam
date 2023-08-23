@extends('layouts.master')
@section('content')

<!--Page Wrap-->
<div class="page-wrapper">
    <!-- Page Content -->
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Tasks</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{route('home')}}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">Task</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_task"><i class="fa fa-plus"></i> Add Task</a>
                </div>
            </div>
        </div>
        <!-- /Page Header -->
        <!-- Leave Statistics -->
        <div class="row">
            <div class="col-md-4">
                <div class="stats-info">
                    <h6>Total Tasks</h6>
                    <h4>{{$totalTask}}</h4>

                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-info">
                    <h6>Completed Tasks</h6>
                    <h4>{{$completeTask}}</h4>
                </div>
            </div>

            <div class="col-md-4">
                <div class="stats-info">
                    <h6>Pending Tasks</h6>
                    <h4>{{$pendingTask}}</h4>
                </div>
            </div>
        </div>
        <!-- /Leave Statistics -->
        <!-- Search Filter -->

        <div class="row filter-row">
            <div class="col-md-8">
                <div class="form-group form-focus">
                    <input type="text" id="searchinput" class="form-control floating" name="task_name">
                    <label class="focus-label">Search Field</label>
                </div>
            </div>
            <div class=" col-md-4">
                <button type="sumit" class="btn btn-success btn-block"> Search </button>
            </div>
        </div>


        <!-- Search Filter -->

        {{-- message --}}
        {!! Toastr::message() !!}
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-striped custom-table datatable">
                        <thead>
                            <tr>
                                <th>Task Name</th>
                                <th>User Name</th>
                                <th hidden></th>
                                <th>Task Description</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Status</th>
                                <th class="text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($task as $detail)
                            <tr>
                                <td class="task_name">{{$detail->task_name}}</td>
                                <td class="employee_name">{{$detail->employee_name }}</td>
                                <td class="task_description">{{$detail->task_description}}</td>
                                <td class="starting_date">{{$detail->starting_date}}</td>
                                <td class="ending_date">{{$detail->ending_date}}</td>
                                <td class="text-center">
                                    <div class="dropdown action-label">
                                        <?php
                                        if ($detail->status == 'Incompleted') {
                                            $design = "fa fa-dot-circle-o text-danger";
                                        } else if ($detail->status == 'Complete') {
                                            $design = "fa fa-dot-circle-o text-success";
                                        } else {
                                            $design = "fa fa-dot-circle-o text-purple";
                                        }
                                        ?>
                                        <a class="btn btn-white btn-sm btn-rounded" href="#" data-toggle="dropdown" aria-expanded="false">
                                            <i class="{{$design}}"></i> {{$detail->status}}
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
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- /Page Content -->

    <!-- Add Task Modal -->
    <div id="add_task" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Task</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form action="{{ route('task/save') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Task Name</label>
                                    <input class="form-control" type="text" id="task_name" name="task_name" value="{{ old('task_name') }}" placeholder="Enter Task Name">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label class="col-form-label">Employee Name</label>

                                <select class="select select2s-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" id="employee_name" name="employee_name">
                                    <option value="">-- Select --</option>
                                    @foreach ($employee as $key=>$user )
                                    <option value="{{ $user->name }}" data-department={{ $user->department}}> {{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <label class="col-form-label">Department</label>
                                <input class="form-control" type="department" id="department" name="department" placeholder="Auto Department" readonly>
                            </div>

                            <div class="col-sm-6">
                                <label>Worth of Task</label>
                                <select id="worth_of_task" name="worth_of_task" class="select">
                                    <option selected disabled> --Select --</option>
                                    <option>Low</option>
                                    <option>Medium</option>
                                    <option>Hight</option>
                                </select>
                            </div>
                        </div>

                        <br>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>From <span class="text-danger">*</span></label>
                                    <div class="cal-icon">
                                        <input type="text" class="form-control datetimepicker" id="starting_date" name="starting_date">
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <label>To</label>
                                <div class="cal-icon">
                                    <input type="text" class="form-control datetimepicker" id="ending_date" name="ending_date">
                                </div>
                            </div>

                        </div>

                        <div class="form-group">
                            <label>Description <span class="text-danger">*</span></label>
                            <textarea rows="4" class="form-control" id="task_description" name="task_description"></textarea>
                        </div>

                        <div class="submit-section">
                            <button type="submit" class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Add Model -->
</div>
</div>
@section('script')
<script>
    //Search Task |
    $('#searchinput').keydown(function() {
        var SearchTask = $(this).val().toLowerCase();
        $('.table tbody tr').each(function() {
            var rowText = $(this).text().toLowerCase();
            if (SearchTask === '') {
                $(this).show();
            }
            if (rowText.indexOf(SearchTask) === -1) {
                $(this).hide();
            } else {
                $(this).show();
            }
        });
    });
    // select auto email
    $('#employee_name').on('change', function() {
        $('#department').val($(this).find(':selected').data('department'));
    });
    $("#searchTheKey").on('keyup', function() {
        var value = $(this).val().toLowerCase();
        $("#matchKey li").each(function() {
            if ($(this).text().toLowerCase().search(value) > -1) {
                $(this).show();
                $(this).prev('.subjectName').last().show();
            } else {
                $(this).hide();
            }
        });
    })
</script>


@endsection
@endsection