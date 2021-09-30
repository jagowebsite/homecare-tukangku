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
        'salary_employee',
        'verified_at',
    ];
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

}
