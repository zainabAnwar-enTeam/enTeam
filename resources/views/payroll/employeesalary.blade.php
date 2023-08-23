
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
                        <h3 class="page-title"> Employee Salary <span id="year"></span></h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Salary</li>
                        </ul>
                    </div>
                   
                </div>
            </div>

            
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-striped custom-table ">
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
                               @foreach($users as $salary)
                               <tr>
                                <td>{{$salary->name}}</td>
                                <td>{{$salary->user_email}}</td>
                                <td>{{$salary->department}}</td>
                                <td>{{$salary->basic_salary}}</td>
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
                                        <select class="select floating" style="width: 100%;" tabindex="-1" aria-hidden="true" id="name" name="name" >
                                            <option value="">-- Select --</option>
                                            @foreach ($userList as $key=>$user )
                                                <option value="{{ $user->name }}" data-user_email="{{ $user->email }}"data-user_id="{{$user->user_id}}"data-department="{{$user->department}}">{{ $user->name }}</option>
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
                                    <input class="form-control" type= "email" id="user_email" name="user_email" placeholder="Auto Email" readonly>
                                </div>
                                <div class="col-sm-6">
                                    <label class="col-form-label">ID</label>
                                    <input class="form-control" type= "text" id="user_id" name="user_id" placeholder="Auto Id" readonly>
                                    
                                </div>
                                <div class="col-sm-6">
                                    <label class="col-form-label">Department</label>
                                    <input class="form-control" type= "text" id="department" name="department" placeholder="Auto Department" readonly>
                                    
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
                                        <input class="form-control @error('da') is-invalid @enderror" type="number"  name="incentive_pay" id="incentive_pay" value="{{ old('da') }}" placeholder="Enter Incentive Pay">
                                        @error('da')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Conveyance  Allowance</label>
                                        <input class="form-control @error('medical_allowance') is-invalid @enderror" type="number" name="conveyance_allowance" id="conveyance_allowance" value="{{ old('Conveyance_allowance') }}" placeholder="Enter Conveyance Allowance">
                                        @error('medical_allowance')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>House Rent Allowance</label>
                                        <input class="form-control @error('hra') is-invalid @enderror" type="number"  name="house_rent_allowance" id="house_rent_allowance" value="{{ old('hra') }}" placeholder="Enter House Rent Allowance">
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
                                        <input class="form-control @error('esi') is-invalid @enderror" type="number" name="leaves" id="leaves" value="{{ old('esi') }}" placeholder="Enter Leaves">
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
                                        @error('Loan')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
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
                            <input class="form-control" type="hidden" name="id" id="e_id" value="" readonly>
                            <div class="row"> 
                                <div class="col-sm-6"> 
                                    <div class="form-group">
                                        <label>Name Staff</label>
                                        <input class="form-control " type="text" name="name" id="e_name" value="" readonly>
                                    </div>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-sm-6"> 
                                    <label>Net Salary</label>
                                    <input class="form-control" type="text" name="salary" id="e_salary" value="">
                                </div>
                            </div>
                            <div class="row"> 
                                <div class="col-sm-6"> 
                                    <h4 class="text-primary">Earnings</h4>
                                    <div class="form-group">
                                        <label>Basic</label>
                                        <input class="form-control" type="text" name="basic" id="e_basic" value="">
                                    </div>
                                    <div class="form-group">
                                        <label>DA(40%)</label>
                                        <input class="form-control" type="text"  name="da" id="e_da" value="">
                                    </div>
                                    <div class="form-group">
                                        <label>HRA(15%)</label>
                                        <input class="form-control" type="text"  name="hra" id="e_hra" value="">
                                    </div>
                                    <div class="form-group">
                                        <label>Conveyance</label>
                                        <input class="form-control" type="text"  name="conveyance" id="e_conveyance" value="">
                                    </div>
                                    <div class="form-group">
                                        <label>Allowance</label>
                                        <input class="form-control" type="text"  name="allowance" id="e_allowance" value="">
                                    </div>
                                    <div class="form-group">
                                        <label>Medical  Allowance</label>
                                        <input class="form-control" type="text" name="medical_allowance" id="e_medical_allowance" value="">
                                    </div>
                                </div>
                                <div class="col-sm-6">  
                                    <h4 class="text-primary">Deductions</h4>
                                    <div class="form-group">
                                        <label>TDS</label>
                                        <input class="form-control" type="text" name="tds" id="e_tds" value="">
                                    </div> 
                                    <div class="form-group">
                                        <label>ESI</label>
                                        <input class="form-control" type="text" name="esi" id="e_esi" value="">
                                    </div>
                                    <div class="form-group">
                                        <label>PF</label>
                                        <input class="form-control" type="text" name="pf" id="e_pf" value="">
                                    </div>
                                    <div class="form-group">
                                        <label>Leave</label>
                                        <input class="form-control" type="text" name="leave" id="e_leave" value="">
                                    </div>
                                    <div class="form-group">
                                        <label>Prof. Tax</label>
                                        <input class="form-control" type="text" name="prof_tax" id="e_prof_tax" value="">
                                    </div>
                                    <div class="form-group">
                                        <label>Loan</label>
                                        <input class="form-control" type="text" name="labour_welfare" id="e_labour_welfare" value="">
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
                                        <input type="hidden" name="id" class="e_id" value="">
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
            // select auto id and email and department
            $('#name').on('change',function()
            {
                $('#user_id').val($(this).find(':selected').data('user_id'));
                $('#user_email').val($(this).find(':selected').data('user_email'));
                $('#department').val($(this).find(':selected').data('department'));
            });
        </script>
        {{-- update js --}}
        <script>
            $(document).on('click','.userSalary',function()
            {
                var _this = $(this).parents('tr');
                $('#e_id').val(_this.find('.id').text());
                $('#e_name').val(_this.find('.name').text());
                $('#e_salary').val(_this.find('.salary').text());
                $('#e_basic').val(_this.find('.basic').text());
                $('#e_da').val(_this.find('.da').text());
                $('#e_hra').val(_this.find('.hra').text());
                $('#e_conveyance').val(_this.find('.conveyance').text());
                $('#e_allowance').val(_this.find('.allowance').text());
                $('#e_medical_allowance').val(_this.find('.medical_allowance').text());
                $('#e_tds').val(_this.find('.tds').text());
                $('#e_esi').val(_this.find('.esi').text());
                $('#e_pf').val(_this.find('.pf').text());
                $('#e_leave').val(_this.find('.leave').text());
                $('#e_prof_tax').val(_this.find('.prof_tax').text());
                $('#e_labour_welfare').val(_this.find('.labour_welfare').text());
            });
        </script>
         {{-- delete js --}}
    <script>
        $(document).on('click','.salaryDelete',function()
        {
            var _this = $(this).parents('tr');
            $('.e_id').val(_this.find('.id').text());
        });
    </script>



    @endsection
@endsection
