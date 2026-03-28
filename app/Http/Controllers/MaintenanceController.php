<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\MaintenanceLog;
use App\Models\Sparepart;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    public function index(Request $request)
    {
        $query = MaintenanceLog::with(['device', 'sparepart']);

        if ($request->filled('device_id')) {
            $query->where('device_id', $request->device_id);
        }

        if ($request->filled('type')) {
            $query->where('maintenance_type', $request->type);
        }

        $logs    = $query->orderBy('maintenance_date', 'desc')->paginate(20)->withQueryString();
        $devices = Device::orderBy('asset_code')->get();

        return view('maintenance.index', compact('logs', 'devices'));
    }

    public function create(Request $request)
    {
        $devices    = Device::orderBy('asset_code')->get();
        $spareparts = Sparepart::orderBy('part_name')->get();
        $selectedDevice = $request->device_id ? Device::find($request->device_id) : null;

        return view('maintenance.create', compact('devices', 'spareparts', 'selectedDevice'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'device_id'        => 'required|exists:devices,id',
            'maintenance_date' => 'required|date',
            'maintenance_type' => 'required|in:preventive,corrective,upgrade',
            'description'      => 'required|string',
            'sparepart_id'     => 'nullable|exists:spareparts,id',
            'cost'             => 'nullable|numeric|min:0',
            'technician'       => 'required|string|max:100',
            'next_maintenance' => 'nullable|date|after:maintenance_date',
        ]);

        MaintenanceLog::create($validated);

        return redirect()->route('maintenance.index')->with('success', 'Log maintenance berhasil disimpan.');
    }

    public function show(MaintenanceLog $maintenance)
    {
        $maintenance->load(['device', 'sparepart']);
        return view('maintenance.show', compact('maintenance'));
    }

    public function byDevice(Device $device)
    {
        $logs = MaintenanceLog::with('sparepart')
            ->where('device_id', $device->id)
            ->orderBy('maintenance_date', 'desc')
            ->paginate(20);

        return view('maintenance.by-device', compact('device', 'logs'));
    }
}
