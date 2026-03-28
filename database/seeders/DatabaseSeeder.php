<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Devices ──────────────────────────────────────────────
        $devices = [
            ['asset_code' => 'IT-00001', 'device_type' => 'pc',     'brand' => 'Dell',   'model' => 'OptiPlex 3080',     'serial_number' => 'SN-DELL-001', 'processor' => 'Intel Core i5-10400', 'ram_size' => 16, 'storage_size' => 512, 'storage_type' => 'ssd',  'os' => 'Windows 11 Pro',  'status' => 'active',      'location' => 'Ruang IT',     'assigned_to' => 'Budi Santoso'],
            ['asset_code' => 'IT-00002', 'device_type' => 'laptop',  'brand' => 'HP',     'model' => 'EliteBook 840 G8',  'serial_number' => 'SN-HP-002',   'processor' => 'Intel Core i7-1165G7','ram_size' => 16,'storage_size' => 512, 'storage_type' => 'nvme', 'os' => 'Windows 11 Pro',  'status' => 'in_use',      'location' => 'Marketing',    'assigned_to' => 'Siti Rahayu'],
            ['asset_code' => 'IT-00003', 'device_type' => 'server',  'brand' => 'Dell',   'model' => 'PowerEdge R740',    'serial_number' => 'SN-DELL-003', 'processor' => 'Intel Xeon Silver 4210','ram_size' => 64,'storage_size' => 2000,'storage_type' => 'ssd', 'os' => 'Ubuntu 22.04 LTS','status' => 'active',      'location' => 'Server Room',  'assigned_to' => null],
            ['asset_code' => 'IT-00004', 'device_type' => 'pc',     'brand' => 'Lenovo', 'model' => 'ThinkCentre M90q',  'serial_number' => 'SN-LEN-004',  'processor' => 'Intel Core i5-10500', 'ram_size' => 8,  'storage_size' => 256, 'storage_type' => 'ssd',  'os' => 'Windows 10 Pro',  'status' => 'maintenance', 'location' => 'HR Dept',      'assigned_to' => 'Ahmad Fauzi'],
            ['asset_code' => 'IT-00005', 'device_type' => 'laptop',  'brand' => 'Lenovo', 'model' => 'ThinkPad X1 Carbon','serial_number' => 'SN-LEN-005',  'processor' => 'Intel Core i7-10510U','ram_size' => 16,'storage_size' => 512, 'storage_type' => 'nvme', 'os' => 'Windows 11 Pro',  'status' => 'active',      'location' => 'Direksi',      'assigned_to' => 'Direktur Utama'],
            ['asset_code' => 'IT-00006', 'device_type' => 'pc',     'brand' => 'Asus',   'model' => 'ExpertCenter D500',  'serial_number' => 'SN-ASUS-006', 'processor' => 'Intel Core i3-10100', 'ram_size' => 4,  'storage_size' => 500, 'storage_type' => 'hdd',  'os' => 'Windows 10 Home', 'status' => 'retired',     'location' => 'Gudang',       'assigned_to' => null],
        ];

        foreach ($devices as $d) {
            DB::table('devices')->insert(array_merge($d, [
                'purchase_date'  => Carbon::now()->subYears(rand(1, 4))->format('Y-m-d'),
                'warranty_until' => Carbon::now()->addYears(rand(1, 2))->format('Y-m-d'),
                'created_at'     => now(),
                'updated_at'     => now(),
            ]));
        }

        // ── Spareparts ────────────────────────────────────────────
        $spareparts = [
            ['part_code' => 'SPR-00001', 'part_category' => 'ram',         'part_name' => 'RAM DDR4 8GB',        'brand' => 'Kingston',   'specification' => '8GB DDR4 3200MHz',      'stock' => 10, 'min_stock' => 5,  'unit_price' => 350000,  'supplier' => 'Bhinneka',      'location' => 'Rak A-1'],
            ['part_code' => 'SPR-00002', 'part_category' => 'ssd',         'part_name' => 'SSD SATA 256GB',      'brand' => 'WD',         'specification' => '256GB SATA 2.5"',       'stock' => 6,  'min_stock' => 3,  'unit_price' => 450000,  'supplier' => 'TokoPC',        'location' => 'Rak A-2'],
            ['part_code' => 'SPR-00003', 'part_category' => 'hdd',         'part_name' => 'HDD 1TB',             'brand' => 'Seagate',    'specification' => '1TB 7200RPM SATA',      'stock' => 2,  'min_stock' => 3,  'unit_price' => 650000,  'supplier' => 'Bhinneka',      'location' => 'Rak A-3'],
            ['part_code' => 'SPR-00004', 'part_category' => 'keyboard',    'part_name' => 'Keyboard USB',        'brand' => 'Logitech',   'specification' => 'Wired USB Full Size',   'stock' => 8,  'min_stock' => 5,  'unit_price' => 120000,  'supplier' => 'iBox',          'location' => 'Rak B-1'],
            ['part_code' => 'SPR-00005', 'part_category' => 'mouse',       'part_name' => 'Mouse USB Optical',   'brand' => 'Logitech',   'specification' => 'Wired USB Optical',     'stock' => 3,  'min_stock' => 5,  'unit_price' => 85000,   'supplier' => 'iBox',          'location' => 'Rak B-2'],
            ['part_code' => 'SPR-00006', 'part_category' => 'psu',         'part_name' => 'PSU 500W',            'brand' => 'Corsair',    'specification' => '500W 80+ Bronze',       'stock' => 3,  'min_stock' => 2,  'unit_price' => 750000,  'supplier' => 'Bhinneka',      'location' => 'Rak C-1'],
            ['part_code' => 'SPR-00007', 'part_category' => 'cable',       'part_name' => 'Kabel LAN Cat6',      'brand' => 'Belden',     'specification' => 'UTP Cat6 1 meter',      'stock' => 20, 'min_stock' => 10, 'unit_price' => 15000,   'supplier' => 'Tokopedia',     'location' => 'Rak D-1'],
            ['part_code' => 'SPR-00008', 'part_category' => 'ram',         'part_name' => 'RAM DDR4 16GB',       'brand' => 'Corsair',    'specification' => '16GB DDR4 3600MHz',     'stock' => 1,  'min_stock' => 2,  'unit_price' => 700000,  'supplier' => 'Bhinneka',      'location' => 'Rak A-1'],
        ];

        foreach ($spareparts as $sp) {
            DB::table('spareparts')->insert(array_merge($sp, ['created_at' => now(), 'updated_at' => now()]));
        }

        // ── Transactions ──────────────────────────────────────────
        $deviceIds    = DB::table('devices')->pluck('id')->toArray();
        $sparepartIds = DB::table('spareparts')->pluck('id')->toArray();

        $transactions = [
            ['transaction_code' => 'TRX-20260301-0001', 'part_id' => $sparepartIds[0], 'device_id' => null,            'transaction_type' => 'in',  'quantity' => 15, 'purpose' => null,              'requester' => 'Bhinneka',      'technician' => 'Eko',        'transaction_date' => '2026-03-01'],
            ['transaction_code' => 'TRX-20260310-0001', 'part_id' => $sparepartIds[0], 'device_id' => $deviceIds[0],   'transaction_type' => 'out', 'quantity' => 2,  'purpose' => 'Upgrade RAM PC',  'requester' => 'Budi Santoso',  'technician' => 'Eko',        'transaction_date' => '2026-03-10'],
            ['transaction_code' => 'TRX-20260310-0002', 'part_id' => $sparepartIds[1], 'device_id' => $deviceIds[3],   'transaction_type' => 'out', 'quantity' => 1,  'purpose' => 'Ganti SSD',       'requester' => 'Ahmad Fauzi',   'technician' => 'Eko',        'transaction_date' => '2026-03-10'],
            ['transaction_code' => 'TRX-20260315-0001', 'part_id' => $sparepartIds[3], 'device_id' => null,            'transaction_type' => 'in',  'quantity' => 10, 'purpose' => null,              'requester' => 'iBox',          'technician' => 'Eko',        'transaction_date' => '2026-03-15'],
            ['transaction_code' => 'TRX-20260320-0001', 'part_id' => $sparepartIds[4], 'device_id' => $deviceIds[1],   'transaction_type' => 'out', 'quantity' => 1,  'purpose' => 'Ganti mouse rusak','requester' => 'Siti Rahayu',  'technician' => 'Eko',        'transaction_date' => '2026-03-20'],
        ];

        foreach ($transactions as $trx) {
            DB::table('transactions')->insert(array_merge($trx, ['notes' => null, 'created_at' => now()]));
        }

        // ── Maintenance Logs ──────────────────────────────────────
        $maintenanceLogs = [
            ['device_id' => $deviceIds[0], 'maintenance_date' => '2026-01-15', 'maintenance_type' => 'preventive', 'description' => 'Pembersihan debu, cek komponen', 'sparepart_id' => null, 'cost' => 0,      'technician' => 'Eko Prasetyo', 'next_maintenance' => '2026-04-15'],
            ['device_id' => $deviceIds[1], 'maintenance_date' => '2026-02-10', 'maintenance_type' => 'corrective',  'description' => 'Ganti baterai laptop',           'sparepart_id' => null, 'cost' => 350000, 'technician' => 'Eko Prasetyo', 'next_maintenance' => '2026-08-10'],
            ['device_id' => $deviceIds[3], 'maintenance_date' => '2026-03-10', 'maintenance_type' => 'upgrade',     'description' => 'Upgrade SSD 256GB',              'sparepart_id' => $sparepartIds[1], 'cost' => 450000, 'technician' => 'Eko Prasetyo', 'next_maintenance' => '2026-09-10'],
            ['device_id' => $deviceIds[2], 'maintenance_date' => '2025-12-01', 'maintenance_type' => 'preventive', 'description' => 'Cek server, update firmware',     'sparepart_id' => null, 'cost' => 0,      'technician' => 'Admin IT',    'next_maintenance' => Carbon::now()->addDays(5)->format('Y-m-d')],
            ['device_id' => $deviceIds[4], 'maintenance_date' => '2025-11-20', 'maintenance_type' => 'preventive', 'description' => 'Pembersihan dan update OS',       'sparepart_id' => null, 'cost' => 0,      'technician' => 'Admin IT',    'next_maintenance' => Carbon::now()->addDays(2)->format('Y-m-d')],
        ];

        foreach ($maintenanceLogs as $log) {
            DB::table('maintenance_logs')->insert(array_merge($log, ['created_at' => now()]));
        }
    }
}
