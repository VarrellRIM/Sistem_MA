<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'transaction_code', 'part_id', 'device_id', 'transaction_type',
        'quantity', 'purpose', 'requester', 'technician',
        'transaction_date', 'notes',
    ];

    protected $casts = [
        'transaction_date' => 'date',
        'created_at'       => 'datetime',
    ];

    public function sparepart()
    {
        return $this->belongsTo(Sparepart::class, 'part_id');
    }

    public function device()
    {
        return $this->belongsTo(Device::class);
    }
}
