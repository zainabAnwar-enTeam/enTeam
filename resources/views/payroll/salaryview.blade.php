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
                    <h3 class="page-title">Payslip</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item">Dashboard</a></li>
                        <li class="breadcrumb-item active"></li><a href="{{ route('form/salary/page') }}">Payslip</a></li>
                    </ul>
                </div>

                <div class="btn-group">
                    <button class="btn btn-white" id="convertToCSV">CSV</button>
                    <button class="btn btn-white" id="pdfButton">PDF</button>
                    <button class="btn btn-white" id="printButton"><i class="fa fa-print fa-lg"></i>Print</button>
                </div>

            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="csv-data">
                        <div class="card-body" id="printContent">
                            <h4 class="payslip-title">Payslip for the month of {{ \Carbon\Carbon::now()->format('M') }} {{ \Carbon\Carbon::now()->year }} </h4>
                            <div class="row">
                                <div class="col-sm-6 m-b-20">
                                    <ul class="list-unstyled mb-0">
                                        <li><strong>EnTeam</strong> </li>
                                        <li>DHA Phase 6,</li>
                                        <li>Lahore, Pakistan</li>
                                    </ul>
                                </div>
                                <div class="col-sm-6 m-b-20">
                                    <div class="invoice-details">
                                        <h3 class="text-uppercase">Payslip <span id="randomNumber"></span></h3>
                                        <ul class="list-unstyled">
                                            <li>Salary Month: <span>{{ \Carbon\Carbon::now()->format('M') }} , {{ \Carbon\Carbon::now()->year }} </span></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 m-b-20">
                                    <ul class="list-unstyled">
                                        @foreach($users as $user)
                                        <li>
                                            <h5 class="mb-0"><strong>{{ $user->name }}</strong></h5>
                                        </li>
                                        <li><span>{{ $user->position }}</span></li>
                                        <li>Email: {{$user->user_email}}</li>
                                        <li>Department: {{ $user->department }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div>
                                        <h4 class="m-b-10"><strong>Earnings</strong></h4>
                                        <table class="table table-bordered">
                                            <tbody>
                                                @foreach($users as $user)
                                                <?php
                                                $a =  (int)$user->basic_salary;
                                                $b =  (int)$user->incentive_pay;
                                                $c =  (int)$user->conveyance_allowance;
                                                $d =  (int)$user->medical_allowance;
                                                $e =  (int)$user->house_rent_allowance;
                                                $Total_Earnings   = $a + $b + $c + $d + $e;
                                                ?>
                                                <tr>
                                                    <td><strong>Basic Salary</strong> <span class="float-right">${{ $user->basic_salary }}</span></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>House Rent Allowance</strong> <span class="float-right">${{ $user->house_rent_allowance }}</span></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Conveyance</strong> <span class="float-right">${{ $user->conveyance_allowance }}</span></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Incentive Pay</strong> <span class="float-right">${{ $user->incentive_pay }}</span></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Medical Allowance</strong> <span class="float-right">${{ $user->medical_allowance }}</span></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Total Earnings</strong> <span class="float-right"><strong>$ <?php echo $Total_Earnings ?></strong></span></td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div>
                                        <h4 class="m-b-10"><strong>Deductions</strong></h4>
                                        <table class="table table-bordered">
                                            <tbody>
                                                @foreach($users as $user)
                                                <?php
                                                $a =  (int)$user->provident_fund;
                                                $b =  (int)$user->leaves;
                                                $c =  (int)$user->prof_tax;
                                                $e =  (int)$user->health_insurance;
                                                $Total_Deductions   = $a + $b + $c + $e;
                                                ?>
                                                <tr>
                                                    <td><strong>Provident Fund</strong> <span class="float-right">${{ $user->provident_fund }}</span></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Leaves</strong> <span class="float-right">${{ $user->leaves }}</span></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Prof. Tax</strong> <span class="float-right">${{ $user->prof_tax }}</span></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Health Insurance</strong> <span class="float-right">${{ $user->health_insurance }}</span></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Total Deductions</strong> <span class="float-right"><strong>$<?php echo $Total_Deductions; ?></strong></span></td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    @foreach($users as $user)
                                    <?php
                                    $total = $Total_Earnings - $Total_Deductions;
                                    ?>
                                    <p><strong>Net Salary: <?php echo $total; ?></strong></p>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <!-- /Page Content -->
                    </div>
                </div>
                <!-- /Page Wrapper -->
            </div>
        </div>
    </div>
</div>
@section('script')

<script>
    $(document).ready(function() {
        var randomNum = Math.floor(Math.random() * 200) + 100;
        $("#randomNumber").text("#" + randomNum)
    });
</script>
<script>
    document.getElementById('convertToCSV').addEventListener('click', function() {
        const csvData = document.querySelector('.csv-data').textContent.trim(); // Get the HTML content of the CSV data
        const rows = csvData.split('\n'); // Split the CSV data into rows
        const csvContent = []; // Create an array to hold the CSV content
        rows.forEach(row => { // Loop through each row
            const columns = row.split(','); // Split the row into columns
            csvContent.push(columns.join(',')); // Push the columns into the csvContent array
        });
        const formattedCSV = csvContent.join('\n'); // Join the rows with newline characters
        const blob = new Blob([formattedCSV], {
            type: 'text/csv'
        }); // Create a Blob from the formatted CSV data
        const link = document.createElement('a'); // Create a download link
        link.href = URL.createObjectURL(blob);
        link.download = 'data.csv';
        link.click(); // Trigger the download
        URL.revokeObjectURL(link.href); // Clean up
    });
</script>
<script>
    document.getElementById('printButton').addEventListener('click', function() {
        const printContent = document.getElementById('printContent').innerHTML;
        const printWindow = window.open('', '_blank');
        printWindow.document.write('<html><head><title>Print</title></head><body>');
        printWindow.document.write(printContent);
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.onload = function() {
            printWindow.print();
        };
    });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
    document.getElementById('pdfButton').addEventListener('click', generatePDF);

    function generatePDF() {
        const element = document.getElementById('printContent').innerHTML; // Change this selector to target your specific content
        //console.log(element);
        const opt = {
            margin: 10,
            filename: 'output.pdf',
            image: {
                type: 'jpeg',
                quality: 0.98
            },
            html2canvas: {
                scale: 2
            },
            jsPDF: {
                unit: 'mm',
                format: 'a4',
                orientation: 'portrait'
            }
        };

        html2pdf().from(element).set(opt).toPdf().outputPdf().then(pdf => {
            const blob = new Blob([pdf], {
                type: 'application/pdf'
            });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.style.display = 'none';
            a.href = url;
            a.download = 'output.pdf';
            document.body.appendChild(a);
            a.click();
            window.URL.revokeObjectURL(url);
        });
    }
</script>









@endsection

@endsection