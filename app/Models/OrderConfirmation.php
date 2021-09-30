<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderConfirmation extends Model
{
    use HasFactory, SoftDeletes;
    protected $dates = ['deleted_at'];
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'employee_id',
        'order_id',
        'service_id',
        'work_duration',
        'type_work_duration',
        'description',
        'verified_at',
    ];
}
