<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\queue_services;
use App\Models\staff;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class StaffController extends Controller
{
    public function index()
    {
        return Inertia::render('staff/Dashboard');
    }

    public function getMonitoringData()
    {
        $waitingQueues = queue_services::where('status', 'waiting')->count();

        $activeStaff = staff::where('active', true)->count();

        $topStaff = queue_services::where('status', 'done')
            ->select('staff_id', DB::raw('COUNT(*) as total_served'))
            ->groupBy('staff_id')
            ->orderByDesc('total_served')
            ->take(3)
            ->with('staff:id,name')
            ->get()
            ->map(function ($item) {
                return [
                    'staff_name' => optional($item->staff)->name,
                    'total_served' => $item->total_served,
                ];
            });

        $averageTimes = queue_services::whereNotNull('time_called')
            ->whereNotNull('time_end')
            ->select('staff_id', DB::raw('AVG(TIMESTAMPDIFF(SECOND, time_called, time_end)) as avg_service_time'))
            ->groupBy('staff_id')
            ->with('staff:id,name')
            ->get()
            ->map(function ($item) {
                return [
                    'staff_name' => optional($item->staff)->name,
                    'avg_time_minutes' => round($item->avg_service_time / 60, 2)
                ];
            });

        return response()->json([
            'success' => true,
            'waiting_queues' => $waitingQueues,
            'active_staff' => $activeStaff,
            'top_staff' => $topStaff,
            'average_service_time' => $averageTimes,
        ]);

    }

}
