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

            </div>
        </div>
        <!-- /Page Header -->

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
                                <th>Task Description</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Status</th>
                                <th class="text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tasks as $detail)
                            <tr>
                                <td class="id" hidden>{{$detail->task_id}}</td>
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
                                        <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">
                                            <i class="{{$design}}"></i> {{$detail->status}}
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item changeStatusApprove" href="#" data-toggle="modal" data-target="#approve_leave"><i class="fa fa-dot-circle-o text-success"></i> Complete</a>

                                        </div>
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
        <div class="modal custom-modal fade" id="approve_leave" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-header">
                            <h3>Task Status</h3>
                            <p>Are you sure want to change the status?</p>
                        </div>
                        <div class="modal-btn delete-action">
                            <form action="{{ route('taskemployee/status') }}" method="POST">
                                @csrf
                                <input type="text" hidden name="id" class="e_id" value="">
                                <input type="hidden" name="status" class="statusval">
                                <div class="row">
                                    <div class="col-6">
                                        <button type="submit" class="btn btn-primary continue-btn submit-btn aproveDeclineText"></button>
                                    </div>
                                    <div class="col-6">
                                        <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-primary cancel-btn">Cancel</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Page Content -->


</div>
</div>
@section('script')
<script>
    // select auto email
    $('#employee_name').on('change', function() {
        $('#department').val($(this).find(':selected').data('department'));
    });
</script>
<script>
    $(document).on('click', '.changeStatusApprove', function() {
        var _this = $(this).parents('tr');
        $('.e_id').val(_this.find('.id').text());
        $('.statusval').val(_this.find('.changeStatusApprove').text());
        $('.aproveDeclineText').html("Complete");
        console.log('Status Changed')
    })
</script>
@endsection
@endsection