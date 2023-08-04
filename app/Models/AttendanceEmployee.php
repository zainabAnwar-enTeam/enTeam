<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\User;

class AttendanceEmployee extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'user_name',
        'punch_in',
        'punch_out',
        'total_hours',
        'status',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}
