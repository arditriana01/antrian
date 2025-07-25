<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\queue_services;
use Illuminate\Support\Str;

class QueueServicesController extends Controller
{
    public function storeReservation(Request $request)
    {
        $request->validate([
            'patient_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'registration_time' => 'required|date',
        ]);

        $lastQueue = queue_services::whereData('registration_time', $request->registration_time)
                                    ->where('type_queue', 'reservation')
                                    ->orderby('id', 'desc')
                                    ->first();

        $nextNumber = $lastQueue ? (int)Str::after($lastQueue->queue_number, 'R') + 1 : 1;
        $queueNumber = 'R' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        $queueData = queue_services::create([
            'queue_number' => $queueNumber,
            'queue_type' => 'reservation',
            'patient_name' => $request->patient_name,
            'phone' => $request->phone,
            'registration_time' => now(),
            'status' => 'waiting',
            'status' => 'waiting',
            'staff_id' => null,
            'locket_counter' => null,
            'time_called' => null,
            'time_end' => null
        ]);

        return response()->json([
            'message' => 'Reservasi Berhasil',
            'data' => $queueData
        ], 201);
    }
}
