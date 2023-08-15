<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CulinaryTable extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'floor_id'];

    public function floor() : BelongsTo {
        return $this->belongsTo(Floor::class);
    }
}