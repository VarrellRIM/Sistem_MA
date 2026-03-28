<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaintenanceLog extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'device_id', 'maintenance_date', 'maintenance_type',
        'description', 'sparepart_id', 'cost', 'technician',
        'next_maintenance', 'created_at',
    ];

    protected $casts = [
        'maintenance_date' => 'date',
        'next_maintenance' => 'date',
        'created_at'       => 'datetime',
    ];

    public function device()
    {
        return $this->belongsTo(Device::class);
    }

    public function sparepart()
    {
        return $this->belongsTo(Sparepart::class);
    }
}
