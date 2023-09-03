<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\AttendanceType;

class AttendanceLog extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'schedule_id', 'log_time', 'log_type'];

    protected $casts = [
        'log_type' => AttendanceType::class,
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
