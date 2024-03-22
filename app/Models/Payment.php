<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
        'payed_at',
        'order_id'
    ];

    // TODO revisar después que no hay un array dates en HasAttributes trait
//    protected $dates = [
//        'payed_at'
//    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
