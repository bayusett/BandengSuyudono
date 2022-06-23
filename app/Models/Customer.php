<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'customers';
    protected $fillable = [
        'code',
        'name',
        'email',
        'password',
        'photos',
        'address',
        'phone_number',
        'provinces_id',
        'regencies_id',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function getAvatarUrlAttribute()
    {
        if ($this->photos != null) :
            return asset($this->photos);
        else :
            return 'https://ui-avatars.com/api/?name=' . str_replace(
                ' ',
                '+',
                $this->name
            ) . '&background=11cf00&color=ffffff&size=100';
        endif;
    }
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'customers_id', 'id');
    }

    public function carts()
    {
        return $this->hasMany(Cart::class, 'customers_id', 'id');
    }

    public function province()
    {
        return $this->belongsTo(Province::class, 'provinces_id', 'id');
    }

    public function regency()
    {
        return $this->belongsTo(Regency::class, 'regencies_id', 'id');
    }
}
