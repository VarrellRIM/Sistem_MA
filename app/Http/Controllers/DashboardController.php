<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Sparepart;
use App\Models\MaintenanceLog;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Status breakdown
        $deviceStats = Device::selectRaw("status, COUNT(*) as total")
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        $statusList = ['active', 'maintenance', 'retired', 'in_use'];
        foreach ($statusList as $s) {
            $deviceStats[$s] = $deviceStats[$s] ?? 0;
        }
        $deviceStats['total'] = array_sum($deviceStats);

        // Sparepart stats
        $totalSpareparts  = Sparepart::count();
        $lowStockItems    = Sparepart::whereColumn('stock', '<=', 'min_stock')->orderBy('stock')->take(5)->get();

        // 5 perangkat dengan maintenance terakhir terlama (atau belum pernah)
        $oldestMaintained = Device::with('latestMaintenance')
            ->get()
            ->sortBy(fn($d) => optional($d->latestMaintenance)->maintenance_date ?? '1900-01-01')
            ->take(5)
            ->values();

        // Perangkat butuh maintenance dalam 7 hari ke depan
        $upcomingMaintenance = MaintenanceLog::with('device')
            ->whereNotNull('next_maintenance')
            ->whereBetween('next_maintenance', [Carbon::today(), Carbon::today()->addDays(7)])
            ->orderBy('next_maintenance')
            ->get();

        return view('dashboard.index', compact(
            'deviceStats', 'totalSpareparts', 'lowStockItems',
            'oldestMaintained', 'upcomingMaintenance'
        ));
    }
}
