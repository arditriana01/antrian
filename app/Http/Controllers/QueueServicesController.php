<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\queue_services;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Inertia\Inertia;

class QueueServicesController extends Controller
{
    public function indexReservation()
    {
        return Inertia::render('reservation/Index', []);
    }

    public function storeReservation(Request $request)
    {
        $request->validate([
            'patient_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20'
        ]);

        $registrationDate = Carbon::parse($request->registration_time)->toDateString();

        $lastQueue = queue_services::whereDate('registration_time', $registrationDate)
                                    ->where('type_queue', 'reservation')
                                    ->orderby('id', 'desc')
                                    ->first();

        $nextNumber = $lastQueue ? (int)Str::after($lastQueue->queue_number, 'R') + 1 : 1;
        $queueNumber = 'R' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        $queueData = queue_services::create([
            'queue_number' => $queueNumber,
            'type_queue' => 'reservation',
            'patient_name' => $request->patient_name,
            'phone' => $request->phone,
            'registration_time' => now(),
            'status' => 'waiting',            
            'staff_id' => null,
            'locket_counter' => null,
            'time_called' => null,
            'time_end' => null
        ]);

        if($queueData){
            return redirect()->route('reservation.index')->with('message', 'Berhasil');
        }
    }

    public function indexWalkin()
    {
        return Inertia::render('walkin/Index', []);
    }

    public function storeWalkin(Request $request)
    {
        $request->validate([
            'patient_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20'
        ]);

        $registrationDate = Carbon::parse($request->registration_time)->toDateString();

        $lastQueue = queue_services::whereDate('registration_time', $registrationDate)
                                    ->where('type_queue', 'walkin')
                                    ->orderby('id', 'desc')
                                    ->first();

        $nextNumber = $lastQueue ? (int)Str::after($lastQueue->queue_number, 'W') + 1 : 1;
        $queueNumber = 'W' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        $staff = Auth::guard('staff')->user();

        $queueData = queue_services::create([
            'queue_number' => $queueNumber,
            'type_queue' => 'walkin',
            'patient_name' => $request->patient_name,
            'phone' => $request->phone,
            'registration_time' => now(),
            'status' => 'waiting',            
            'staff_id' => $staff->id,
            'locket_counter' => null,
            'time_called' => null,
            'time_end' => null
        ]);

        if($queueData){
            return redirect()->route('walkin.index')->with('message', 'Berhasil');
        }
    }

    public function IndexNextQueue()
    {
        $waiting = queue_services::where('status', 'waiting')->orderBy('registration_time')->get();
        $called = queue_services::where('status', 'called')->orderBy('registration_time')->get();
        $done = queue_services::where('status', 'done')->orderBy('registration_time', 'desc')->limit(10)->get();

        return Inertia::render('staff/Call', [
            'currentQueue' => [
                'waiting' => $waiting,
                'called' => $called,
                'done' => $done,
            ],
        ]);
    }

    public function callNextQueue()
    {        
        $staff = Auth::guard('staff')->user();
     
        $currentCalled = queue_services::where('status', 'called')->orderBy('time_called')->first();
        if ($currentCalled) {
            $currentCalled->update(['status' => 'done', 'time_end' => now()]);
        }

        
        $callSequence = Session::get('call_sequence', []);
        
        if (count($callSequence) >= 3) {
            $callSequence = [];
        }
        
        $nextType = count($callSequence) < 2 ? 'reservation' : 'walkin';
        
        $nextQueue = queue_services::where('type_queue', $nextType)
                        ->where('status', 'waiting')
                        ->orderBy('registration_time')
                        ->first();
        
        if ($nextQueue) {
            $nextQueue->update([
                'status' => 'called',
                'time_called' => now(),
                'staff_id' => $staff->id ?? null,
                'locket_counter' => $staff->id,
            ]);

            $callSequence[] = $nextType;
            Session::put('call_sequence', $callSequence);

            return response()->json([
                'success' => true,
                'queue' => $nextQueue,
            ]);
        }
        
        $alternativeType = $nextType === 'reservation' ? 'walkin' : 'reservation';

        $alternativeQueue = queue_services::where('type_queue', $alternativeType)
            ->where('status', 'waiting')
            ->orderBy('registration_time')
            ->first();

        if ($alternativeQueue) {
            $alternativeQueue->update([
                'status' => 'called',
                'time_called' => now(),
                'staff_id' => $staff->id ?? null,
                'locket_counter' => 'L1',
            ]);

            $callSequence[] = $alternativeType;
            Session::put('call_sequence', $callSequence);

            return response()->json([
                'success' => true,
                'queue' => $alternativeQueue,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Tidak ada antrian yang tersedia.',
        ]);
    }

    public function finishCurrentQueue()
    {
        $currentQueue = queue_services::where('status', 'called')->first();

        if ($currentQueue) {
            $currentQueue->update([
                'status' => 'done',
                'time_end' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Antrian berhasil diselesaikan.',
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Tidak ada antrian yang sedang dipanggil.',
        ]);
    }

    public function getCurrentQueue()
    {
        $queue = queue_services::where('status', 'called')->latest('updated_at')->first();

        if (!$queue) {
            return response()->json(['success' => false, 'queue' => null]);
        }

        return response()->json([
            'success' => true,
            'queue' => [
                'queue_number' => $queue->queue_number,
                'type_queue' => $queue->type_queue,
                'staff_name' => optional($queue->staff)->name,
                'locket_counter' => $queue->locket_counter,
            ]
        ]);
    }


}
