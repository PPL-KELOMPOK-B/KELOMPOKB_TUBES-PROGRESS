<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GWM - Klasifikasi Tingkat Kekeringan</title>
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
            --primary: #2563eb;
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

        /* Page Header */
        .page-title {
            text-align: center;
            margin-bottom: 40px;
        }

        .page-title h1 {
            margin: 0 0 8px 0;
            font-size: 26px;
            font-weight: 700;
            color: var(--text-dark);
        }

        .page-title p {
            margin: 0;
            color: var(--text-gray);
            font-size: 14px;
        }

        /* Content Layout */
        .klasifikasi-content {
            display: flex;
            gap: 40px;
            align-items: flex-start;
            max-width: 1000px;
            margin: 0 auto;
        }

        /* Left Section - Info Cards */
        .info-section {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .info-card {
            background: white;
            border-radius: var(--card-radius);
            padding: 24px 28px;
            border: 1px solid var(--border);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
            animation: fadeInUp 0.4s ease forwards;
        }

        .info-card:nth-child(2) { animation-delay: 0.1s; }
        .info-card:nth-child(3) { animation-delay: 0.2s; }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(12px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .info-card .info-row {
            display: flex;
            margin-bottom: 8px;
        }

        .info-card .info-row:last-child {
            margin-bottom: 0;
        }

        .info-label {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-dark);
            min-width: 180px;
        }

        .info-value {
            font-size: 14px;
            color: var(--text-dark);
        }

        /* Keterangan Card */
        .keterangan-card {
            background: #f8fafc;
            border-radius: var(--card-radius);
            padding: 20px 28px;
            border: 1px solid #e2e8f0;
            animation: fadeInUp 0.4s ease forwards;
            animation-delay: 0.3s;
            opacity: 0;
        }

        .keterangan-card .keterangan-label {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 6px;
        }

        .keterangan-card .keterangan-text {
            font-size: 14px;
            color: #475569;
            line-height: 1.6;
        }

        /* Right Section - Classification Badge */
        .classification-section {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 12px;
            padding-top: 60px;
            animation: fadeInUp 0.5s ease forwards;
            animation-delay: 0.15s;
            opacity: 0;
        }

        .classification-label {
            font-size: 18px;
            font-weight: 600;
            color: var(--text-dark);
        }

        .classification-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 12px 36px;
            border-radius: 50px;
            font-size: 18px;
            font-weight: 700;
            color: white;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.15);
            transition: transform 0.2s ease;
        }

        .classification-badge:hover {
            transform: scale(1.05);
        }

        .badge-kritis {
            background: #ef4444;
            box-shadow: 0 4px 14px rgba(239, 68, 68, 0.35);
        }

        .badge-tinggi {
            background: #f97316;
            box-shadow: 0 4px 14px rgba(249, 115, 22, 0.35);
        }

        .badge-sedang {
            background: #eab308;
            box-shadow: 0 4px 14px rgba(234, 179, 8, 0.35);
        }

        .badge-rendah {
            background: #10b981;
            box-shadow: 0 4px 14px rgba(16, 185, 129, 0.35);
        }

        /* Back Button */
        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s ease;
            border: 1px solid var(--border);
            background: white;
            color: #475569;
            margin-bottom: 24px;
        }

        .btn-back:hover {
            background: #f1f5f9;
            border-color: #cbd5e1;
            transform: translateX(-2px);
        }

        .btn-back svg {
            width: 16px;
            height: 16px;
        }

        /* Keterangan Klasifikasi Section */
        .keterangan-klasifikasi {
            max-width: 1000px;
            margin: 48px auto 0;
            background: white;
            border-radius: var(--card-radius);
            padding: 28px;
            border: 1px solid var(--border);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
            animation: fadeInUp 0.5s ease forwards;
            animation-delay: 0.4s;
            opacity: 0;
        }

        .keterangan-klasifikasi h3 {
            margin: 0 0 20px 0;
            font-size: 16px;
            font-weight: 600;
            color: var(--text-dark);
        }

        .kriteria-list {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .kriteria-item {
            display: flex;
            align-items: flex-start;
            gap: 14px;
            padding: 16px;
            border-radius: 10px;
            border: 1px solid var(--border);
            background: white;
            transition: all 0.2s ease;
            position: relative;
            overflow: hidden;
        }

        .kriteria-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
        }

        .kriteria-item.level-kritis::before { background: #ef4444; }
        .kriteria-item.level-tinggi::before { background: #f97316; }
        .kriteria-item.level-sedang::before { background: #eab308; }
        .kriteria-item.level-rendah::before { background: #10b981; }

        .kriteria-item:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
            transform: translateY(-1px);
        }

        .kriteria-rank {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 700;
            color: white;
            flex-shrink: 0;
        }

        .kriteria-rank.rank-kritis { background: #ef4444; }
        .kriteria-rank.rank-tinggi { background: #f97316; }
        .kriteria-rank.rank-sedang { background: #eab308; }
        .kriteria-rank.rank-rendah { background: #10b981; }

        .kriteria-content {
            flex: 1;
            min-width: 0;
        }

        .kriteria-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 4px;
        }

        .kriteria-title {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-dark);
        }

        .kriteria-badge {
            display: inline-flex;
            align-items: center;
            padding: 2px 10px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .kriteria-badge.kb-kritis { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }
        .kriteria-badge.kb-tinggi { background: #fff7ed; color: #ea580c; border: 1px solid #fed7aa; }
        .kriteria-badge.kb-sedang { background: #fefce8; color: #a16207; border: 1px solid #fde68a; }
        .kriteria-badge.kb-rendah { background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; }

        .kriteria-meta {
            font-size: 12px;
            color: var(--text-gray);
            margin-bottom: 4px;
        }

        .kriteria-desc {
            font-size: 12px;
            color: #94a3b8;
            line-height: 1.5;
        }

        .kriteria-item { animation: fadeInUp 0.3s ease forwards; opacity: 0; }
        .kriteria-item:nth-child(1) { animation-delay: 0.5s; }
        .kriteria-item:nth-child(2) { animation-delay: 0.6s; }
        .kriteria-item:nth-child(3) { animation-delay: 0.7s; }
        .kriteria-item:nth-child(4) { animation-delay: 0.8s; }

        /* ===== Scoring Analysis Section ===== */
        .scoring-section {
            max-width: 1000px;
            margin: 40px auto 0;
            background: white;
            border-radius: var(--card-radius);
            padding: 28px;
            border: 1px solid var(--border);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
            animation: fadeInUp 0.5s ease forwards;
            animation-delay: 0.35s;
            opacity: 0;
        }

        .scoring-section h3 {
            margin: 0 0 8px 0;
            font-size: 16px;
            font-weight: 600;
            color: var(--text-dark);
        }

        .scoring-section .section-subtitle {
            font-size: 13px;
            color: var(--text-gray);
            margin: 0 0 24px 0;
        }

        .scoring-overview {
            display: flex;
            gap: 32px;
            align-items: flex-start;
            margin-bottom: 28px;
        }

        /* Circular Score */
        .score-circle-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
            flex-shrink: 0;
        }

        .score-circle {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            background: conic-gradient(
                var(--score-color) calc(var(--score-pct) * 1%),
                #f1f5f9 calc(var(--score-pct) * 1%)
            );
        }

        .score-circle-inner {
            width: 92px;
            height: 92px;
            border-radius: 50%;
            background: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .score-circle-value {
            font-size: 28px;
            font-weight: 700;
            color: var(--text-dark);
            line-height: 1;
        }

        .score-circle-max {
            font-size: 11px;
            color: var(--text-gray);
            margin-top: 2px;
        }

        .score-circle-label {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-gray);
        }

        /* Factor Cards */
        .scoring-factors {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .factor-card {
            padding: 16px 20px;
            border-radius: 10px;
            border: 1px solid var(--border);
            background: #fafbfc;
            transition: all 0.2s ease;
        }

        .factor-card:hover {
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            background: white;
        }

        .factor-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
        }

        .factor-name {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-dark);
        }

        .factor-bobot {
            font-size: 11px;
            font-weight: 600;
            color: var(--text-gray);
            background: #f1f5f9;
            padding: 2px 8px;
            border-radius: 20px;
        }

        .factor-result {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 8px;
        }

        .factor-score-badge {
            font-size: 13px;
            font-weight: 700;
            color: white;
            background: var(--factor-color);
            padding: 2px 10px;
            border-radius: 6px;
            white-space: nowrap;
        }

        .factor-label-text {
            font-size: 13px;
            font-weight: 500;
            color: var(--text-dark);
        }

        .factor-progress {
            width: 100%;
            height: 8px;
            background: #e2e8f0;
            border-radius: 4px;
            overflow: hidden;
            margin-bottom: 8px;
        }

        .factor-progress-bar {
            height: 100%;
            border-radius: 4px;
            transition: width 1s ease;
            background: var(--factor-color);
        }

        .factor-desc {
            font-size: 12px;
            color: #94a3b8;
            line-height: 1.5;
        }

        /* Score Range Table */
        .score-range-section {
            margin-top: 24px;
            padding-top: 20px;
            border-top: 1px solid var(--border);
        }

        .score-range-title {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 12px;
        }

        .score-range-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
        }

        .score-range-item {
            padding: 12px;
            border-radius: 8px;
            text-align: center;
            border: 2px solid transparent;
            transition: all 0.2s ease;
        }

        .score-range-item.active {
            border-color: var(--active-border);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            transform: scale(1.03);
        }

        .score-range-item.sr-kritis { background: #fef2f2; }
        .score-range-item.sr-kritis.active { --active-border: #ef4444; }
        .score-range-item.sr-tinggi { background: #fff7ed; }
        .score-range-item.sr-tinggi.active { --active-border: #f97316; }
        .score-range-item.sr-sedang { background: #fefce8; }
        .score-range-item.sr-sedang.active { --active-border: #eab308; }
        .score-range-item.sr-rendah { background: #f0fdf4; }
        .score-range-item.sr-rendah.active { --active-border: #10b981; }

        .score-range-level {
            font-size: 13px;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .sr-kritis .score-range-level { color: #dc2626; }
        .sr-tinggi .score-range-level { color: #ea580c; }
        .sr-sedang .score-range-level { color: #a16207; }
        .sr-rendah .score-range-level { color: #15803d; }

        .score-range-value {
            font-size: 12px;
            color: var(--text-gray);
        }

        /* ===== Reference Detail Section ===== */
        .ref-detail-section {
            margin-top: 24px;
            padding-top: 20px;
            border-top: 1px solid var(--border);
        }

        .ref-detail-title {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 16px;
        }

        .ref-detail-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
        }

        .ref-detail-card {
            background: #fafbfc;
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 16px;
        }

        .ref-detail-card h4 {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-dark);
            margin: 0 0 12px 0;
            padding-bottom: 8px;
            border-bottom: 1px solid var(--border);
        }

        .ref-score-row {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 6px 0;
        }

        .ref-score-row + .ref-score-row {
            border-top: 1px dashed #e8ecf0;
        }

        .ref-score-badge {
            font-size: 11px;
            font-weight: 700;
            color: white;
            padding: 2px 8px;
            border-radius: 5px;
            white-space: nowrap;
            min-width: 32px;
            text-align: center;
        }

        .ref-score-badge.rsb-1 { background: #10b981; }
        .ref-score-badge.rsb-2 { background: #eab308; }
        .ref-score-badge.rsb-3 { background: #f97316; }
        .ref-score-badge.rsb-4 { background: #ef4444; }

        .ref-score-text {
            font-size: 12px;
            color: var(--text-dark);
            line-height: 1.4;
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
                <p>Admin Gunungkidul</p>
            </div>
        </div>

        <ul class="nav-menu">
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="nav-link active">
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
                <a href="{{ route('admin.validasi.index') }}" class="nav-link">
                    <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor">
                        <polyline points="20 6 9 17 4 12" />
                    </svg>
                    Validasi
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.prioritas') }}" class="nav-link">
                    <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor">
                        <polyline points="22 12 18 12 15 21 9 3 6 12 2 12" />
                    </svg>
                    Prioritas
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.tindak_lanjut') }}" class="nav-link">
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
                <a href="{{ route('admin.history') }}" class="nav-link">
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
        <a href="{{ route('admin.dashboard') }}" class="btn-back">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="15 18 9 12 15 6" />
            </svg>
            Kembali ke Dashboard
        </a>

        <div class="page-title">
            <h1>Klasifikasi Tingkat Kekeringan</h1>
            <p>Berdasarkan Laporan yang diterima</p>
        </div>

        <div class="klasifikasi-content">
            <!-- Left: Info Cards -->
            <div class="info-section">
                <!-- Card 1: Pelapor Info -->
                <div class="info-card">
                    <div class="info-row">
                        <span class="info-label">Pelapor:</span>
                        <span class="info-value">{{ $laporan->user->name ?? 'Tidak diketahui' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Tanggal Dibuat:</span>
                        <span class="info-value">{{ $laporan->created_at->format('d/n/Y, H:i.s') }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Terakhir Diupdate:</span>
                        <span class="info-value">{{ $laporan->updated_at->format('d/n/Y, H:i.s') }}</span>
                    </div>
                </div>

                <!-- Card 2: Location & Impact Info -->
                <div class="info-card">
                    <div class="info-row">
                        <span class="info-label">Lokasi:</span>
                        <span class="info-value">Kelurahan {{ $laporan->kelurahan }}, Kecamatan {{ str_replace('Petugas ', '', $laporan->kecamatan) }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Warga Terdampak:</span>
                        <span class="info-value">{{ number_format($laporan->warga_terdampak) }} orang</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Durasi Kekeringan:</span>
                        <span class="info-value">{{ $laporan->durasi_kekeringan }} hari</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Kondisi Air:</span>
                        <span class="info-value">{{ $laporan->kondisi_air }}</span>
                    </div>
                </div>

                <!-- Card 3: Keterangan -->
                <div class="keterangan-card">
                    <div class="keterangan-label">Keterangan :</div>
                    <div class="keterangan-text">{{ $laporan->keterangan ?? 'Tidak ada keterangan.' }}</div>
                </div>
            </div>

            <!-- Right: Classification Result -->
            <div class="classification-section">
                <span class="classification-label">Terdeteksi:</span>
                <div class="classification-badge badge-{{ strtolower($tingkat_kekeringan) }}">
                    {{ $tingkat_kekeringan }}
                </div>
                <div style="font-size: 14px; color: var(--text-gray); margin-top: 8px; font-weight: 500;">
                    Total Skor: <strong style="color: var(--text-dark); font-size: 16px;">{{ $scoring['total_skor'] }}</strong> / 100
                </div>
            </div>
        </div>

        <!-- Analisis Skor Klasifikasi -->
        <div class="scoring-section">
            <h3>Analisis Skor Klasifikasi</h3>
            <p class="section-subtitle">Skor dihitung berdasarkan 3 faktor utama untuk menentukan tingkat kekeringan daerah ini.</p>

            <div class="scoring-overview">
                <!-- Circular Total Score -->
                <div class="score-circle-wrapper">
                    <div class="score-circle" style="--score-pct: {{ $scoring['total_skor'] }}; --score-color: {{ $tingkat_kekeringan === 'Kritis' ? '#ef4444' : ($tingkat_kekeringan === 'Tinggi' ? '#f97316' : ($tingkat_kekeringan === 'Sedang' ? '#eab308' : '#10b981')) }};">
                        <div class="score-circle-inner">
                            <span class="score-circle-value">{{ $scoring['total_skor'] }}</span>
                            <span class="score-circle-max">dari 100</span>
                        </div>
                    </div>
                    <span class="score-circle-label">Total Skor</span>
                </div>

                <!-- Factor Breakdown -->
                <div class="scoring-factors">
                    @foreach($scoring['faktor'] as $index => $faktor)
                        @php
                            if ($faktor['persen'] >= 75) $factorColor = '#ef4444';
                            elseif ($faktor['persen'] >= 50) $factorColor = '#f97316';
                            elseif ($faktor['persen'] >= 25) $factorColor = '#eab308';
                            else $factorColor = '#10b981';
                        @endphp
                        <div class="factor-card" style="--factor-color: {{ $factorColor }};">
                            <div class="factor-header">
                                <span class="factor-name">{{ $index + 1 }}. {{ $faktor['nama'] }}</span>
                                <span class="factor-bobot">Bobot: {{ $faktor['bobot'] }}%</span>
                            </div>
                            <div class="factor-result">
                                <span class="factor-score-badge">{{ $faktor['skor'] }}/{{ $faktor['max_skor'] }}</span>
                                <span class="factor-label-text">{{ $faktor['label'] }}{{ isset($faktor['detail']) ? ' — ' . $faktor['detail'] : '' }}</span>
                            </div>
                            <div class="factor-progress">
                                <div class="factor-progress-bar" style="width: {{ $faktor['persen'] }}%;"></div>
                            </div>
                            <div class="factor-desc">{{ $faktor['deskripsi'] }}</div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Score Range Reference -->
            <div class="score-range-section">
                <div class="score-range-title">Rentang Skor Klasifikasi</div>
                <div class="score-range-grid" style="grid-template-columns: repeat(3, 1fr);">
                    <div class="score-range-item sr-sedang {{ $tingkat_kekeringan === 'Sedang' ? 'active' : '' }}">
                        <div class="score-range-level">Sedang</div>
                        <div class="score-range-value">0 – 49</div>
                    </div>
                    <div class="score-range-item sr-tinggi {{ $tingkat_kekeringan === 'Tinggi' ? 'active' : '' }}">
                        <div class="score-range-level">Tinggi</div>
                        <div class="score-range-value">50 – 74</div>
                    </div>
                    <div class="score-range-item sr-kritis {{ $tingkat_kekeringan === 'Kritis' ? 'active' : '' }}">
                        <div class="score-range-level">Kritis</div>
                        <div class="score-range-value">75 – 100</div>
                    </div>
                </div>
            </div>

            <!-- Reference Detail: Scoring Criteria -->
            <div class="ref-detail-section">
                <div class="ref-detail-title">Rincian Penilaian Skor Per Faktor</div>
                <div class="ref-detail-grid">
                    <!-- Kondisi Air -->
                    <div class="ref-detail-card">
                        <h4>💧 Kondisi Air (Bobot 50%)</h4>
                        <div class="ref-score-row">
                            <span class="ref-score-badge rsb-2">1/3</span>
                            <span class="ref-score-text">Ketersediaan air mulai berkurang</span>
                        </div>
                        <div class="ref-score-row">
                            <span class="ref-score-badge rsb-3">2/3</span>
                            <span class="ref-score-text">Ketersediaan air tidak mencukupi</span>
                        </div>
                        <div class="ref-score-row">
                            <span class="ref-score-badge rsb-4">3/3</span>
                            <span class="ref-score-text">Air tidak tersedia</span>
                        </div>
                    </div>

                    <!-- Durasi Kekeringan -->
                    <div class="ref-detail-card">
                        <h4>⏱️ Durasi Kekeringan (Bobot 30%)</h4>
                        <div class="ref-score-row">
                            <span class="ref-score-badge rsb-2">1/3</span>
                            <span class="ref-score-text">Kurang dari 14 hari</span>
                        </div>
                        <div class="ref-score-row">
                            <span class="ref-score-badge rsb-3">2/3</span>
                            <span class="ref-score-text">14 – 29 hari</span>
                        </div>
                        <div class="ref-score-row">
                            <span class="ref-score-badge rsb-4">3/3</span>
                            <span class="ref-score-text">30 hari atau lebih</span>
                        </div>
                    </div>

                    <!-- Warga Terdampak -->
                    <div class="ref-detail-card">
                        <h4>👥 Warga Terdampak (Bobot 20%)</h4>
                        <div class="ref-score-row">
                            <span class="ref-score-badge rsb-2">1/3</span>
                            <span class="ref-score-text">Kurang dari 100 orang</span>
                        </div>
                        <div class="ref-score-row">
                            <span class="ref-score-badge rsb-3">2/3</span>
                            <span class="ref-score-text">100 – 199 orang</span>
                        </div>
                        <div class="ref-score-row">
                            <span class="ref-score-badge rsb-4">3/3</span>
                            <span class="ref-score-text">200 orang atau lebih</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>

</body>

</html>
