<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use HasFactory, SoftDeletes;
    protected $dates = ['deleted_at'];
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'order_id',
        'account_payment_id',
        'payment_code',
        'type',
        'type_transfer',
        'images_payment',
        'images_user',
        'bank_number',
        'bank_name',
        'account_name',
        'latitude',
        'longitude',
        'total_payment',
        'status_payment',
        'description',
        'address',
        'verified_at',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
    public function accountPayment()
    {
        return $this->belongsTo(AccountPayment::class, 'account_payment_id');
    }
}
