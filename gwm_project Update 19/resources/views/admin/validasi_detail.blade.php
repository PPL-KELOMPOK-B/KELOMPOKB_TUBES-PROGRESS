<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GWM - Detail Validasi Laporan</title>
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
            position: relative;
        }

        .document-container {
            background: white;
            border-radius: 12px;
            padding: 48px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.03);
            max-width: 800px;
            margin: 0 auto;
        }

        .doc-header {
            text-align: center;
            margin-bottom: 32px;
            padding-bottom: 24px;
            border-bottom: 1px solid #e2e8f0;
        }

        .doc-title {
            font-size: 18px;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 4px;
            letter-spacing: 0.5px;
        }

        .doc-subtitle {
            font-size: 13px;
            color: var(--text-gray);
            margin-bottom: 12px;
        }

        .doc-meta {
            font-size: 12px;
            color: var(--text-gray);
        }

        .section-title {
            font-size: 14px;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 16px;
            padding-bottom: 8px;
            border-bottom: 1px solid #f1f5f9;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 200px 1fr;
            gap: 12px;
            font-size: 13px;
            margin-bottom: 32px;
        }

        .info-label {
            color: var(--text-gray);
        }

        .info-value {
            font-weight: 600;
            color: var(--text-dark);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .badge-kritis {
            display: inline-block;
            padding: 4px 12px;
            background: #fee2e2;
            color: #ef4444;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
        }

        .doc-text {
            font-size: 13px;
            line-height: 1.6;
            color: var(--text-gray);
            margin-bottom: 32px;
        }

        .photo-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin-bottom: 48px;
        }

        .photo-card {
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 8px;
            text-align: center;
        }

        .photo-img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 4px;
            margin-bottom: 8px;
        }

        .photo-caption {
            font-size: 11px;
            color: var(--text-gray);
        }

        .doc-footer {
            text-align: center;
            color: #94a3b8;
            font-size: 11px;
            line-height: 1.6;
            padding-top: 24px;
            border-top: 1px solid #e2e8f0;
        }

        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--text-dark);
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 24px;
        }
    </style>
</head>

<body>

    <!-- Sidebar -->
    @include('admin.sidebar')

    <!-- Main Content -->
    <main class="main-content">
        <a href="{{ route('admin.validasi.index') }}" class="btn-back">
            <svg width="18" height="18" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            Kembali
        </a>

        <div class="document-container">
            <div class="doc-header">
                <h2 class="doc-title">LAPORAN KONDISI KEKERINGAN</h2>
                <p class="doc-subtitle">Gunungkidul Water Monitor (GWM)</p>
                <div class="doc-meta">
                    Tanggal: {{ $laporan->created_at->format('d F Y') }} <span style="margin: 0 8px; color: #cbd5e1;">|</span> Kecamatan: {{ str_replace('Petugas ', '', $laporan->kecamatan ?? 'Purwosari') }}
                </div>
            </div>

            <h3 class="section-title">1. Informasi Wilayah</h3>
            <div class="info-grid">
                <div class="info-label">Kecamatan</div>
                <div class="info-value">: {{ str_replace('Petugas ', '', $laporan->kecamatan ?? 'Purwosari') }}</div>
                <div class="info-label">Kelurahan</div>
                <div class="info-value">: {{ $laporan->kelurahan ?? '-' }}</div>
            </div>

            <h3 class="section-title">2. Kondisi Kekeringan</h3>
            <div class="info-grid">
                <div class="info-label">Kondisi Air</div>
                <div class="info-value">
                    : <span class="badge-kritis">{{ $laporan->kondisi_air ?? 'Kritis' }}</span>
                </div>
                <div class="info-label">Warga Terdampak</div>
                <div class="info-value">: {{ $laporan->warga_terdampak ?? 0 }} jiwa</div>
                <div class="info-label">Durasi</div>
                <div class="info-value">: {{ $laporan->durasi_kekeringan ?? 0 }} hari</div>
            </div>

            <h3 class="section-title">3. Deskripsi Kondisi</h3>
            <div class="doc-text">
                {{ $laporan->keterangan ?? '-' }}
            </div>

            <h3 class="section-title">4. Dokumentasi</h3>
            <div class="photo-grid">
                @if($laporan->foto)
                    @php
                        $fotosArray = json_decode($laporan->foto, true);
                        if (!is_array($fotosArray)) {
                            $fotosArray = [$laporan->foto];
                        }
                    @endphp

                    @foreach($fotosArray as $index => $foto)
                        <div class="photo-card">
                            <img src="{{ Storage::url($foto) }}" alt="Dokumentasi {{ $index + 1 }}" class="photo-img" onerror="this.src='https://placehold.co/400x300?text=Foto+Tidak+Ditemukan'">
                            <div class="photo-caption">Foto {{ $index + 1 }}</div>
                        </div>
                    @endforeach
                @else
                    <div style="grid-column: 1 / -1; color: var(--text-gray); font-size: 13px; text-align: center; padding: 20px;">
                        Tidak ada dokumentasi foto.
                    </div>
                @endif
            </div>

            <div class="doc-footer">
                Laporan ini dibuat melalui sistem GWM (Gunungkidul Water Monitor)<br>
                Periksa kembali data sebelum mengirim laporan
            </div>
        </div>
    </main>
</body>

</html>
