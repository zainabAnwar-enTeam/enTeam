<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffSalary extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'user_email',
        'user_id',
        'department',
        'basic_salary',
        'incentive_pay',
        'conveyance_allowance',
        'house_rent_allowance',
        'medical_allowance',
        'provident_fund',
        'leaves',
        'prof_tax',
        'health_insurance',
    ];
}
