<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'phone',
        'country',
        'zip',
        'city',
        'address',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
