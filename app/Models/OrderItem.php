<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'menu_id', 'menu_item_id', 'quantity', 'status'];

    public function order() : BelongsTo {
        return $this->belongsTo(Order::class);
    }

    public function menu() : BelongsTo {
        return $this->belongsTo(Menu::class);
    }

    public function menu_item() : BelongsTo {
        return $this->belongsTo(MenuItem::class);
    }


}
