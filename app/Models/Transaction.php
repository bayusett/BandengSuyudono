<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'customers_id',
        'no_invoice',
        'transaction_status',
        'total_price',
        'payment_status',
        'transaction_status'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customers_id', 'id');
    }
    public function TransactionDetails()
    {
        # code...
        return $this->hasMany(TransactionDetail::class, 'transactions_id', 'id');
    }
}
