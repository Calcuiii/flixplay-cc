<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_number',
        'total_amount',
        'payment_status',
        'subscription_type',
        'expires_at',
        'midtrans_transaction_id',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationship dengan User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship dengan OrderItems
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}