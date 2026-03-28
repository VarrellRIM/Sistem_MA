@extends('layouts.app')
@section('title', 'Stock Out')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('transactions.index') }}">Transactions</a></li>
    <li class="breadcrumb-item active">Stock Out</li>
@endsection

@section('content')
<div class="card shadow-sm" style="max-width:620px">
    <div class="card-header" style="background:#fff5f5; border-color:#fecaca">
        <i class="bi bi-arrow-up-circle text-danger me-2"></i>
        <strong class="text-danger">Stock Out — Sparepart Usage</strong>
    </div>
    <div class="card-body">
        @if($errors->has('quantity'))
            <div class="alert alert-danger py-2">
                <i class="bi bi-exclamation-triangle me-2"></i>{{ $errors->first('quantity') }}
            </div>
        @endif

        <form method="POST" action="{{ route('transactions.storeOut') }}">
            @csrf
            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label">Sparepart <span class="text-danger">*</span></label>
                    <select name="part_id" id="part_select" class="form-select @error('part_id') is-invalid @enderror" required>
                        <option value="">-- Select Sparepart --</option>
                        @foreach($spareparts as $sp)
                            <option value="{{ $sp->id }}" data-stock="{{ $sp->stock }}" @selected(old('part_id')==$sp->id)>
                                [{{ $sp->part_code }}] {{ $sp->part_name }} — Stock: {{ $sp->stock }}
                            </option>
                        @endforeach
                    </select>
                    <div id="stock-info" class="form-text"></div>
                    @error('part_id')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Quantity <span class="text-danger">*</span></label>
                    <input type="number" name="quantity" id="qty_input" class="form-control @error('quantity') is-invalid @enderror"
                        value="{{ old('quantity', 1) }}" min="1" required>
                </div>
                <div class="col-md-8">
                    <label class="form-label">Date <span class="text-danger">*</span></label>
                    <input type="date" name="transaction_date" class="form-control @error('transaction_date') is-invalid @enderror"
                        value="{{ old('transaction_date', date('Y-m-d')) }}" required>
                </div>
                <div class="col-12">
                    <label class="form-label">Purpose / Reason <span class="text-danger">*</span></label>
                    <input type="text" name="purpose" class="form-control @error('purpose') is-invalid @enderror"
                        value="{{ old('purpose') }}" placeholder="RAM upgrade for PC IT-001..." required>
                    @error('purpose')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12">
                    <label class="form-label">Device (Optional)</label>
                    <select name="device_id" class="form-select">
                        <option value="">-- None / General --</option>
                        @foreach($devices as $dev)
                            <option value="{{ $dev->id }}" @selected(old('device_id')==$dev->id)>
                                [{{ $dev->asset_code }}] {{ $dev->brand }} {{ $dev->model }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Requested By <span class="text-danger">*</span></label>
                    <input type="text" name="requester" class="form-control @error('requester') is-invalid @enderror"
                        value="{{ old('requester') }}" required>
                    @error('requester')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Technician</label>
                    <input type="text" name="technician" class="form-control" value="{{ old('technician') }}">
                </div>
                <div class="col-12">
                    <label class="form-label">Notes</label>
                    <textarea name="notes" class="form-control" rows="2">{{ old('notes') }}</textarea>
                </div>
                <div class="col-12 d-flex gap-2">
                    <button type="submit" class="btn btn-danger"><i class="bi bi-arrow-up-circle me-1"></i>Confirm Stock Out</button>
                    <a href="{{ route('transactions.index') }}" class="btn btn-outline-secondary">Cancel</a>
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
    const opt   = this.options[this.selectedIndex];
    const stock = opt.dataset.stock;
    if (stock !== undefined && stock !== '') {
        stockInfo.innerHTML = `<span class="text-${stock > 0 ? 'success' : 'danger'}">
            Available stock: <strong>${stock}</strong></span>`;
        qtyInput.max = stock;
    } else {
        stockInfo.innerHTML = '';
        qtyInput.removeAttribute('max');
    }
});
</script>
@endpush
@endsection
