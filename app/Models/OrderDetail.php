<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderDetail extends Model
{
    use HasFactory, SoftDeletes;
    protected $dates = ['deleted_at'];
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'order_id',
        'service_id',
        'quantity',
        'price',
        'total_price',
        'description',
        'status_order_detail',
        'verified_at',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }
    public function orderConfirmation()
    {
        return $this->hasOne(OrderConfirmation::class, 'order_detail_id');
    }
}
