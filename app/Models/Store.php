<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Store extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'address', 'phone', 'status'];

    public function user() : HasMany {
        return $this->hasMany(User::class);
    }

    public function floors() : HasMany {
        return $this->hasMany(Floor::class);
    }

    public function menus() : HasMany {
        return $this->hasMany(Menu::class);
    }

    public function orders() : HasMany {
        return $this->hasMany(Order::class);
    }
}
