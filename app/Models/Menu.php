<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'store_id', 'status'];

    public function items() : HasMany {
        return $this->hasMany(MenuItem::class);
    }

    public function store() : BelongsTo {
        return $this->belongsTo(Store::class);
    }
}
