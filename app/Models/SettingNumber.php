<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingNumber extends Model
{
    use HasFactory;
    protected $fillable = ['type', 'number', 'message'];
   
}
