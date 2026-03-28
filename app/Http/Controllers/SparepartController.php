<?php

namespace App\Http\Controllers;

use App\Models\Sparepart;
use Illuminate\Http\Request;

class SparepartController extends Controller
{
    public function index(Request $request)
    {
        $query = Sparepart::query();

        if ($request->filled('category')) {
            $query->where('part_category', $request->category);
        }

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('part_code', 'like', "%$s%")
                  ->orWhere('part_name', 'like', "%$s%")
                  ->orWhere('brand', 'like', "%$s%");
            });
        }

        $spareparts = $query->orderBy('part_name')->paginate(15)->withQueryString();

        return view('spareparts.index', compact('spareparts'));
    }

    public function create()
    {
        return view('spareparts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'part_code'     => 'required|string|max:30|unique:spareparts',
            'part_category' => 'required|in:ram,ssd,hdd,psu,motherboard,keyboard,mouse,cable,other',
            'part_name'     => 'required|string|max:100',
            'brand'         => 'nullable|string|max:50',
            'specification' => 'nullable|string|max:200',
            'stock'         => 'required|integer|min:0',
            'min_stock'     => 'required|integer|min:0',
            'unit_price'    => 'nullable|numeric|min:0',
            'supplier'      => 'nullable|string|max:100',
            'location'      => 'nullable|string|max:50',
        ]);

        Sparepart::create($validated);

        return redirect()->route('spareparts.index')
            ->with('success', 'Sparepart added successfully.');
    }

    public function show(Sparepart $sparepart)
    {
        $transactions = $sparepart->transactions()->latest()->paginate(10);
        return view('spareparts.show', compact('sparepart', 'transactions'));
    }

    public function edit(Sparepart $sparepart)
    {
        return view('spareparts.edit', compact('sparepart'));
    }

    public function update(Request $request, Sparepart $sparepart)
    {
        $validated = $request->validate([
            'part_code'     => 'required|string|max:30|unique:spareparts,part_code,' . $sparepart->id,
            'part_category' => 'required|in:ram,ssd,hdd,psu,motherboard,keyboard,mouse,cable,other',
            'part_name'     => 'required|string|max:100',
            'brand'         => 'nullable|string|max:50',
            'specification' => 'nullable|string|max:200',
            'stock'         => 'required|integer|min:0',
            'min_stock'     => 'required|integer|min:0',
            'unit_price'    => 'nullable|numeric|min:0',
            'supplier'      => 'nullable|string|max:100',
            'location'      => 'nullable|string|max:50',
        ]);

        $sparepart->update($validated);

        return redirect()->route('spareparts.index')
            ->with('success', 'Sparepart updated successfully.');
    }

    public function destroy(Sparepart $sparepart)
    {
        $sparepart->delete();
        return redirect()->route('spareparts.index')
            ->with('success', 'Sparepart deleted successfully.');
    }
}
