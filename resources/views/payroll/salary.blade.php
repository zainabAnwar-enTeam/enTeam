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
                    <h3 class="page-title">Employee Salary <span id="year"></span></h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Salary</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_salary"><i class="fa fa-plus"></i> Add Salary</a>
                </div>
            </div>
        </div>

        <!-- Search Filter -->

        <div class="row filter-row">
            <div class="col-sm-4 ">
                <div class="form-group form-focus">
                    <input type="text" id="searchinput" class="form-control floating" id="name" name="name">
                    <label class="focus-label">Search Relevant Field</label>
                </div>
            </div>
            <div class="col-sm-4 ">
                <button type="submit" class="btn btn-success btn-block">Search</button>
            </div>
        </div>

        <!-- /Search Filter -->
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-striped custom-table datatable">
                        <thead>
                            <tr>
                                <th>Employee</th>
                                <th>Email</th>
                                <th>Department</th>
                                <th>Basic Salary</th>
                                <th>Total Earning</th>
                                <th>Deduction</th>
                                <th>Salary</th>
                                <th>Payslip</th>
                                <th class="text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($salaries as $salary)
                            <tr>
                            <td hidden class="user_id">{{$salary->user_id}}</td>
                            <td hidden class="id">{{$salary->id}}</td>
                                <td>{{$salary->name}}</td>
                                <td hidden class="name">{{$salary->name}}</td>
                                <td class="user_email">{{$salary->user_email}}</td>
                                <td class="department">{{$salary->department}}</td>
                                <td class="basic_salary">{{$salary->basic_salary}}</td>
                                <td hidden class="incentive_pay">{{$salary->incentive_pay}}</td>
                                <td hidden class="conveyance_allowance">{{$salary->conveyance_allowance}}</td>
                                <td hidden class="house_rent_allowance">{{$salary->house_rent_allowance}}</td>
                                <td hidden class="medical_allowance">{{$salary->medical_allowance}}</td>
                                <td hidden class="provident_fund">{{$salary->provident_fund}}</td>
                                <td hidden class="leaves">{{$salary->leaves}}</td>
                                <td hidden class="prof_tax">{{$salary->prof_tax}}</td>
                                <td hidden class="health_insurance">{{$salary->health_insurance}}</td>
                                <?php
                                $earning = $salary->basic_salary + $salary->incentive_pay + $salary->conveyance_allowance + $salary->house_rent_allowance + $salary->medical_allowance;
                                $deduction = $salary->provident_fund + $salary->leaves + $salary->prof_tax + $salary->health_insurance;
                                $total = $earning - $deduction;
                                ?>
                                <td>{{$earning}}</td>
                                <td>{{$deduction}}</td>
                                <td>{{$total}}</td>
                                <td><a class="btn btn-sm btn-primary" href="{{ url('form/salary/view/'.$salary->user_id) }}" target="_blank">Generate Slip</a></td>
                                <td class="text-right">
                                    <div class="dropdown dropdown-action">
                                        <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item userSalary" href="#" data-toggle="modal" data-target="#edit_salary"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                            <a class="dropdown-item salaryDelete" href="#" data-toggle="modal" data-target="#delete_salary"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
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

    <!-- Add Salary Modal -->
    <div id="add_salary" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Staff Salary</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('form/salary/save') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Select Staff</label>
                                    <select class="select floating" style="width: 100%;" tabindex="-1" aria-hidden="true" id="name" name="name">
                                        <option value="">-- Select --</option>
                                        @foreach ($userList as $key=>$user )
                                        <option value="{{ $user->name }}" data-user_email="{{ $user->email }}" data-user_id="{{$user->user_id}}" data-department="{{$user->department}}" data-leaves="{{ $leaves }}"  >{{ $user->name }} 

                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="col-sm-6">
                                <label class="col-form-label">Email</label>
                                <input class="form-control" type="email" id="user_email" name="user_email" placeholder="Auto Email" readonly>
                            </div>
                            <div class="col-sm-6">
                                <label class="col-form-label">ID</label>
                                <input class="form-control" type="text" id="user_id" name="user_id" placeholder="Auto Id" readonly>

                            </div>
                            <div class="col-sm-6">
                                <label class="col-form-label">Department</label>
                                <input class="form-control" type="text" id="department" name="department" placeholder="Auto Department" readonly>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <h4 class="text-primary">Earnings</h4>
                                <div class="form-group">
                                    <label>Basic</label>
                                    <input class="form-control @error('basic') is-invalid @enderror" type="number" name="basic_salary" id="basic_salary" value="{{ old('basic') }}" placeholder="Enter basic salary">
                                    @error('basic')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Incentive Pay</label>
                                    <input class="form-control @error('da') is-invalid @enderror" type="number" name="incentive_pay" id="incentive_pay" value="{{ old('da') }}" placeholder="Enter Incentive Pay">
                                    @error('da')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Conveyance Allowance</label>
                                    <input class="form-control @error('medical_allowance') is-invalid @enderror" type="number" name="conveyance_allowance" id="conveyance_allowance" value="{{ old('Conveyance_allowance') }}" placeholder="Enter Conveyance Allowance">
                                    @error('medical_allowance')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>House Rent Allowance</label>
                                    <input class="form-control @error('hra') is-invalid @enderror" type="number" name="house_rent_allowance" id="house_rent_allowance" value="{{ old('hra') }}" placeholder="Enter House Rent Allowance">
                                    @error('hra')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Medical Allowance</label>
                                    <input class="form-control @error('medical_allowance') is-invalid @enderror" type="number" name="medical_allowance" id="medical_allowance" value="{{ old('medical_allowance') }}" placeholder="Enter Medical Allowance">
                                    @error('medical_allowance')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <h4 class="text-primary">Deductions</h4>
                                <div class="form-group">
                                    <label>Provident Fund</label>
                                    <input class="form-control @error('tds') is-invalid @enderror" type="number" name="provident_fund" id="provident_fund" value="{{ old('tds') }}" placeholder="Enter Provident Fund">
                                    @error('tds')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Leaves</label>
                                    <input class="form-control" type="number" name="leaves" id="leaves" placeholder="Auto Leaves" readonly>
                                    @error('esi')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Prof. Tax</label>
                                    <input class="form-control @error('pf') is-invalid @enderror" type="number" name="prof_tax" id="prof_tax" value="{{ old('pf') }}" placeholder="Enter Prof. Tax">
                                    @error('pf')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Health Insurance</label>
                                    <input class="form-control @error('leave') is-invalid @enderror" type="text" name="health_insurance" id="health_insurance" value="{{ old('loan') }}" placeholder="Enter Group Insurance">
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
    <!-- /Add Salary Modal -->

    <!-- Edit Salary Modal -->
    <div id="edit_salary" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Staff Salary</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <form action="{{ route('form/salary/update') }}" method="POST">
                        @csrf
                       <input type="hidden" name="id" id="e_uid" value="">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Name Staff</label>
                                    <input class="form-control" type="name" id="e_name" name="name" readonly>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <label class="col-form-label">Email</label>
                                <input class="form-control" type="email" id="e_email" name="user_email" readonly>
                            </div>
                            <div class="col-sm-6">
                                <label class="col-form-label">ID</label>
                                <input class="form-control" type="text" id="e_id" name="user_id"  readonly>

                            </div>
                            <div class="col-sm-6">
                                <label class="col-form-label">Department</label>
                                <input class="form-control" type="text" id="e_department" name="department"  readonly>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <h4 class="text-primary">Earnings</h4>
                                <div class="form-group">
                                    <label>Basic</label>
                                    <input class="form-control " type="number" name="basic_salary" id="e_basic_salary" value="" >
                                </div>
                                <div class="form-group">
                                    <label>Incentive Pay</label>
                                    <input class="form-control" type="number" name="incentive_pay" id="e_incentive_pay" value="">
                                    
                                </div>
                                <div class="form-group">
                                    <label>Conveyance Allowance</label>
                                    <input class="form-control " type="number" name="conveyance_allowance" id="e_conveyance_allowance" value="">
                                   
                                </div>
                                <div class="form-group">
                                    <label>House Rent Allowance</label>
                                    <input class="form-control " type="number" name="house_rent_allowance" id="e_house_rent_allowance" value="">
                                
                                </div>
                                <div class="form-group">
                                    <label>Medical Allowance</label>
                                    <input class="form-control " type="number" name="medical_allowance" id="e_medical_allowance" value="" >
                                    
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <h4 class="text-primary">Deductions</h4>
                                <div class="form-group">
                                    <label>Provident Fund</label>
                                    <input class="form-control" type="number" name="provident_fund" id="e_provident_fund" value="" >
                
                                </div>
                                <div class="form-group">
                                    <label>Leaves</label>
                                    <input class="form-control " type="number" name="leaves" id="e_leaves" value=""  >
                                    
                                </div>
                                <div class="form-group">
                                    <label>Prof. Tax</label>
                                    <input class="form-control " type="number" name="prof_tax" id="e_prof_tax" value="">
                                    
                                </div>
                                <div class="form-group">
                                    <label>Health Insurance</label>
                                    <input class="form-control " type="text" name="health_insurance" id="e_health_insurance" value="" >
                                    
                                </div>

                            </div>
                        </div>
                        <div class="submit-section">
                            <button type="submit" class="btn btn-primary submit-btn">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Edit Salary Modal -->

    <!-- Delete Salary Modal -->
    <div class="modal custom-modal fade" id="delete_salary" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-header">
                        <h3>Delete Salary</h3>
                        <p>Are you sure want to delete?</p>
                    </div>
                    <div class="modal-btn delete-action">
                        <form action="{{ route('form/salary/delete') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-6">
                                    <input type="hidden" name="user_id" class="e_uid" value="">
                                    <button type="submit" class="btn btn-primary continue-btn submit-btn">Delete</button>
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
    <!-- /Delete Salary Modal -->

