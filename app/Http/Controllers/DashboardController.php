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
        $deviceStats = Device::selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        $totalDevices   = Device::count();
        $activeDevices  = $deviceStats['active']      ?? 0;
        $maintDevices   = $deviceStats['maintenance'] ?? 0;
        $retiredDevices = $deviceStats['retired']     ?? 0;

        $lowStockItems = Sparepart::whereColumn('stock', '<=', 'min_stock')
            ->orderBy('stock')
            ->take(5)->get();

        $upcomingMaintenance = MaintenanceLog::with('device')
            ->whereBetween('next_maintenance', [Carbon::today(), Carbon::today()->addDays(7)])
            ->orderBy('next_maintenance')
            ->get();

        $oldestMaintained = Device::with('latestMaintenance')
            ->get()
            ->sortBy(fn($d) => optional($d->latestMaintenance)->maintenance_date ?? '1900-01-01')
            ->take(5);

        return view('dashboard.index', compact(
            'totalDevices', 'activeDevices', 'maintDevices', 'retiredDevices',
            'lowStockItems', 'upcomingMaintenance', 'oldestMaintained'
        ));
    }
}
