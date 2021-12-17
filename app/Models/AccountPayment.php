<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountPayment extends Model
{
    use HasFactory;
    protected $fillable = ['account_name', 'account_number', 'bank_name', 'is_active'];
    public function payments()
    {
        return $this->hasMany(Payment::class, 'account_payment_id');
    }
}
