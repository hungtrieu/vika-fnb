<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payroll extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'pay_date', 'total_hours', 'salary', 'deductions', 'net_salary'];

    public function user() : BelongsTo {
        return $this->belongsTo(User::class);
    }
}
