<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'total_price',
        'created_by',
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
