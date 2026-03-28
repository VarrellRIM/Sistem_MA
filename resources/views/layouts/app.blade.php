<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — Sistem MA</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --sidebar-width: 260px;
            --primary: #4f46e5;
            --primary-dark: #3730a3;
            --sidebar-bg: #0f172a;
            --sidebar-text: #cbd5e1;
            --sidebar-active: #4f46e5;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #f1f5f9;
            color: #1e293b;
        }

        /* ── Sidebar ── */
        #sidebar {
            position: fixed;
            top: 0; left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--sidebar-bg);
            z-index: 1000;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
        }

        .sidebar-brand {
            padding: 1.5rem 1.25rem 1rem;
            border-bottom: 1px solid rgba(255,255,255,.08);
        }

        .sidebar-brand h5 {
            color: #fff;
            font-weight: 700;
            font-size: .95rem;
            margin: 0;
        }

        .sidebar-brand p {
            color: #64748b;
            font-size: .72rem;
            margin: 0;
        }

        .sidebar-nav { padding: .75rem 0; flex: 1; }

        .nav-section {
            padding: .5rem 1.25rem .25rem;
            font-size: .65rem;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: #475569;
            font-weight: 600;
        }

        .sidebar-nav .nav-link {
            color: var(--sidebar-text);
            padding: .55rem 1.25rem;
            border-radius: 0;
            font-size: .84rem;
            display: flex;
            align-items: center;
            gap: .65rem;
            transition: all .15s;
        }

        .sidebar-nav .nav-link:hover {
            background: rgba(255,255,255,.06);
            color: #fff;
        }

        .sidebar-nav .nav-link.active {
            background: var(--sidebar-active);
            color: #fff;
            font-weight: 500;
        }

        .sidebar-nav .nav-link i { font-size: 1rem; width: 1.2rem; text-align: center; }

        /* ── Main ── */
        #main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
        }

        .topbar {
            background: #fff;
            border-bottom: 1px solid #e2e8f0;
            padding: .75rem 1.5rem;
            position: sticky;
            top: 0;
            z-index: 900;
        }

        .page-content { padding: 1.75rem 1.5rem; }

        /* ── Cards ── */
        .stat-card {
            border: none;
            border-radius: 12px;
            padding: 1.25rem 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .stat-card .stat-icon {
            width: 48px; height: 48px;
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.4rem;
        }

        .stat-card .stat-value { font-size: 1.6rem; font-weight: 700; line-height: 1; }
        .stat-card .stat-label { font-size: .78rem; color: #64748b; margin-top: .2rem; }

        /* ── Tables ── */
        .table-card { background: #fff; border-radius: 12px; border: none; }
        .table-card .card-header {
            background: transparent;
            border-bottom: 1px solid #e2e8f0;
            font-weight: 600;
            padding: 1rem 1.25rem;
        }

        .table thead th {
            font-size: .75rem;
            text-transform: uppercase;
            letter-spacing: .05em;
            color: #64748b;
            font-weight: 600;
            border-bottom: 1px solid #e2e8f0;
            background: #f8fafc;
        }

        /* ── Badges ── */
        .badge-status-active      { background: #dcfce7; color: #166534; }
        .badge-status-maintenance { background: #fef9c3; color: #854d0e; }
        .badge-status-retired     { background: #fee2e2; color: #991b1b; }
        .badge-status-in_use      { background: #dbeafe; color: #1e40af; }

        .low-stock-row { background: #fff5f5 !important; }

        /* ── Alert flash ── */
        .alert { border-radius: 10px; }

        /* ── Responsive ── */
        @media (max-width: 768px) {
            #sidebar { transform: translateX(-100%); transition: transform .3s; }
            #sidebar.show { transform: translateX(0); }
            #main-content { margin-left: 0; }
        }
    </style>
    @stack('styles')
</head>
<body>

<!-- ── Sidebar ── -->
<nav id="sidebar">
    <div class="sidebar-brand">
        <h5><i class="bi bi-cpu me-2 text-indigo-400"></i>Sistem MA</h5>
        <p>IT Asset Management</p>
    </div>

    <ul class="sidebar-nav list-unstyled mb-0">
        <li class="nav-section">Main</li>
        <li>
            <a href="{{ route('dashboard') }}"
               class="nav-link @if(request()->routeIs('dashboard')) active @endif">
                <i class="bi bi-grid-1x2"></i> Dashboard
            </a>
        </li>

        <li class="nav-section mt-2">Aset</li>
        <li>
            <a href="{{ route('devices.index') }}"
               class="nav-link @if(request()->routeIs('devices.*')) active @endif">
                <i class="bi bi-pc-display"></i> Perangkat
            </a>
        </li>
        <li>
            <a href="{{ route('spareparts.index') }}"
               class="nav-link @if(request()->routeIs('spareparts.*')) active @endif">
                <i class="bi bi-boxes"></i> Sparepart
            </a>
        </li>

        <li class="nav-section mt-2">Operasional</li>
        <li>
            <a href="{{ route('transactions.index') }}"
               class="nav-link @if(request()->routeIs('transactions.*')) active @endif">
                <i class="bi bi-arrow-left-right"></i> Transaksi
            </a>
        </li>
        <li>
            <a href="{{ route('maintenance.index') }}"
               class="nav-link @if(request()->routeIs('maintenance.*')) active @endif">
                <i class="bi bi-tools"></i> Maintenance
            </a>
        </li>
    </ul>

    <div class="px-3 py-3" style="border-top:1px solid rgba(255,255,255,.08)">
        <span class="text-muted" style="font-size:.7rem">© 2026 Global Putra International</span>
    </div>
</nav>

<!-- ── Main Content ── -->
<div id="main-content">
    <!-- Topbar -->
    <div class="topbar d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-2">
            <button class="btn btn-sm btn-light d-md-none" id="sidebarToggle">
                <i class="bi bi-list fs-5"></i>
            </button>
            <nav aria-label="breadcrumb" class="mb-0">
                <ol class="breadcrumb mb-0">
                    @yield('breadcrumb')
                </ol>
            </nav>
        </div>
        <div>
            <span class="text-muted" style="font-size:.8rem">
                <i class="bi bi-calendar3 me-1"></i>{{ now()->translatedFormat('d F Y') }}
            </span>
        </div>
    </div>

    <!-- Page Content -->
    <div class="page-content">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.getElementById('sidebarToggle')?.addEventListener('click', () => {
        document.getElementById('sidebar').classList.toggle('show');
    });
</script>
@stack('scripts')
</body>
</html>