</div>
<!-- /Page Wrapper -->
@section('script')
<script>
    $(document).ready(function() {
        $('.select2s-hidden-accessible').select2({
            closeOnSelect: false
        });
    });
</script>
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
    // select auto id and email and department
    $('#name').on('change', function() {
        $('#user_id').val($(this).find(':selected').data('user_id'));
        $('#user_email').val($(this).find(':selected').data('user_email'));
        $('#department').val($(this).find(':selected').data('department'));
        $('#leaves').val($(this).find(':selected').data('leaves'));
    });
</script>
{{-- update js --}}
<script>
    $(document).on('click', '.userSalary', function() {
        var _this = $(this).parents('tr');
        $('#e_uid').val(_this.find('.id').text());
        $('#e_id').val(_this.find('.user_id').text());
        $('#e_name').val(_this.find('.name').text());
        $('#e_email').val(_this.find('.user_email').text());
        $('#e_department').val(_this.find('.department').text());
        $('#e_basic_salary').val(_this.find('.basic_salary').text());
        $('#e_incentive_pay').val(_this.find('.incentive_pay').text());
        $('#e_conveyance_allowance').val(_this.find('.conveyance_allowance').text());
        $('#e_house_rent_allowance').val(_this.find('.house_rent_allowance').text());
        $('#e_medical_allowance').val(_this.find('.medical_allowance').text());
        $('#e_provident_fund').val(_this.find('.provident_fund').text());
        $('#e_leaves').val(_this.find('.leaves').text());
        $('#e_prof_tax').val(_this.find('.prof_tax').text());
        $('#e_health_insurance').val(_this.find('.health_insurance').text());
      
    });
</script>
{{-- delete js --}}
<script>
    $(document).on('click', '.salaryDelete', function() {
        var _this = $(this).parents('tr');
        $('.e_uid').val(_this.find('.id').text());
    });
</script>



@endsection
@endsection