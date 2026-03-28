<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    public function index(Request $request)
    {
        $query = Device::query();

        if ($request->filled('type')) {
            $query->where('device_type', $request->type);
        }

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('asset_code', 'like', "%$s%")
                  ->orWhere('serial_number', 'like', "%$s%")
                  ->orWhere('assigned_to', 'like', "%$s%")
                  ->orWhere('brand', 'like', "%$s%")
                  ->orWhere('model', 'like', "%$s%");
            });
        }

        $devices = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();

        return view('devices.index', compact('devices'));
    }

    public function create()
    {
        return view('devices.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'asset_code'    => 'required|string|max:30|unique:devices',
            'device_type'   => 'required|in:pc,laptop,server',
            'brand'         => 'required|string|max:50',
            'model'         => 'required|string|max:100',
            'serial_number' => 'required|string|max:100|unique:devices',
            'processor'     => 'nullable|string|max:100',
            'ram_size'      => 'nullable|integer|min:0',
            'storage_size'  => 'nullable|integer|min:0',
            'storage_type'  => 'nullable|in:ssd,hdd,nvme',
            'os'            => 'nullable|string|max:50',
            'purchase_date' => 'nullable|date',
            'warranty_until'=> 'nullable|date',
            'status'        => 'required|in:active,maintenance,retired,in_use',
            'location'      => 'nullable|string|max:100',
            'assigned_to'   => 'nullable|string|max:100',
            'notes'         => 'nullable|string',
        ]);

        Device::create($validated);

        return redirect()->route('devices.index')->with('success', 'Perangkat berhasil ditambahkan.');
    }

    public function show(Device $device)
    {
        $device->load(['maintenanceLogs' => fn($q) => $q->orderBy('maintenance_date', 'desc')]);
        return view('devices.show', compact('device'));
    }

    public function edit(Device $device)
    {
        return view('devices.edit', compact('device'));
    }

    public function update(Request $request, Device $device)
    {
        $validated = $request->validate([
            'asset_code'    => 'required|string|max:30|unique:devices,asset_code,' . $device->id,
            'device_type'   => 'required|in:pc,laptop,server',
            'brand'         => 'required|string|max:50',
            'model'         => 'required|string|max:100',
            'serial_number' => 'required|string|max:100|unique:devices,serial_number,' . $device->id,
            'processor'     => 'nullable|string|max:100',
            'ram_size'      => 'nullable|integer|min:0',
            'storage_size'  => 'nullable|integer|min:0',
            'storage_type'  => 'nullable|in:ssd,hdd,nvme',
            'os'            => 'nullable|string|max:50',
            'purchase_date' => 'nullable|date',
            'warranty_until'=> 'nullable|date',
            'status'        => 'required|in:active,maintenance,retired,in_use',
            'location'      => 'nullable|string|max:100',
            'assigned_to'   => 'nullable|string|max:100',
            'notes'         => 'nullable|string',
        ]);

        $device->update($validated);

        return redirect()->route('devices.index')->with('success', 'Perangkat berhasil diperbarui.');
    }

    public function destroy(Device $device)
    {
        $device->delete(); // soft delete
        return redirect()->route('devices.index')->with('success', 'Perangkat berhasil dihapus.');
    }
}
