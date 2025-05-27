<?php

namespace App\Models;

use App\Enums\QuoteStatus;
use App\Enums\ServiceType;
use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    protected $casts = [
        'service' => ServiceType::class,
        'booked_at' => 'datetime',
        'duration' => 'integer',
        'price' => 'integer',
        'status' => QuoteStatus::class,
    ];
}
