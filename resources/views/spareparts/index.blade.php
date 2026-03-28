@extends('layouts.app')
@section('title', 'Daftar Sparepart')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Sparepart</li>
@endsection

@section('content')
<div class="d-flex align-items-center justify-content-between mb-3">
    <h5 class="fw-bold mb-0"><i class="bi bi-boxes me-2"></i>Daftar Sparepart</h5>
    <a href="{{ route('spareparts.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg me-1"></i>Tambah Sparepart
    </a>
</div>

{{-- Filter --}}
<div class="card shadow-sm mb-3">
    <div class="card-body py-2">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-12 col-md-4">
                <input type="text" name="search" class="form-control form-control-sm"
                    placeholder="Cari kode, nama, brand..." value="{{ request('search') }}">
            </div>
            <div class="col-6 col-md-3">
                <select name="category" class="form-select form-select-sm">
                    <option value="">Semua Kategori</option>
                    @foreach(['ram','ssd','hdd','psu','motherboard','keyboard','mouse','cable','other'] as $cat)
                        <option value="{{ $cat }}" @selected(request('category')==$cat)>{{ strtoupper($cat) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-6 col-md-auto">
                <button class="btn btn-sm btn-primary w-100"><i class="bi bi-search"></i> Cari</button>
            </div>
            @if(request()->hasAny(['search','category']))
                <div class="col-auto"><a href="{{ route('spareparts.index') }}" class="btn btn-sm btn-outline-secondary">Reset</a></div>
            @endif
        </form>
    </div>
</div>

<div class="card table-card shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead><tr>
                <th>Part Code</th><th>Kategori</th><th>Nama</th><th>Spesifikasi</th>
                <th>Stok</th><th>Min</th><th>Harga</th><th>Supplier</th><th class="text-center">Aksi</th>
            </tr></thead>
            <tbody>
            @forelse($spareparts as $sp)
                <tr class="{{ $sp->isLowStock() ? 'low-stock-row' : '' }}">
                    <td><span class="badge bg-secondary">{{ $sp->part_code }}</span></td>
                    <td><span class="badge bg-light text-dark text-uppercase">{{ $sp->part_category }}</span></td>
                    <td>
                        <span class="fw-medium">{{ $sp->part_name }}</span>
                        @if($sp->brand)<small class="d-block text-muted">{{ $sp->brand }}</small>@endif
                    </td>
                    <td><small>{{ $sp->specification ?? '-' }}</small></td>
                    <td>
                        <span class="badge {{ $sp->isLowStock() ? 'bg-danger' : 'bg-success' }}">
                            {{ $sp->stock }}
                        </span>
                    </td>
                    <td><small>{{ $sp->min_stock }}</small></td>
                    <td><small>{{ $sp->unit_price > 0 ? 'Rp ' . number_format($sp->unit_price, 0, ',', '.') : '-' }}</small></td>
                    <td><small>{{ $sp->supplier ?? '-' }}</small></td>
                    <td class="text-center">
                        <a href="{{ route('spareparts.edit', $sp) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form method="POST" action="{{ route('spareparts.destroy', $sp) }}" class="d-inline"
                              onsubmit="return confirm('Hapus sparepart {{ $sp->part_name }}?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger" title="Hapus"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="9" class="text-center text-muted py-4">Tidak ada sparepart ditemukan.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if($spareparts->hasPages())
        <div class="card-footer bg-transparent">{{ $spareparts->links() }}</div>
    @endif
</div>
@endsection
