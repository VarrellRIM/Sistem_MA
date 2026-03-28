<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Sparepart;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::with(['sparepart', 'device']);

        if ($request->filled('type')) {
            $query->where('transaction_type', $request->type);
        }

        if ($request->filled('part_id')) {
            $query->where('part_id', $request->part_id);
        }

        if ($request->filled('date_from')) {
            $query->where('transaction_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('transaction_date', '<=', $request->date_to);
        }

        $transactions = $query->orderBy('created_at', 'desc')->paginate(20)->withQueryString();
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
            'requester'        => 'nullable|string|max:100',
            'technician'       => 'nullable|string|max:100',
            'transaction_date' => 'required|date',
            'notes'            => 'nullable|string',
        ]);

        DB::transaction(function () use ($validated) {
            $sparepart = Sparepart::lockForUpdate()->findOrFail($validated['part_id']);
            $sparepart->increment('stock', $validated['quantity']);

            Transaction::create([
                ...$validated,
                'transaction_type' => 'in',
                'transaction_code' => $this->generateCode(),
            ]);
        });

        return redirect()->route('transactions.index')->with('success', 'Sparepart masuk berhasil dicatat. Stok bertambah.');
    }

    public function createOut()
    {
        $spareparts = Sparepart::where('stock', '>', 0)->orderBy('part_name')->get();
        $devices    = Device::orderBy('asset_code')->get();
        return view('transactions.create-out', compact('spareparts', 'devices'));
    }

    public function storeOut(Request $request)
    {
        $validated = $request->validate([
            'part_id'          => 'required|exists:spareparts,id',
            'device_id'        => 'nullable|exists:devices,id',
            'quantity'         => 'required|integer|min:1',
            'purpose'          => 'required|string|max:200',
            'requester'        => 'required|string|max:100',
            'technician'       => 'nullable|string|max:100',
            'transaction_date' => 'required|date',
            'notes'            => 'nullable|string',
        ]);

        try {
            DB::transaction(function () use ($validated) {
                $sparepart = Sparepart::lockForUpdate()->findOrFail($validated['part_id']);

                if ($sparepart->stock < $validated['quantity']) {
                    throw new \Exception("Stok tidak mencukupi. Stok saat ini: {$sparepart->stock}");
                }

                $sparepart->decrement('stock', $validated['quantity']);

                Transaction::create([
                    ...$validated,
                    'transaction_type' => 'out',
                    'transaction_code' => $this->generateCode(),
                ]);
            });
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['quantity' => $e->getMessage()]);
        }

        return redirect()->route('transactions.index')->with('success', 'Sparepart keluar berhasil dicatat. Stok berkurang.');
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
