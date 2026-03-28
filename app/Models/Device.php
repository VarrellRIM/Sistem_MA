<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Device extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'asset_code', 'device_type', 'brand', 'model', 'serial_number',
        'processor', 'ram_size', 'storage_size', 'storage_type', 'os',
        'purchase_date', 'warranty_until', 'status', 'location',
        'assigned_to', 'notes',
    ];

    protected $casts = [
        'purchase_date'  => 'date',
        'warranty_until' => 'date',
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function maintenanceLogs()
    {
        return $this->hasMany(MaintenanceLog::class);
    }

    public function latestMaintenance()
    {
        return $this->hasOne(MaintenanceLog::class)->latestOfMany('maintenance_date');
    }
}
