<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentTransacitons extends Model
{
    protected $dates = [
        'paid_at',
    ];

    protected $casts = [
        'is_paid' => 'boolean',
    ];

    protected $appends = ['is_paid'];

    public function getIsPaidAttribute()
    {
        return $this->paid_at ? true : false;
    }
}
