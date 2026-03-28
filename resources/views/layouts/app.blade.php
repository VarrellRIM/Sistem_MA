<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') — Sistem MA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --sidebar-bg: #0f172a;
            --sidebar-w: 240px;
            --accent: #3b82f6;
        }
        * { font-family: 'Inter', sans-serif; }
        body { background: #f1f5f9; margin: 0; }

        /* Sidebar */
        .sidebar {
            position: fixed; top: 0; left: 0; bottom: 0;
            width: var(--sidebar-w);
            background: var(--sidebar-bg);
            display: flex; flex-direction: column;
            z-index: 1000; overflow-y: auto;
        }
        .sidebar-brand {
            padding: 1.25rem 1rem;
            border-bottom: 1px solid #1e293b;
        }
        .sidebar-brand .brand-name { color: #fff; font-weight: 700; font-size: .95rem; }
        .sidebar-brand .brand-sub  { color: #64748b; font-size: .72rem; }
        .sidebar-nav { padding: .5rem 0; flex: 1; }
        .nav-label { color: #475569; font-size: .65rem; font-weight: 600; text-transform: uppercase; letter-spacing: .08em; padding: .75rem 1rem .25rem; }
        .nav-link-item {
            display: flex; align-items: center; gap: .65rem;
            padding: .55rem 1rem; margin: .1rem .5rem;
            color: #94a3b8; font-size: .83rem; font-weight: 500;
            border-radius: 6px; text-decoration: none; transition: all .15s;
        }
        .nav-link-item:hover, .nav-link-item.active {
            background: #1e293b; color: #fff;
        }
        .nav-link-item.active { color: var(--accent); }
        .nav-link-item i { font-size: 1rem; width: 1.1rem; }

        /* Main content */
        .main-wrapper { margin-left: var(--sidebar-w); display: flex; flex-direction: column; min-height: 100vh; }
        .topbar {
            background: #fff; border-bottom: 1px solid #e2e8f0;
            padding: .75rem 1.5rem; display: flex; align-items: center;
            justify-content: space-between; position: sticky; top: 0; z-index: 100;
        }
        .topbar-title { font-size: .9rem; font-weight: 600; color: #1e293b; }
        .page-content { padding: 1.5rem; flex: 1; }

        /* Cards */
        .card { border: 1px solid #e2e8f0; border-radius: 10px; }
        .card-header { background: #f8fafc; border-bottom: 1px solid #e2e8f0; font-weight: 600; font-size: .88rem; padding: .75rem 1rem; }
        .table-card .table thead th { background: #f8fafc; font-size: .78rem; font-weight: 600; text-transform: uppercase; letter-spacing: .04em; color: #64748b; border-bottom: 2px solid #e2e8f0; }
        .table td { vertical-align: middle; font-size: .85rem; }

        /* Status / type badges */
        .badge-active    { background: #dcfce7; color: #166534; }
        .badge-in_use    { background: #dbeafe; color: #1e40af; }
        .badge-maintenance { background: #fef9c3; color: #854d0e; }
        .badge-retired   { background: #f1f5f9; color: #475569; }

        /* Low stock highlight */
        .low-stock-row { background: #fff5f5 !important; }
        .low-stock-row:hover td { background: transparent !important; }

        /* Stat cards */
        .stat-card { border-radius: 12px; padding: 1.25rem; border: none; }
        .stat-num  { font-size: 2rem; font-weight: 700; line-height: 1; }
        .stat-lbl  { font-size: .78rem; font-weight: 500; opacity: .75; margin-top: .3rem; }
    </style>
</head>
<body>

{{-- Sidebar --}}
<nav class="sidebar">
    <div class="sidebar-brand">
        <div class="brand-name"><i class="bi bi-hdd-network me-2"></i>Sistem MA</div>
        <div class="brand-sub">IT Asset Management</div>
    </div>
    <div class="sidebar-nav">
        <div class="nav-label">Main</div>
        <a href="{{ route('dashboard') }}"
           class="nav-link-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>

        <div class="nav-label">Assets</div>
        <a href="{{ route('devices.index') }}"
           class="nav-link-item {{ request()->routeIs('devices.*') ? 'active' : '' }}">
            <i class="bi bi-pc-display"></i> Devices
        </a>
        <a href="{{ route('spareparts.index') }}"
           class="nav-link-item {{ request()->routeIs('spareparts.*') ? 'active' : '' }}">
            <i class="bi bi-boxes"></i> Spareparts
        </a>

        @if(auth()->check() && in_array(auth()->user()->role, ['technician', 'admin']))
            <div class="nav-label">Operations</div>
            <a href="{{ route('transactions.index') }}"
               class="nav-link-item {{ request()->routeIs('transactions.*') ? 'active' : '' }}">
                <i class="bi bi-arrow-left-right"></i> Transactions
            </a>
            <a href="{{ route('maintenance.index') }}"
               class="nav-link-item {{ request()->routeIs('maintenance.*') ? 'active' : '' }}">
                <i class="bi bi-tools"></i> Maintenance
            </a>
        @endif
    </div>
</nav>

{{-- Main --}}
<div class="main-wrapper">
    <div class="topbar">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 small">
                    @yield('breadcrumb')
                </ol>
            </nav>
        </div>
        <div class="d-flex align-items-center gap-3">
            <span class="text-muted small">{{ now()->format('l, d F Y') }}</span>
            
            @auth
                <div class="dropdown">
                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle me-1"></i>{{ auth()->user()->name }}
                        <span class="badge bg-primary ms-2 text-uppercase">{{ auth()->user()->role }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><span class="dropdown-item-text small text-muted">{{ auth()->user()->email }}</span></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="dropdown-item" onclick="return confirm('Logout?')">
                                    <i class="bi bi-box-arrow-right me-2"></i>Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            @endauth
        </div>
    </div>

    <div class="page-content">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show py-2 mb-3" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show py-2 mb-3" role="alert">
                <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
