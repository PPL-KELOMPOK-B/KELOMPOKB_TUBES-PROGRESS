<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GWM - Notifikasi</title>
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

        /* Page Header */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 32px;
        }

        .page-header-left h1 {
            font-size: 28px;
            font-weight: 700;
            color: #2b567a;
            margin-bottom: 8px;
        }

        .unread-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #e0f2fe;
            color: #0369a1;
            font-size: 13px;
            font-weight: 600;
            padding: 6px 14px;
            border-radius: 20px;
        }

        .unread-badge svg {
            width: 14px;
            height: 14px;
        }

        .btn-mark-all {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            color: var(--text-dark);
            cursor: pointer;
            font-family: inherit;
            transition: all 0.2s;
            text-decoration: none;
        }

        .btn-mark-all:hover {
            background: #f8fbfe;
            border-color: var(--primary);
            color: var(--primary);
        }

        /* Notification List */
        .notification-list {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .notification-card {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 20px 24px;
            background: white;
            border-radius: var(--radius-lg);
            border: 2px solid transparent;
            box-shadow: var(--shadow-sm);
            transition: all 0.25s ease;
            cursor: pointer;
            text-decoration: none;
            color: inherit;
            position: relative;
        }

        .notification-card:hover {
            box-shadow: 0 6px 20px rgba(99, 164, 217, 0.1);
            transform: translateY(-1px);
        }

        .notification-card.unread {
            border-color: #93c5fd;
            background: #fafcff;
        }

        .notification-card.unread:hover {
            border-color: #60a5fa;
        }

        /* Status Icon */
        .notif-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .notif-icon.icon-menunggu {
            background: #e0f2fe;
            color: #0284c7;
        }

        .notif-icon.icon-proses {
            background: #fef3c7;
            color: #d97706;
        }

        .notif-icon.icon-diterima {
            background: #dcfce7;
            color: #16a34a;
        }

        .notif-icon.icon-ditolak {
            background: #fee2e2;
            color: #dc2626;
        }

        .notif-icon.icon-selesai {
            background: #dcfce7;
            color: #15803d;
        }

        /* Notification Content */
        .notif-content {
            flex: 1;
            min-width: 0;
        }

        .notif-title {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 6px;
            line-height: 1.4;
        }

        .notification-card.unread .notif-title {
            font-weight: 700;
        }

        .notif-time {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            color: #94a3b8;
            font-weight: 500;
        }

        .notif-time svg {
            width: 13px;
            height: 13px;
            flex-shrink: 0;
        }

        /* Unread Dot */
        .unread-dot {
            width: 10px;
            height: 10px;
            background: #3b82f6;
            border-radius: 50%;
            flex-shrink: 0;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
            animation: pulse-dot 2s infinite;
        }

        @keyframes pulse-dot {
            0%, 100% { box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15); }
            50% { box-shadow: 0 0 0 6px rgba(59, 130, 246, 0.08); }
        }

        /* Empty State */
        .empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: calc(100vh - 200px);
            padding: 80px 40px;
            color: var(--text-gray);
            border: 1px dashed #cbd5e1;
            border-radius: var(--radius-lg);
            background-color: white;
        }

        .empty-state svg {
            width: 72px;
            height: 72px;
            margin-bottom: 20px;
            color: #cbd5e1;
        }

        .empty-state h3 {
            font-size: 16px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 6px;
        }

        .empty-state p {
            font-size: 14px;
            font-weight: 500;
        }

        /* Flash Messages */
        .flash-success {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 14px 18px;
            background: #dcfce7;
            border: 1px solid #bbf7d0;
            border-radius: 12px;
            margin-bottom: 24px;
            font-size: 14px;
            font-weight: 500;
            color: #15803d;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-8px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Responsive */
        @media (max-width: 768px) {
            body {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                flex-direction: row;
                padding: 16px;
                border-right: none;
                border-bottom: 1px solid var(--border);
                overflow-x: auto;
            }

            .profile-container {
                display: none;
            }

            .nav-menu {
                flex-direction: row;
                gap: 4px;
            }

            .nav-item a {
                padding: 8px 12px;
                font-size: 12px;
                white-space: nowrap;
            }

            .nav-bottom {
                margin-top: 0;
            }

            .main-content {
                padding: 24px 16px;
            }

            .page-header {
                flex-direction: column;
                gap: 16px;
            }

            .notification-card {
                padding: 16px;
            }
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
                    <strong>Kecamatan Petugas {{ str_replace('Petugas ', '', auth()->user()->name) }}</strong>
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
                <a href="{{ route('petugas.draft') }}">
                    <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/><path d="M12 18v-5M9 15h6"></path></svg>
                    Draft
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('petugas.notifikasi') }}" class="active">
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
        <!-- Page Header -->
        <div class="page-header">
            <div class="page-header-left">
                <h1>Notifikasi</h1>
                <span class="unread-badge">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                    {{ $unreadCount }} notifikasi belum dibaca
                </span>
            </div>
            @if($unreadCount > 0)
                <form action="{{ route('petugas.notifikasi.read_all') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-mark-all">
                        <svg width="18" height="18" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        Tandai Semua Dibaca
                    </button>
                </form>
            @endif
        </div>

        @if(session('success'))
            <div class="flash-success">
                <svg width="18" height="18" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                {{ session('success') }}
            </div>
        @endif

        @if($notifications->isEmpty())
            <div class="empty-state">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                    <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                </svg>
                <h3>Belum Ada Notifikasi</h3>
                <p>Anda belum memiliki notifikasi perubahan status laporan.</p>
            </div>
        @else
            <div class="notification-list">
                @foreach($notifications as $notif)
                    @php
                        // Determine icon based on status
                        $iconClass = 'icon-menunggu';
                        if ($notif->status === 'proses') $iconClass = 'icon-proses';
                        elseif ($notif->status === 'diterima') $iconClass = 'icon-diterima';
                        elseif ($notif->status === 'ditolak') $iconClass = 'icon-ditolak';
                        elseif ($notif->status === 'selesai') $iconClass = 'icon-selesai';
                    @endphp

                    <a href="{{ route('petugas.notifikasi.read', $notif->id) }}" class="notification-card {{ !$notif->is_read ? 'unread' : '' }}" style="width: 100%; text-align: left; border: 2px solid {{ !$notif->is_read ? '#93c5fd' : 'transparent' }}; display: flex; text-decoration: none; color: inherit;">
                            <!-- Status Icon -->
                            <div class="notif-icon {{ $iconClass }}">
                                @if($notif->status === 'menunggu_validasi')
                                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                                @elseif($notif->status === 'proses')
                                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 4 23 10 17 10"/><polyline points="1 20 1 14 7 14"/><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"/></svg>
                                @elseif($notif->status === 'diterima')
                                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                                @elseif($notif->status === 'ditolak')
                                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                                @elseif($notif->status === 'selesai')
                                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                @else
                                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                                @endif
                            </div>

                            <!-- Notification Content -->
                            <div class="notif-content">
                                <div class="notif-title">{{ $notif->title }}</div>
                                <div class="notif-time">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                    {{ \Carbon\Carbon::parse($notif->created_at)->timezone('Asia/Jakarta')->locale('id')->isoFormat('D MMMM YYYY [pukul] HH.mm') }}
                                </div>
                            </div>

                            <!-- Unread Indicator -->
                            @if(!$notif->is_read)
                                <div class="unread-dot"></div>
                            @endif
                    </a>
                @endforeach
            </div>
        @endif
    </main>

</body>
</html>
