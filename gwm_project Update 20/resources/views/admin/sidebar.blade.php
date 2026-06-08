<style>
    /* Standardized Admin Sidebar Styles */
    .sidebar {
        width: 260px !important;
        background-color: #ffffff !important;
        border-right: 1px solid #e2e8f0 !important;
        display: flex !important;
        flex-direction: column !important;
        padding: 20px !important;
        box-sizing: border-box !important;
        height: 100vh !important;
        position: fixed !important;
        top: 0 !important;
        left: 0 !important;
        bottom: 0 !important;
        flex-shrink: 0 !important;
        z-index: 100 !important;
        overflow-y: auto !important;
    }

    .sidebar .brand {
        display: flex !important;
        align-items: center !important;
        gap: 12px !important;
        margin-bottom: 24px !important;
        padding: 0 !important;
    }

    .sidebar .profile-card {
        display: flex !important;
        align-items: center !important;
        gap: 12px !important;
        padding: 12px !important;
        background: linear-gradient(135deg, #eff6ff, #e0f2fe) !important;
        border-radius: 12px !important;
        margin-bottom: 32px !important;
        border: none !important;
    }

    .sidebar .profile-avatar {
        width: 36px !important;
        height: 36px !important;
        background: linear-gradient(135deg, #3b82f6, #2563eb) !important;
        color: white !important;
        border-radius: 50% !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        flex-shrink: 0 !important;
    }

    .sidebar .profile-info h4 {
        margin: 0 !important;
        font-size: 14px !important;
        font-weight: 600 !important;
        color: #0f172a !important;
    }

    .sidebar .profile-info p {
        margin: 2px 0 0 !important;
        font-size: 11px !important;
        color: #64748b !important;
    }

    .sidebar .nav-menu {
        list-style: none !important;
        padding: 0 !important;
        margin: 0 !important;
        flex: 1 !important;
        display: flex !important;
        flex-direction: column !important;
        gap: 4px !important;
    }

    .sidebar .nav-item {
        margin-bottom: 0 !important;
    }

    .sidebar .nav-link {
        display: flex !important;
        align-items: center !important;
        gap: 12px !important;
        padding: 10px 12px !important;
        border-radius: 10px !important;
        color: #475569 !important;
        text-decoration: none !important;
        font-size: 14px !important;
        font-weight: 500 !important;
        transition: all 0.2s ease-in-out !important;
        background: transparent !important;
    }

    .sidebar .nav-link.active {
        background: linear-gradient(135deg, #eff6ff, #dbeafe) !important;
        color: #2563eb !important;
        font-weight: 600 !important;
    }

    .sidebar .nav-link:hover:not(.active) {
        background-color: #f1f5f9 !important;
        color: #0f172a !important;
        transform: translateX(4px) !important;
    }

    .sidebar .nav-icon {
        width: 18px !important;
        height: 18px !important;
        stroke-width: 2 !important;
        stroke: currentColor !important;
        fill: none !important;
        flex-shrink: 0 !important;
        transition: transform 0.2s ease-in-out !important;
    }

    .sidebar .nav-link:hover .nav-icon {
        transform: scale(1.1) !important;
    }

    .sidebar .nav-bottom {
        margin-top: auto !important;
    }

    /* Force all admin views utilizing sidebar to display correctly layout-wise */
    .main-content {
        margin-left: 260px !important;
        transition: margin-left 0.3s ease !important;
    }

    /* Media query for mobile views */
    @media (max-width: 768px) {
        .sidebar {
            display: none !important;
        }
        .main-content {
            margin-left: 0 !important;
            padding: 20px !important;
        }
    }
</style>

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
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
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
            <a href="{{ route('admin.create_petugas') }}" class="nav-link {{ request()->routeIs('admin.create_petugas') ? 'active' : '' }}">
                <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <line x1="19" y1="8" x2="19" y2="14"></line>
                    <line x1="22" y1="11" x2="16" y2="11"></line>
                </svg>
                Buat Akun Petugas
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.validasi.index') }}" class="nav-link {{ request()->routeIs('admin.validasi.*') ? 'active' : '' }}">
                <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2">
                    <polyline points="20 6 9 17 4 12" />
                </svg>
                Validasi
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.prioritas') }}" class="nav-link {{ request()->routeIs('admin.prioritas') ? 'active' : '' }}">
                <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2">
                    <polyline points="22 12 18 12 15 21 9 3 6 12 2 12" />
                </svg>
                Prioritas
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.tindak_lanjut') }}" class="nav-link {{ request()->routeIs('admin.tindak_lanjut') ? 'active' : '' }}">
                <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2">
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
            <a href="{{ route('admin.monitoring') }}" class="nav-link {{ request()->routeIs('admin.monitoring*') ? 'active' : '' }}">
                <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="2" y="3" width="20" height="14" rx="2" ry="2" />
                    <line x1="8" y1="21" x2="16" y2="21" />
                    <line x1="12" y1="17" x2="12" y2="21" />
                </svg>
                Monitoring
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.riwayat_kondisi') }}" class="nav-link {{ request()->routeIs('admin.riwayat_kondisi') ? 'active' : '' }}">
                <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                </svg>
                Riwayat Kondisi
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.history') }}" class="nav-link {{ request()->routeIs('admin.history*') ? 'active' : '' }}">
                <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2">
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
            <a href="{{ route('admin.export.index') }}" class="nav-link {{ request()->routeIs('admin.export.*') ? 'active' : '' }}">
                <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                    <polyline points="7 10 12 15 17 10" />
                </svg>
                Export Data
            </a>
        </li>
    </ul>

    <div class="nav-bottom">
        <a href="{{ route('logout') }}" class="nav-link">
            <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2">
                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                <polyline points="16 17 21 12 16 7" />
                <line x1="21" y1="12" x2="9" y2="12" />
            </svg>
            Keluar
        </a>
    </div>
</aside>
