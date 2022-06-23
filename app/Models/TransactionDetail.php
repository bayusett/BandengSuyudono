<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransactionDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'transactions_id',
        'products_id',
        'qty',
        'code',
        'notes',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'products_id', 'id')->withTrashed();
    }
    // public function transaction()
    // {
    //     return $this->hasOne(PaymentTransaction::class, 'id', 'payment_transactions_id')->withTrashed();
    // }
    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transactions_id', 'id');
    }
}
