<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ShippingAddress;

class Order extends Model
{
    use HasFactory;

    // Define the table associated with the model
    protected $table = 'orders';

    // Define the fields that can be mass-assigned
    protected $fillable = [
        'vendor_id',
        'customer_id',
        'guest_email',
        'total_amount',
        'status',
        'payment_method',
        'created_at',
        'updated_at',
    ];

    // Define the relationship with the Product model (assuming you have a Product model)
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function details()
    {
        return $this->hasMany(OrderDetail::class, 'order_id');
    }

    public function shippingAddress()
    {
        return $this->hasOne(ShippingAddress::class, 'order_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
