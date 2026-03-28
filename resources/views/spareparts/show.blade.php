@extends('layouts.app')
@section('title', $sparepart->part_name)

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('spareparts.index') }}">Spareparts</a></li>
    <li class="breadcrumb-item active">{{ $sparepart->part_name }}</li>
@endsection

@section('content')
<div class="d-flex align-items-center justify-content-between mb-3">
    <div>
        <h5 class="fw-bold mb-0"><i class="bi bi-box-seam me-2"></i>{{ $sparepart->part_name }}</h5>
        <small class="text-muted">{{ $sparepart->part_code }}</small>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('spareparts.edit', $sparepart) }}" class="btn btn-outline-warning btn-sm">
            <i class="bi bi-pencil me-1"></i>Edit
        </a>
        <a href="{{ route('spareparts.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i>Back
        </a>
    </div>
</div>

<div class="row g-3">
    {{-- Details Card --}}
    <div class="col-lg-6">
        <div class="card shadow-sm">
            <div class="card-header">
                <i class="bi bi-info-circle me-2"></i>Details
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label small text-muted">Part Code</label>
                    <div class="fw-medium">{{ $sparepart->part_code }}</div>
                </div>
                <div class="mb-3">
                    <label class="form-label small text-muted">Category</label>
                    <div><span class="badge bg-light text-dark text-uppercase">{{ $sparepart->part_category }}</span></div>
                </div>
                <div class="mb-3">
                    <label class="form-label small text-muted">Brand</label>
                    <div class="fw-medium">{{ $sparepart->brand ?? '-' }}</div>
                </div>
                <div class="mb-3">
                    <label class="form-label small text-muted">Specification</label>
                    <div>{{ $sparepart->specification ?? '-' }}</div>
                </div>
                <div class="mb-3">
                    <label class="form-label small text-muted">Supplier</label>
                    <div class="fw-medium">{{ $sparepart->supplier ?? '-' }}</div>
                </div>
                <div class="mb-0">
                    <label class="form-label small text-muted">Storage Location</label>
                    <div class="fw-medium">{{ $sparepart->location ?? '-' }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Stock & Price Card --}}
    <div class="col-lg-6">
        <div class="card shadow-sm">
            <div class="card-header">
                <i class="bi bi-graph-up me-2"></i>Stock & Pricing
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label small text-muted">Current Stock</label>
                    <div>
                        <span class="badge {{ $sparepart->isLowStock() ? 'bg-danger' : 'bg-success' }} fs-6">
                            {{ $sparepart->stock }} unit
                        </span>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label small text-muted">Minimum Stock</label>
                    <div class="fw-medium">{{ $sparepart->min_stock }} unit</div>
                </div>
                @if($sparepart->isLowStock())
                    <div class="alert alert-warning mb-3" role="alert">
                        <i class="bi bi-exclamation-triangle me-2"></i><strong>Low Stock Alert!</strong>
                        <br><small>Current stock is below minimum threshold</small>
                    </div>
                @endif
                <div class="mb-0">
                    <label class="form-label small text-muted">Unit Price</label>
                    <div class="fs-5 fw-bold text-primary">
                        {{ $sparepart->unit_price > 0 ? 'Rp ' . number_format($sparepart->unit_price, 0, ',', '.') : 'Not Set' }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Transaction History --}}
<div class="card table-card shadow-sm mt-3">
    <div class="card-header">
        <i class="bi bi-clock-history me-2"></i>Transaction History
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>Code</th><th>Type</th><th>Quantity</th><th>Device</th>
                    <th>Purpose</th><th>Requester</th><th>Date</th>
                </tr>
            </thead>
            <tbody>
            @forelse($transactions as $trx)
                <tr>
                    <td>
                        <span class="badge bg-secondary text-sm">{{ $trx->transaction_code }}</span>
                    </td>
                    <td>
                        <span class="badge {{ $trx->transaction_type === 'in' ? 'bg-success' : 'bg-danger' }}">
                            {{ strtoupper($trx->transaction_type) }}
                        </span>
                    </td>
                    <td>
                        <span class="fw-medium">{{ $trx->quantity }}</span>
                    </td>
                    <td>
                        @if($trx->device)
                            <a href="{{ route('devices.show', $trx->device) }}" class="text-decoration-none">
                                {{ $trx->device->asset_code }}
                            </a>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td><small>{{ $trx->purpose ?? '-' }}</small></td>
                    <td><small>{{ $trx->requester ?? '-' }}</small></td>
                    <td>{{ $trx->transaction_date->format('d/m/Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">
                        <i class="bi bi-inbox me-2"></i>No transactions yet
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if($transactions->hasPages())
        <div class="card-footer bg-transparent">{{ $transactions->links() }}</div>
    @endif
</div>
@endsection
