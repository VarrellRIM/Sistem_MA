@extends('layouts.app')
@section('title', 'Transaction History')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Transactions</li>
@endsection

@section('content')
<div class="d-flex align-items-center justify-content-between mb-3">
    <h5 class="fw-bold mb-0"><i class="bi bi-arrow-left-right me-2"></i>Transaction History</h5>
    <div class="d-flex gap-2">
        <a href="{{ route('transactions.createIn') }}" class="btn btn-success btn-sm">
            <i class="bi bi-arrow-down-circle me-1"></i>Stock In
        </a>
        <a href="{{ route('transactions.createOut') }}" class="btn btn-danger btn-sm">
            <i class="bi bi-arrow-up-circle me-1"></i>Stock Out
        </a>
    </div>
</div>

<div class="card shadow-sm mb-3">
    <div class="card-body py-2">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-6 col-md-2">
                <select name="type" class="form-select form-select-sm">
                    <option value="">All Types</option>
                    <option value="in"  @selected(request('type')=='in')>Stock In</option>
                    <option value="out" @selected(request('type')=='out')>Stock Out</option>
                </select>
            </div>
            <div class="col-6 col-md-3">
                <select name="part_id" class="form-select form-select-sm">
                    <option value="">All Spareparts</option>
                    @foreach($spareparts as $sp)
                        <option value="{{ $sp->id }}" @selected(request('part_id')==$sp->id)>{{ $sp->part_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-6 col-md-2">
                <input type="date" name="date_from" class="form-control form-control-sm" value="{{ request('date_from') }}">
            </div>
            <div class="col-6 col-md-2">
                <input type="date" name="date_to" class="form-control form-control-sm" value="{{ request('date_to') }}">
            </div>
            <div class="col-auto">
                <button class="btn btn-sm btn-primary"><i class="bi bi-search"></i></button>
            </div>
            @if(request()->hasAny(['type','part_id','date_from','date_to']))
                <div class="col-auto"><a href="{{ route('transactions.index') }}" class="btn btn-sm btn-outline-secondary">Reset</a></div>
            @endif
        </form>
    </div>
</div>

<div class="card table-card shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead><tr>
                <th>Code</th><th>Type</th><th>Sparepart</th><th>Qty</th>
                <th>Device</th><th>Purpose</th><th>Requested By</th><th>Technician</th><th>Date</th>
            </tr></thead>
            <tbody>
            @forelse($transactions as $trx)
                <tr>
                    <td><small class="text-muted">{{ $trx->transaction_code }}</small></td>
                    <td>
                        @if($trx->transaction_type == 'in')
                            <span class="badge bg-success"><i class="bi bi-arrow-down"></i> In</span>
                        @else
                            <span class="badge bg-danger"><i class="bi bi-arrow-up"></i> Out</span>
                        @endif
                    </td>
                    <td>
                        <span class="fw-medium">{{ $trx->sparepart->part_name ?? '-' }}</span>
                        <small class="d-block text-muted">{{ $trx->sparepart->part_code ?? '' }}</small>
                    </td>
                    <td><strong>{{ $trx->quantity }}</strong></td>
                    <td><small>{{ $trx->device?->asset_code ?? '-' }}</small></td>
                    <td><small>{{ $trx->purpose ?? '-' }}</small></td>
                    <td><small>{{ $trx->requester ?? '-' }}</small></td>
                    <td><small>{{ $trx->technician ?? '-' }}</small></td>
                    <td><small>{{ $trx->transaction_date->format('d/m/Y') }}</small></td>
                </tr>
            @empty
                <tr><td colspan="9" class="text-center text-muted py-4">No transactions found.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if($transactions->hasPages())
        <div class="card-footer bg-transparent">{{ $transactions->links() }}</div>
    @endif
</div>
@endsection
