<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'store_id', 'floor_id', 'culinary_table_id', 'user_id', 'amount', 'status'];

    public function items() : HasMany {
        return $this->hasMany(OrderItem::class);
    }

    public function floor() : BelongsTo {
        return $this->belongsTo(Floor::class);
    }

    public function culinary_table() : BelongsTo {
        return $this->belongsTo(CulinaryTable::class);
    }

    public function user() : BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function store() : BelongsTo {
        return $this->belongsTo(Store::class);
    }

    public static function generateCode() : string {
        $latestOrder = Order::orderBy('created_at','DESC')->first();

        if($latestOrder) {
            return 'ORD-'.str_pad($latestOrder->id + 1, 8, "0", STR_PAD_LEFT);
        }
        return 'ORD-'.str_pad(1, 8, "0", STR_PAD_LEFT);
    }
}
