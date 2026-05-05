<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GWM - Validasi Laporan</title>
    <!-- Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg-color: #f8fafc;
            --sidebar-bg: #ffffff;
            --text-dark: #0f172a;
            --text-gray: #64748b;
            --primary: #blue;
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

        /* Sidebar Styles */
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

        .profile-card {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px;
            background-color: #ffffff;
            border: 1px solid var(--border);
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
            background-color: #3b82f6;
            color: #ffffff;
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
            color: var(--text-dark);
        }

        .page-header p {
            margin: 0;
            color: var(--text-gray);
            font-size: 15px;
        }

        /* Table Card */
        .card {
            background: white;
            border-radius: var(--card-radius);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--border);
            overflow: hidden;
        }
        
        .table-header-controls {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 24px;
            border-bottom: 1px solid var(--border);
        }
        
        .entries-control {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 14px;
            color: var(--text-dark);
        }
        
        .entries-control select {
            padding: 6px 32px 6px 12px;
            border-radius: 6px;
            border: 1px solid var(--border);
            background-color: white;
            outline: none;
            appearance: none;
            background-image: url("data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%23131313%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E");
            background-repeat: no-repeat;
            background-position: right 12px top 50%;
            background-size: 10px auto;
        }
        
        .search-control {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        
        .filter-select {
            padding: 8px 32px 8px 12px;
            border-radius: 6px;
            border: 1px solid var(--border);
            color: var(--text-gray);
            font-size: 14px;
            outline: none;
            appearance: none;
            background-image: url("data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%23131313%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E");
            background-repeat: no-repeat;
            background-position: right 12px top 50%;
            background-size: 10px auto;
        }

        .search-input {
            padding: 8px 12px;
            border-radius: 6px;
            border: 1px solid var(--border);
            font-size: 14px;
            width: 200px;
            outline: none;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background-color: #e2e8f0;
            color: var(--text-dark);
            font-weight: 600;
            font-size: 13px;
            text-align: left;
            padding: 16px 24px;
        }

        td {
            padding: 16px 24px;
            border-bottom: 1px solid var(--border);
            font-size: 14px;
            vertical-align: middle;
        }

        tr:last-child td {
            border-bottom: none;
        }

        /* Status Badges */
        .badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-waiting {
            background-color: #fef08a;
            color: #854d0e;
        }

        .badge-approve {
            background-color: #86efac;
            color: #166534;
        }

        .badge-reject {
            background-color: #fca5a5;
            color: #991b1b;
        }

        /* Action Buttons */
        .btn-view {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 6px 16px;
            background: white;
            border: 1px solid var(--border);
            border-radius: 6px;
            color: var(--text-dark);
            font-size: 13px;
            font-weight: 500;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .btn-view:hover {
            background: #f8fafc;
        }

        .validasi-actions {
            display: flex;
            gap: 8px;
        }

        .btn-approve {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 6px 16px;
            background-color: #4ade80;
            border: none;
            border-radius: 6px;
            color: #14532d;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
        }

        .btn-reject {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 6px 16px;
            background-color: #ef4444;
            border: none;
            border-radius: 6px;
            color: white;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
        }
        
        .location-info {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }
        
        .location-kelurahan {
            font-weight: 600;
            color: var(--text-dark);
        }
        
        .location-kecamatan {
            font-size: 12px;
            color: var(--text-gray);
        }
    </style>
</head>

<body>

    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="brand" style="margin-bottom: 24px; padding: 0;">
            <img src="{{ asset('images/logo-gwm.png') }}" alt="GWM Logo"
                style="width: 100%; max-height: 80px; object-fit: contain;">
        </div>

        <div class="profile-card">
            <div class="profile-avatar">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
            </div>
            <div class="profile-info">
                <h4>Administrator</h4>
                <p>Admin</p>
            </div>
        </div>

        <ul class="nav-menu">
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="nav-link">
                    <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor">
                        <rect x="3" y="3" width="7" height="9" rx="1" />
                        <rect x="14" y="3" width="7" height="5" rx="1" />
                        <rect x="14" y="12" width="7" height="9" rx="1" />
                        <rect x="3" y="16" width="7" height="5" rx="1" />
                    </svg>
                    Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.create_petugas') }}" class="nav-link">
                    <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <line x1="19" y1="8" x2="19" y2="14"></line>
                        <line x1="22" y1="11" x2="16" y2="11"></line>
                    </svg>
                    Buat Akun Petugas
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.validasi.index') }}" class="nav-link active">
                    <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor">
                        <polyline points="20 6 9 17 4 12" />
                    </svg>
                    Validasi
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor">
                        <polyline points="22 12 18 12 15 21 9 3 6 12 2 12" />
                    </svg>
                    Prioritas
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                        <polyline points="14 2 14 8 20 8" />
                        <line x1="16" y1="13" x2="8" y2="13" />
                        <line x1="16" y1="17" x2="8" y2="17" />
                        <polyline points="10 9 9 9 8 9" />
                    </svg>
                    Tindak Lanjut
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor">
                        <polyline points="22 12 18 12 15 21 9 3 6 12 2 12" />
                    </svg>
                    Monitoring
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                        <polyline points="14 2 14 8 20 8" />
                        <line x1="16" y1="13" x2="8" y2="13" />
                        <line x1="16" y1="17" x2="8" y2="17" />
                        <polyline points="10 9 9 9 8 9" />
                    </svg>
                    Log Aktivitas
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                        <polyline points="7 10 12 15 17 10" />
                        <line x1="12" y1="15" x2="12" y2="3" />
                    </svg>
                    Export Data
                </a>
            </li>
        </ul>

        <div class="nav-bottom">
            <a href="/logout" class="nav-link">
                <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                    <polyline points="16 17 21 12 16 7" />
                    <line x1="21" y1="12" x2="9" y2="12" />
                </svg>
                Keluar
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        @if(session('success'))
            <div style="background-color: #dcfce7; color: #166534; padding: 16px; border-radius: 8px; margin-bottom: 24px; display: flex; align-items: center; gap: 12px; border: 1px solid #bbf7d0;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                {{ session('success') }}
            </div>
        @endif

        <div class="page-header">
            <h1>Validasi Laporan</h1>
            <p>Review dan validasi laporan dari petugas desa</p>
        </div>

        <div class="card">
            <div class="table-header-controls">
                <div class="entries-control">
                    <select>
                        <option>10</option>
                        <option>25</option>
                        <option>50</option>
                    </select>
                    Entries Per Page
                </div>
                
                <div class="search-control">
                    <span style="font-size: 14px; font-weight: 600;">Filter Berdasarkan:</span>
                    <select class="filter-select">
                        <option>Kecamatan/Kelurahan</option>
                    </select>
                    <input type="text" class="search-input" placeholder="Search...">
                </div>
            </div>
            
            <table>
                <thead>
                    <tr>
                        <th width="5%">NO</th>
                        <th width="25%">Lokasi</th>
                        <th width="20%">Tanggal</th>
                        <th width="15%" style="text-align: center;">Catatan</th>
                        <th width="15%" style="text-align: center;">Review</th>
                        <th width="20%" style="text-align: center;">Validasi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($laporans as $index => $lap)
                        <tr>
                            <td>{{ $index + 1 }}.</td>
                            <td>
                                <div class="location-info">
                                    <span class="location-kelurahan">Kelurahan {{ $lap->kelurahan }}</span>
                                    <span class="location-kecamatan">Kec. {{ str_replace('Petugas ', '', $lap->kecamatan ?? 'Purwosari') }}</span>
                                </div>
                            </td>
                            <td>{{ $lap->created_at->format('d/m/Y') }}</td>
                            <td style="text-align: center;">
                                @if($lap->status == 'menunggu_validasi')
                                    <span class="badge badge-waiting">Waiting</span>
                                @elseif($lap->status == 'diterima' || $lap->status == 'proses' || $lap->status == 'selesai')
                                    <span class="badge badge-approve">Approve</span>
                                @elseif($lap->status == 'ditolak')
                                    <span class="badge badge-reject">Reject</span>
                                @endif
                            </td>
                            <td style="text-align: center;">
                                <a href="{{ route('admin.validasi.detail', $lap->id) }}" class="btn-view">View</a>
                            </td>
                            <td style="text-align: center;">
                                @if($lap->status == 'menunggu_validasi')
                                    <div class="validasi-actions" style="justify-content: center;">
                                        <form action="{{ route('admin.validasi.action', $lap->id) }}" method="POST" style="margin: 0;">
                                            @csrf
                                            <input type="hidden" name="action" value="approve">
                                            <button type="submit" class="btn-approve">Approve</button>
                                        </form>
                                        <form action="{{ route('admin.validasi.action', $lap->id) }}" method="POST" style="margin: 0;">
                                            @csrf
                                            <input type="hidden" name="action" value="reject">
                                            <button type="submit" class="btn-reject" onclick="return confirm('Yakin ingin menolak laporan ini?')">Reject</button>
                                        </form>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 32px; color: var(--text-gray);">Tidak ada laporan saat ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>
</body>

</html>
