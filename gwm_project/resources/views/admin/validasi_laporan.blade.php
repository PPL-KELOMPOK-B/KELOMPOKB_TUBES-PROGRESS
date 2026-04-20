<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GWM - Validasi Laporan</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg-color: #f8fafc;
            --sidebar-bg: #ffffff;
            --text-dark: #0f172a;
            --text-gray: #64748b;
            --border: #e2e8f0;
            --card-radius: 12px;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-dark);
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 260px;
            background-color: var(--sidebar-bg);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            padding: 20px;
            box-sizing: border-box;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 24px;
        }

        .brand-icon {
            width: 36px;
            height: 36px;
            background-color: #0ea5e9;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .brand-text h2 {
            margin: 0;
            font-size: 16px;
            font-weight: 700;
        }

        .brand-text p {
            margin: 0;
            font-size: 11px;
            color: var(--text-gray);
        }

        .profile-card {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px;
            background-color: #eff6ff;
            border-radius: 10px;
            margin-bottom: 32px;
        }

        .profile-avatar {
            width: 36px;
            height: 36px;
            background-color: #3b82f6;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .profile-info h4 {
            margin: 0;
            font-size: 14px;
            font-weight: 600;
        }

        .profile-info p {
            margin: 2px 0 0;
            font-size: 11px;
            color: #64748b;
        }

        .nav-menu {
            list-style: none;
            padding: 0;
            margin: 0;
            flex: 1;
        }

        .nav-item {
            margin-bottom: 4px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 12px;
            border-radius: 8px;
            color: #475569;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s;
        }

        .nav-link.active {
            background-color: #eff6ff;
            color: #2563eb;
        }

        .nav-link:hover:not(.active) {
            background-color: #f1f5f9;
        }

        .nav-icon {
            width: 18px;
            height: 18px;
            stroke-width: 2;
        }

        .nav-bottom {
            margin-top: auto;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            padding: 40px;
            overflow-y: auto;
        }

        .page-header {
            margin-bottom: 32px;
        }

        .page-header h1 {
            margin: 0 0 8px 0;
            font-size: 28px;
            font-weight: 600;
        }

        .page-header p {
            margin: 0;
            color: var(--text-gray);
            font-size: 15px;
        }

        /* Success Alert */
        .alert-success {
            background: #d1fae5;
            color: #065f46;
            padding: 12px 20px;
            border-radius: 8px;
            margin-bottom: 24px;
            font-weight: 500;
            font-size: 14px;
            border: 1px solid #a7f3d0;
        }

        /* Table Controls */
        .table-controls {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            gap: 16px;
            flex-wrap: wrap;
        }

        .table-controls-left {
            display: flex;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
        }

        .entries-select {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            color: var(--text-gray);
        }

        .entries-select select {
            padding: 8px 12px;
            border: 1px solid var(--border);
            border-radius: 6px;
            font-family: inherit;
            font-size: 14px;
            outline: none;
            cursor: pointer;
            background: white;
        }

        .filter-group {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            font-weight: 600;
            color: var(--text-dark);
        }

        .filter-group select {
            padding: 8px 12px;
            border: 1px solid var(--border);
            border-radius: 6px;
            font-family: inherit;
            font-size: 14px;
            outline: none;
            cursor: pointer;
            background: white;
            min-width: 180px;
        }

        .search-box input {
            padding: 8px 16px;
            border: 1px solid var(--border);
            border-radius: 6px;
            font-family: inherit;
            font-size: 14px;
            outline: none;
            min-width: 200px;
            background: white;
        }

        .search-box input::placeholder {
            color: #94a3b8;
        }

        .search-box input:focus {
            border-color: #3b82f6;
        }

        /* Table */
        .table-card {
            background: white;
            border-radius: var(--card-radius);
            border: 1px solid var(--border);
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0,0,0,0.02);
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table thead {
            background-color: #f8fafc;
        }

        .data-table th {
            padding: 14px 16px;
            text-align: left;
            font-size: 12px;
            font-weight: 700;
            color: var(--text-gray);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid var(--border);
        }

        .data-table td {
            padding: 16px;
            font-size: 14px;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
        }

        .data-table tbody tr {
            transition: background 0.15s;
        }

        .data-table tbody tr:hover {
            background-color: #f8fafc;
        }

        .data-table tbody tr:last-child td {
            border-bottom: none;
        }

        .location-cell {
            line-height: 1.5;
        }

        .location-cell .kelurahan {
            font-weight: 600;
            color: var(--text-dark);
        }

        .location-cell .kecamatan {
            font-size: 12px;
            color: var(--text-gray);
        }

        /* Badges */
        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
        }

        .badge-waiting {
            background: #fef3c7;
            color: #92400e;
        }

        .badge-diterima {
            background: #d1fae5;
            color: #065f46;
        }

        .badge-ditolak {
            background: #fee2e2;
            color: #991b1b;
        }

        /* Buttons */
        .btn-view {
            padding: 6px 16px;
            background: white;
            border: 1px solid var(--border);
            border-radius: 6px;
            font-size: 13px;
            font-weight: 500;
            color: var(--text-dark);
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            transition: all 0.2s;
            font-family: inherit;
        }

        .btn-view:hover {
            border-color: #3b82f6;
            color: #3b82f6;
        }

        .btn-approve {
            padding: 6px 14px;
            background: #10b981;
            border: none;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            color: white;
            cursor: pointer;
            font-family: inherit;
            transition: all 0.2s;
        }

        .btn-approve:hover {
            background: #059669;
        }

        .btn-reject {
            padding: 6px 14px;
            background: #ef4444;
            border: none;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            color: white;
            cursor: pointer;
            font-family: inherit;
            transition: all 0.2s;
        }

        .btn-reject:hover {
            background: #dc2626;
        }

        .action-buttons {
            display: flex;
            gap: 16px;
            justify-content: center;
        }

        /* Pagination */
        .pagination-wrap {
            display: flex;
            justify-content: center;
            padding: 16px;
            gap: 4px;
        }

        .pagination-wrap a,
        .pagination-wrap span {
            padding: 8px 14px;
            border: 1px solid var(--border);
            border-radius: 6px;
            font-size: 13px;
            text-decoration: none;
            color: var(--text-gray);
            transition: all 0.2s;
        }

        .pagination-wrap a:hover {
            background: #eff6ff;
            border-color: #3b82f6;
            color: #3b82f6;
        }

        .pagination-wrap .active-page {
            background: #3b82f6;
            color: white;
            border-color: #3b82f6;
        }

        .pagination-wrap .disabled {
            opacity: 0.4;
            cursor: default;
        }

        /* Empty State */
        .empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 60px 0;
            color: var(--text-gray);
        }

        .empty-state svg {
            margin-bottom: 16px;
            color: #94a3b8;
        }

        .empty-state p {
            font-size: 14px;
            font-weight: 500;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="brand">
            <div class="brand-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="white" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z"/>
                </svg>
            </div>
            <div class="brand-text">
                <h2>GWM</h2>
                <p>Gunungkidul Water Monitor</p>
            </div>
        </div>

        <div class="profile-card">
            <div class="profile-avatar">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
            </div>
            <div class="profile-info">
                <h4>Administrator</h4>
                <p>{{ auth()->user()->nama ?? 'Admin Gunungkidul' }}</p>
            </div>
        </div>

        <ul class="nav-menu">
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="nav-link">
                    <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="3" y="3" width="7" height="9" rx="1"/><rect x="14" y="3" width="7" height="5" rx="1"/><rect x="14" y="12" width="7" height="9" rx="1"/><rect x="3" y="16" width="7" height="5" rx="1"/></svg>
                    Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.create_petugas') }}" class="nav-link">
                    <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><line x1="19" y1="8" x2="19" y2="14"></line><line x1="22" y1="11" x2="16" y2="11"></line></svg>
                    Buat Akun Petugas
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.validasi') }}" class="nav-link active">
                    <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><polyline points="20 6 9 17 4 12"/></svg>
                    Validasi
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                    Prioritas
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                    Tindak Lanjut
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                    Monitoring
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                    Log Aktivitas
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                    Export Data
                </a>
            </li>
        </ul>

        <div class="nav-bottom">
            <a href="/logout" class="nav-link">
                <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                Keluar
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        <div class="page-header">
            <h1>Validasi Laporan</h1>
            <p>Review dan validasi laporan dari petugas desa</p>
        </div>

        <form method="GET" action="{{ route('admin.validasi') }}" id="filterForm">
            <div class="table-controls">
                <div class="table-controls-left">
                    <div class="entries-select">
                        <select name="per_page" onchange="document.getElementById('filterForm').submit();">
                            <option value="10" {{ request('per_page') == 10 || !request('per_page') ? 'selected' : '' }}>10</option>
                            <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                        </select>
                        <span>Entries Per Page</span>
                    </div>

                    <div class="filter-group">
                        <span>Filter Berdasarkan:</span>
                        <select name="kecamatan_id" onchange="document.getElementById('filterForm').submit();">
                            <option value="semua" {{ !request('kecamatan_id') || request('kecamatan_id') == 'semua' ? 'selected' : '' }}>Kecamatan</option>
                            @foreach($kecamatans as $kec)
                                <option value="{{ $kec->id }}" {{ request('kecamatan_id') == $kec->id ? 'selected' : '' }}>{{ $kec->nama_kecamatan }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="search-box">
                    <input type="text" name="search" placeholder="Search..." value="{{ request('search') }}" onkeydown="if(event.key==='Enter'){document.getElementById('filterForm').submit();}">
                </div>
            </div>
        </form>

        <div class="table-card">
            @if($laporan->count() > 0)
            <table class="data-table">
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>Lokasi</th>
                        <th>Tanggal</th>
                        <th>Catatan</th>
                        <th>Review</th>
                        <th style="text-align: center;">Validasi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($laporan as $index => $item)
                    <tr>
                        <td>{{ $laporan->firstItem() + $index }}.</td>
                        <td>
                            <div class="location-cell">
                                <div class="kelurahan">Kelurahan {{ $item->kelurahan->nama_kelurahan ?? '-' }}</div>
                                <div class="kecamatan">{{ $item->kecamatan->nama_kecamatan ?? '-' }}</div>
                            </div>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($item->created_at)->timezone('Asia/Jakarta')->format('d/m/Y') }}</td>
                        <td>
                            @if($item->status === 'diajukan')
                                <span class="badge badge-waiting">Waiting</span>
                            @elseif($item->status === 'divalidasi')
                                <span class="badge badge-diterima">Diterima</span>
                            @elseif($item->status === 'ditolak')
                                <span class="badge badge-ditolak">Ditolak</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.view_laporan', $item->id) }}" class="btn-view">View</a>
                        </td>
                        <td style="text-align: center;">
                            @if($item->status === 'diajukan')
                                <div class="action-buttons">
                                    <form action="{{ route('admin.approve_laporan', $item->id) }}" method="POST" style="margin:0;">
                                        @csrf
                                        <button type="submit" class="btn-approve" onclick="return confirm('Approve laporan ini?');">Approve</button>
                                    </form>
                                    <form action="{{ route('admin.reject_laporan', $item->id) }}" method="POST" style="margin:0;">
                                        @csrf
                                        <button type="submit" class="btn-reject" onclick="return confirm('Reject laporan ini?');">Reject</button>
                                    </form>
                                </div>
                            @else
                                <span style="font-size: 13px; color: #94a3b8;">—</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            @if($laporan->hasPages())
            <div class="pagination-wrap">
                @if($laporan->onFirstPage())
                    <span class="disabled">&laquo;</span>
                @else
                    <a href="{{ $laporan->previousPageUrl() }}">&laquo;</a>
                @endif

                @foreach($laporan->getUrlRange(1, $laporan->lastPage()) as $page => $url)
                    @if($page == $laporan->currentPage())
                        <span class="active-page">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach

                @if($laporan->hasMorePages())
                    <a href="{{ $laporan->nextPageUrl() }}">&raquo;</a>
                @else
                    <span class="disabled">&raquo;</span>
                @endif
            </div>
            @endif

            @else
                <div class="empty-state">
                    <svg width="48" height="48" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                    <p>Belum ada laporan yang perlu divalidasi.</p>
                </div>
            @endif
        </div>
    </main>
</body>
</html>
