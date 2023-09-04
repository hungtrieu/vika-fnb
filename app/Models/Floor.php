<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Floor extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'store_id'];

    public function culinary_tables() : HasMany {
        return $this->hasMany(CulinaryTable::class);
    }

    public function store() : BelongsTo {
        return $this->belongsTo(Store::class);
    }
}
