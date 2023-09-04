<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\AttendanceType;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AttendanceLog extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'store_id', 'schedule_id', 'log_time', 'log_type'];

    protected $casts = [
        'log_type' => AttendanceType::class,
    ];

    public function store() : BelongsTo {
        return $this->belongsTo(Store::class);
    }

    public function user() : BelongsTo {
        return $this->belongsTo(User::class);
    }
}
