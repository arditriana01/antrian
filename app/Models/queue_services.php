<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class queue_services extends Model
{
    protected $fillable = [
        'queue_number',
        'type_queue',
        'patient_name',
        'phone',
        'registration_time',
        'status',
        'staff_id',
        'locket_counter',
        'time_called',
        'time_end'
    ];

    protected $casts = [
        'registration_time' => 'datetime',
        'time_called' => 'datetime',
        'time_end' => 'datetime',
    ];

    public function staff()
    {
        return $this->belongsTo(staff::class);
    }
}
