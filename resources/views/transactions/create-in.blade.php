@extends('layouts.app')
@section('title', 'Sparepart Masuk (Restock)')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('transactions.index') }}">Transaksi</a></li>
    <li class="breadcrumb-item active">Sparepart Masuk</li>
@endsection

@section('content')
<div class="card shadow-sm" style="max-width:580px">
    <div class="card-header" style="background:#f0fdf4; border-color:#bbf7d0">
        <i class="bi bi-arrow-down-circle text-success me-2"></i>
        <strong class="text-success">Form Sparepart Masuk (Restock)</strong>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('transactions.storeIn') }}">
            @csrf
            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label">Sparepart <span class="text-danger">*</span></label>
                    <select name="part_id" class="form-select @error('part_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Sparepart --</option>
                        @foreach($spareparts as $sp)
                            <option value="{{ $sp->id }}" @selected(old('part_id')==$sp->id)>
                                [{{ $sp->part_code }}] {{ $sp->part_name }} — Stok: {{ $sp->stock }}
                            </option>
                        @endforeach
                    </select>
                    @error('part_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Jumlah <span class="text-danger">*</span></label>
                    <input type="number" name="quantity" class="form-control @error('quantity') is-invalid @enderror"
                        value="{{ old('quantity', 1) }}" min="1" required>
                    @error('quantity')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-8">
                    <label class="form-label">Tanggal <span class="text-danger">*</span></label>
                    <input type="date" name="transaction_date" class="form-control @error('transaction_date') is-invalid @enderror"
                        value="{{ old('transaction_date', date('Y-m-d')) }}" required>
                    @error('transaction_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Supplier / Pengirim</label>
                    <input type="text" name="requester" class="form-control" value="{{ old('requester') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Teknisi / Penerima</label>
                    <input type="text" name="technician" class="form-control" value="{{ old('technician') }}">
                </div>
                <div class="col-12">
                    <label class="form-label">Catatan</label>
                    <textarea name="notes" class="form-control" rows="2">{{ old('notes') }}</textarea>
                </div>
                <div class="col-12 d-flex gap-2">
                    <button type="submit" class="btn btn-success"><i class="bi bi-arrow-down-circle me-1"></i>Catat Masuk</button>
                    <a href="{{ route('transactions.index') }}" class="btn btn-outline-secondary">Batal</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
