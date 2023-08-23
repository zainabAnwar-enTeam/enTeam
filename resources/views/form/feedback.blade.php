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
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title"> Feedback <span id="year"></span></h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Feedback</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_feedback"><i class="fa fa-plus"></i> Add Feedback</a>
                </div>
            </div>
        </div>

    </div>
    <!-- /Page Content -->

   


</div>
<!-- /Page Wrapper -->

<!-- Add Feedback Modal -->
    <div id="add_feedback" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Feedback</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('form/feedback/admin') }}" method="POST">
                        @csrf
                        <div class="row filter-row">
                            <div class="col-sm-3 ">
                                <div class="form-group form-focus select-focus">
                                    <select class="select" name="feedbackof" id="feedbackof">
                                        <option selected disabled> -- Select -- </option>
                                        @foreach($getallemployee as $employyedata)
                                        <option name="feedbackof" vlaue="{{$employyedata->name}}">{{$employyedata->name}}</option>
                                        @endforeach
                                    </select>
                                    <label class="focus-label">Employee List</label>
                                </div>
                            </div>
                            <div class="col-sm-9 ">
                                <div class="form-group form-focus select-focus">
                                    <label class="focus-label">Rate Employee</label>
                                    <br>
                                    <div class="pl-3">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="feedbackrating" id="inlineRadio1" value="1">
                                            <label class="form-check-label" for="inlineRadio1">Not Satisfied</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="feedbackrating" id="inlineRadio2" value="2">
                                            <label class="form-check-label" for="inlineRadio2">Slow Progress</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="feedbackrating" id="inlineRadio2" value="3">
                                            <label class="form-check-label" for="inlineRadio2">Average</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="feedbackrating" id="inlineRadio2" value="4">
                                            <label class="form-check-label" for="inlineRadio2">Good</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="feedbackrating" id="inlineRadio2" value="5">
                                            <label class="form-check-label" for="inlineRadio2">Execellent</label>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="row filter-row">
                            <div class="col-md-12 ">
                                <div class="form-floating">
                                <label class="focus-label">Addition Information</label>
                                    <textarea class="form-control" placeholder="Describe the Employee in few words" name="feedbackdescription" id="floatingTextarea2" style="height: 100px"></textarea>

                                </div>
                            </div>
                        </div>
                        <div class="submit-section">
                            <button type="submit" class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<!-- /Add Feedback Modal -->


@endsection