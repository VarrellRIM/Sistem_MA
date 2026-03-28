<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sparepart extends Model
{
    protected $fillable = [
        'part_code', 'part_category', 'part_name', 'brand',
        'specification', 'stock', 'min_stock', 'unit_price',
        'supplier', 'location',
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'part_id');
    }

    public function maintenanceLogs()
    {
        return $this->hasMany(MaintenanceLog::class);
    }

    public function isLowStock(): bool
    {
        return $this->stock <= $this->min_stock;
    }
}
