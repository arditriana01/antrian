<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class staff extends Model
{
    protected $fillable = [
        'name',
        'active',
        'service_amount',
        'total_service_time'
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function queueServices()
    {
        return $this->hasMany(queue_services::class);
    }
}
