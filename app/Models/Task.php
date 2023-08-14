<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'task_name',
        'task_description',
        'employee_name',
        'department',
        'worth_of_task',
        'status',
        'starting_date',
        'ending_date',
        'submitted_date',
    ];
}
