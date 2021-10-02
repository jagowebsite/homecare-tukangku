<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use HasFactory, SoftDeletes;
    protected $dates = ['deleted_at'];
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'service_category_id',
        'name',
        'type_quantity',
        'price',
        'images',
        'description',
        'status',
    ];
    public function servicecategory()
    {
        return $this->belongsTo(ServiceCategory::class, 'service_category_id');
    }
    public function orderdetails()
    {
        return $this->hasMany(OrderDetail::class, 'service_id');
    }
    public function orderconfirmations()
    {
        return $this->hasMany(OrderConfirmation::class, 'service_id');
    }
}