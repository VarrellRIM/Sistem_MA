@extends('layouts.app')
@section('title', 'Sparepart Keluar (Penggunaan)')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('transactions.index') }}">Transaksi</a></li>
    <li class="breadcrumb-item active">Sparepart Keluar</li>
@endsection

@section('content')
<div class="card shadow-sm" style="max-width:620px">
    <div class="card-header" style="background:#fff5f5; border-color:#fecaca">
        <i class="bi bi-arrow-up-circle text-danger me-2"></i>
        <strong class="text-danger">Form Sparepart Keluar (Penggunaan)</strong>
    </div>
    <div class="card-body">
        @if($errors->has('*'))
            <div class="alert alert-danger">
                @foreach($errors->all() as $e)
                    <div>{{ $e }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('transactions.storeOut') }}">
            @csrf
            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label">Sparepart <span class="text-danger">*</span></label>
                    <select name="part_id" id="part_select" class="form-select @error('part_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Sparepart --</option>
                        @foreach($spareparts as $sp)
                            <option value="{{ $sp->id }}" data-stock="{{ $sp->stock }}" @selected(old('part_id')==$sp->id)>
                                [{{ $sp->part_code }}] {{ $sp->part_name }} — Stok: {{ $sp->stock }}
                            </option>
                        @endforeach
                    </select>
                    <div id="stock-info" class="form-text"></div>
                    @error('part_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Jumlah <span class="text-danger">*</span></label>
                    <input type="number" name="quantity" id="qty_input" class="form-control @error('quantity') is-invalid @enderror"
                        value="{{ old('quantity', 1) }}" min="1" required>
                    @error('quantity')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-8">
                    <label class="form-label">Tanggal <span class="text-danger">*</span></label>
                    <input type="date" name="transaction_date" class="form-control @error('transaction_date') is-invalid @enderror"
                        value="{{ old('transaction_date', date('Y-m-d')) }}" required>
                    @error('transaction_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12">
                    <label class="form-label">Tujuan/Keperluan <span class="text-danger">*</span></label>
                    <input type="text" name="purpose" class="form-control @error('purpose') is-invalid @enderror"
                        value="{{ old('purpose') }}" placeholder="Upgrade RAM PC IT-001..." required>
                    @error('purpose')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12">
                    <label class="form-label">Perangkat (Opsional)</label>
                    <select name="device_id" class="form-select">
                        <option value="">-- Tidak ada / Umum --</option>
                        @foreach($devices as $dev)
                            <option value="{{ $dev->id }}" @selected(old('device_id')==$dev->id)>
                                [{{ $dev->asset_code }}] {{ $dev->brand }} {{ $dev->model }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Nama Peminta <span class="text-danger">*</span></label>
                    <input type="text" name="requester" class="form-control @error('requester') is-invalid @enderror"
                        value="{{ old('requester') }}" required>
                    @error('requester')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Teknisi</label>
                    <input type="text" name="technician" class="form-control" value="{{ old('technician') }}">
                </div>
                <div class="col-12">
                    <label class="form-label">Catatan</label>
                    <textarea name="notes" class="form-control" rows="2">{{ old('notes') }}</textarea>
                </div>
                <div class="col-12 d-flex gap-2">
                    <button type="submit" class="btn btn-danger"><i class="bi bi-arrow-up-circle me-1"></i>Catat Keluar</button>
                    <a href="{{ route('transactions.index') }}" class="btn btn-outline-secondary">Batal</a>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    const partSelect = document.getElementById('part_select');
    const stockInfo  = document.getElementById('stock-info');
    const qtyInput   = document.getElementById('qty_input');

    partSelect.addEventListener('change', function () {
        const opt = this.options[this.selectedIndex];
        const stock = opt.dataset.stock;
        if (stock !== undefined) {
            stockInfo.innerHTML = `<span class="text-${stock > 0 ? 'success' : 'danger'}">Stok tersedia: <strong>${stock}</strong></span>`;
            qtyInput.max = stock;
        } else {
            stockInfo.innerHTML = '';
            qtyInput.removeAttribute('max');
        }
    });
</script>
@endpush
@endsection
