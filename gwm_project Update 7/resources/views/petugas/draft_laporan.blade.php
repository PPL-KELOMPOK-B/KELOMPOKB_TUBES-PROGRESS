<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GWM - Draft Laporan</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-body: #f4f8fb;
            --bg-sidebar: #ffffff;
            --bg-card: #ffffff;
            --text-dark: #1e293b;
            --text-gray: #64748b;
            --primary: #63a4d9;
            --primary-gradient: linear-gradient(135deg, #70b4df, #528fc3);
            --border: #f1f5f9;
            --shadow-sm: 0 2px 10px rgba(0,0,0,0.02);
            --shadow-md: 0 8px 30px rgba(0,0,0,0.04);
            --radius-md: 12px;
            --radius-lg: 16px;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Public Sans', sans-serif;
            background-color: var(--bg-body);
            color: var(--text-dark);
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 280px;
            background-color: var(--bg-sidebar);
            display: flex;
            flex-direction: column;
            padding: 24px;
            border-right: 1px solid var(--border);
            z-index: 10;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 32px;
            padding-left: 8px;
        }

        .brand-icon {
            width: 36px;
            height: 36px;
            background: var(--primary-gradient);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            box-shadow: 0 4px 12px rgba(99, 164, 217, 0.3);
        }

        .brand-text h2 {
            font-size: 18px;
            font-weight: 700;
            color: var(--primary);
            line-height: 1.2;
        }

        .brand-text p {
            font-size: 11px;
            color: var(--text-gray);
        }

        .profile-container {
            background-color: #f8fbfe;
            border: 1px solid #e2f0fb;
            border-radius: var(--radius-lg);
            padding: 16px;
            margin-bottom: 32px;
        }

        .profile-top {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 12px;
            padding-bottom: 12px;
            border-bottom: 1px dashed #cce3f5;
        }

        .profile-avatar {
            width: 40px;
            height: 40px;
            background-color: #63a4d9;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .profile-info h4 {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-dark);
        }

        .profile-info p {
            font-size: 12px;
            color: var(--text-gray);
            margin-top: 2px;
        }

        .profile-bottom {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .profile-bottom svg {
            color: var(--primary);
        }

        .profile-location {
            display: flex;
            flex-direction: column;
        }

        .profile-location span {
            font-size: 10px;
            color: var(--text-gray);
        }

        .profile-location strong {
            font-size: 13px;
            color: var(--primary);
            font-weight: 600;
        }

        .nav-menu {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 8px;
            flex: 1;
        }

        .nav-item a {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 12px 16px;
            border-radius: var(--radius-md);
            color: var(--text-gray);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s;
        }

        .nav-item a svg {
            stroke-width: 2;
        }

        .nav-item a.active {
            background: var(--primary-gradient);
            color: white;
            box-shadow: 0 4px 14px rgba(99, 164, 217, 0.3);
            font-weight: 600;
        }

        .nav-item a:hover:not(.active) {
            background-color: #f8fbfe;
            color: var(--primary);
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

        .top-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 32px;
        }

        .page-title h1 {
            font-size: 28px;
            font-weight: 700;
            color: #2b567a;
            margin-bottom: 6px;
        }

        .page-title p {
            font-size: 14px;
            color: #475569;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        
        .page-title p svg {
            color: #63a4d9;
        }

        .btn-primary {
            background: var(--primary-gradient);
            color: white;
            box-shadow: 0 4px 12px rgba(99, 164, 217, 0.2);
            text-decoration: none;
            padding: 10px 16px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
        }

        .btn-primary:hover {
            box-shadow: 0 6px 16px rgba(99, 164, 217, 0.3);
            transform: translateY(-1px);
        }

        /* Draft Cards Layout */
        .draft-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
            gap: 24px;
        }

        .draft-card {
            background: var(--bg-card);
            border-radius: var(--radius-lg);
            padding: 24px;
            box-shadow: var(--shadow-sm);
            border: 1px solid rgba(0,0,0,0.02);
            transition: transform 0.2s;
        }
        
        .draft-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .draft-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
        }

        .draft-header h3 {
            font-size: 17px;
            font-weight: 700;
            color: #0f172a;
        }

        .draft-badge {
            background-color: #f1f5f9;
            color: #64748b;
            font-size: 11px;
            padding: 4px 8px;
            border-radius: 4px;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .draft-location {
            display: flex;
            align-items: center;
            gap: 6px;
            color: #63a4d9;
            font-size: 12px;
            font-weight: 500;
            margin-bottom: 12px;
        }

        .draft-info {
            font-size: 13px;
            color: var(--text-gray);
            margin-bottom: 6px;
        }
        
        .draft-info strong {
            font-weight: 600;
            color: var(--text-dark);
        }

        .draft-date {
            font-size: 11px;
            color: #94a3b8;
            margin-top: 16px;
            margin-bottom: 20px;
        }

        .draft-actions {
            display: flex;
            gap: 12px;
        }

        .btn-edit {
            flex: 1;
            padding: 10px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            background: white;
            color: var(--text-dark);
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            transition: background 0.2s;
        }
        
        .btn-edit:hover {
            background: #f8fafc;
        }

        .btn-delete {
            width: 40px;
            height: 40px;
            background: #fffafa;
            border: 1px solid #fee2e2;
            border-radius: 8px;
            color: #ef4444;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .btn-delete:hover {
            background: #fef2f2;
        }

        .empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 60px 0;
            text-align: center;
            background: white;
            border-radius: var(--radius-lg);
            border: 1px dashed #cbd5e1;
        }

        .empty-state svg {
            color: #94a3b8;
            margin-bottom: 16px;
        }

        .empty-state h3 {
            font-size: 16px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 8px;
        }

        .empty-state p {
            font-size: 14px;
            color: var(--text-gray);
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="brand" style="margin-bottom: 24px; padding: 0;">
            <img src="{{ asset('images/logo-gwm.png') }}" alt="GWM Logo" style="width: 100%; max-height: 80px; object-fit: contain;">
        </div>

        <div class="profile-container">
            <div class="profile-top">
                <div class="profile-avatar">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                </div>
                <div class="profile-info">
                    <h4>Petugas</h4>
                    <p>{{ auth()->user()->name ?? 'Petugas Kecamatan' }}</p>
                </div>
            </div>
            <div class="profile-bottom">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                    <circle cx="12" cy="10" r="3"></circle>
                </svg>
                <div class="profile-location">
                    <span>Wilayah Aktif</span>
                    <strong>Kecamatan {{ auth()->user()->name ?? 'Gedangsari' }}</strong>
                </div>
            </div>
        </div>

        <ul class="nav-menu">
            <li class="nav-item">
                <a href="{{ route('petugas.dashboard') }}">
                    <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="9" rx="1"/><rect x="14" y="3" width="7" height="5" rx="1"/><rect x="14" y="12" width="7" height="9" rx="1"/><rect x="3" y="16" width="7" height="5" rx="1"/></svg>
                    Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('petugas.laporan.index') }}">
                    <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                    Laporan
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('petugas.draft') }}" class="active">
                    <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/><path d="M12 18v-5M9 15h6"></path></svg>
                    Draft
                </a>
            </li>
            <li class="nav-item">
                <a href="#">
                    <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                    Notifikasi
                </a>
            </li>
        </ul>

        <div class="nav-bottom">
            <li class="nav-item" style="list-style: none;">
                <a href="/logout">
                    <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                    Keluar
                </a>
            </li>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        @if(session('success'))
            <div style="background: #10b981; color: white; padding: 12px 20px; border-radius: var(--radius-md); margin-bottom: 24px; font-weight: 500; font-size: 14px;">
                {{ session('success') }}
            </div>
        @endif

        <div class="top-header">
            <div class="page-title">
                <h1>Draft Laporan</h1>
                <p>
                    <svg width="16" height="16" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                    Draft laporan Kecamatan {{ auth()->user()->name ?? 'Purwosari' }}
                </p>
            </div>
            <a href="{{ route('petugas.create_laporan') }}" class="btn-primary">
                <svg width="16" height="16" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                Buat Laporan Baru
            </a>
        </div>

        @if($drafts->count() > 0)
            <div class="draft-grid">
                @foreach($drafts as $draft)
                    <div class="draft-card">
                        <div class="draft-header">
                            <h3>Kelurahan {{ $draft->kelurahan ?? '-' }}</h3>
                            <span class="draft-badge">D{{ str_pad($draft->id, 3, '0', STR_PAD_LEFT) }}</span>
                        </div>
                        
                        <div class="draft-location">
                            <svg width="14" height="14" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                            Kec. {{ $draft->kecamatan }}
                        </div>
                        
                        <div class="draft-info">
                            Kondisi: <strong>{{ $draft->kondisi_air ?? 'Belum diisi' }}</strong>
                        </div>
                        <div class="draft-info">
                            Warga terdampak: <strong>{{ $draft->warga_terdampak ?? 0 }} orang</strong>
                        </div>
                        
                        <div class="draft-date">
                            Disimpan: {{ \Carbon\Carbon::parse($draft->updated_at)->timezone('Asia/Jakarta')->locale('id')->isoFormat('D MMMM YYYY [pukul] HH.mm') }} WIB
                        </div>
                        
                        <div class="draft-actions">
                            <a href="{{ route('petugas.edit_laporan', $draft->id) }}" class="btn-edit">
                                <svg width="16" height="16" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                Lanjutkan Edit
                            </a>
                            <form action="{{ route('petugas.delete_laporan', $draft->id) }}" method="POST" style="margin: 0;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus draft ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete" title="Hapus Draft">
                                    <svg width="16" height="16" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <svg width="48" height="48" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                <h3>Tidak Ada Draft</h3>
                <p>Anda belum menyimpan draft laporan apapun.</p>
            </div>
        @endif
    </main>
</body>
</html>
