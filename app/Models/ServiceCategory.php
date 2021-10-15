<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceCategory extends Model
{
    use HasFactory, SoftDeletes;
    protected $dates = ['deleted_at'];
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name','images',
    ];
    public function employees()
    {
        return $this->hasMany(Employee::class, 'service_category_id');
    }
    public function services()
    {
        return $this->hasMany(Service::class, 'service_category_id');
    }
}
