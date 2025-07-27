<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class staff extends Authenticatable
{
    protected $fillable = [
        'name',
        'active',
        'service_amount',
        'total_service_time',
        'username',
        'password'
    ];

    protected $hidden = ['password'];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function queueServices()
    {
        return $this->hasMany(queue_services::class);
    }
}
