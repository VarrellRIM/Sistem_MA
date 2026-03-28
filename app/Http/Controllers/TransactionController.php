<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Sparepart;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::with(['sparepart', 'device'])->orderByDesc('created_at');

        if ($request->filled('type')) {
            $query->where('transaction_type', $request->type);
        }
        if ($request->filled('part_id')) {
            $query->where('part_id', $request->part_id);
        }
        if ($request->filled('date_from')) {
            $query->whereDate('transaction_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('transaction_date', '<=', $request->date_to);
        }

        $transactions = $query->paginate(15)->withQueryString();
        $spareparts   = Sparepart::orderBy('part_name')->get();

        return view('transactions.index', compact('transactions', 'spareparts'));
    }

    public function createIn()
    {
        $spareparts = Sparepart::orderBy('part_name')->get();
        return view('transactions.create-in', compact('spareparts'));
    }

    public function storeIn(Request $request)
    {
        $validated = $request->validate([
            'part_id'          => 'required|exists:spareparts,id',
            'quantity'         => 'required|integer|min:1',
            'transaction_date' => 'required|date',
            'requester'        => 'nullable|string|max:100',
            'technician'       => 'nullable|string|max:100',
            'notes'            => 'nullable|string',
        ]);

        DB::transaction(function () use ($validated) {
            // Use pessimistic locking to prevent race conditions
            $sparepart = Sparepart::lockForUpdate()->findOrFail($validated['part_id']);
            $oldStock = $sparepart->stock;
            
            $sparepart->increment('stock', $validated['quantity']);
            
            Transaction::create([
                ...$validated,
                'transaction_type' => 'in',
                'transaction_code' => $this->generateCode(),
                'created_at'       => now(),
            ]);
        });

        return redirect()->route('transactions.index')
            ->with('success', 'Stock-in recorded. Sparepart stock increased.');
    }

    public function createOut()
    {
        $spareparts = Sparepart::where('stock', '>', 0)->orderBy('part_name')->get();
        $devices    = Device::where('status', '!=', 'retired')->orderBy('asset_code')->get();
        return view('transactions.create-out', compact('spareparts', 'devices'));
    }

    public function storeOut(Request $request)
    {
        $validated = $request->validate([
            'part_id'          => 'required|exists:spareparts,id',
            'quantity'         => 'required|integer|min:1',
            'transaction_date' => 'required|date',
            'purpose'          => 'required|string|max:200',
            'device_id'        => 'nullable|exists:devices,id',
            'requester'        => 'required|string|max:100',
            'technician'       => 'nullable|string|max:100',
            'notes'            => 'nullable|string',
        ]);

        try {
            DB::transaction(function () use ($validated) {
                // Use pessimistic locking to prevent concurrent modifications
                $sparepart = Sparepart::lockForUpdate()->findOrFail($validated['part_id']);

                // Validate sufficient stock after lock acquired
                if ($sparepart->stock < $validated['quantity']) {
                    throw new \Exception(
                        "Insufficient stock. Required: {$validated['quantity']}, " .
                        "Available: {$sparepart->stock}"
                    );
                }

                $oldStock = $sparepart->stock;
                $sparepart->decrement('stock', $validated['quantity']);

                // Record transaction
                Transaction::create([
                    ...$validated,
                    'transaction_type' => 'out',
                    'transaction_code' => $this->generateCode(),
                    'created_at'       => now(),
                ]);
            });
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['quantity' => $e->getMessage()]);
        }

        return redirect()->route('transactions.index')
            ->with('success', 'Stock-out recorded. Sparepart stock decreased.');
    }

    private function generateCode(): string
    {
        $date = Carbon::now()->format('Ymd');
        $last = Transaction::where('transaction_code', 'like', "TRX-{$date}-%")
            ->orderBy('transaction_code', 'desc')
            ->value('transaction_code');
        $seq = $last ? ((int) substr($last, -4)) + 1 : 1;
        return sprintf('TRX-%s-%04d', $date, $seq);
    }
}
