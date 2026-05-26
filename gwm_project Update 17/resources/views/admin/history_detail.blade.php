<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GWM - Detail Log Aktivitas</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-color: #f3f7fb;
            --sidebar-bg: #ffffff;
            --text-dark: #0f172a;
            --text-gray: #64748b;
            --border: #e2e8f0;
            --card-radius: 16px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
            background: var(--bg-color);
            color: var(--text-dark);
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 260px;
            background: var(--sidebar-bg);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            padding: 20px;
        }

        .profile-card {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px;
            background: #eff6ff;
            border-radius: 10px;
            margin-bottom: 32px;
        }

        .profile-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: #3b82f6;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .profile-info h4 {
            margin: 0;
            font-size: 14px;
        }

        .profile-info p {
            margin: 0;
            color: #64748b;
            font-size: 12px;
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
            text-decoration: none;
            color: #475569;
            padding: 10px 12px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
        }

        .nav-link:hover {
            background: #f1f5f9;
        }

        .nav-link.active {
            background: #eff6ff;
            color: #2563eb;
        }

        .nav-icon {
            width: 18px;
            height: 18px;
        }

        .nav-bottom {
            margin-top: auto;
        }

        .main-content {
            flex: 1;
            padding: 40px;
            overflow-y: auto;
        }

        .page-header {
            margin-bottom: 24px;
        }

        .page-header h1 {
            margin: 0;
            font-size: 28px;
        }

        .page-header p {
            margin-top: 6px;
            color: var(--text-gray);
        }

        .detail-card {
            background: white;
            border-radius: var(--card-radius);
            border: 1px solid var(--border);
            padding: 28px;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.04);
        }

        .detail-grid {
            display: grid;
            grid-template-columns: 1.1fr 0.9fr;
            gap: 24px;
            margin-top: 24px;
        }

        .detail-section {
            display: flex;
            flex-direction: column;
            gap: 18px;
        }

        .detail-item {
            display: grid;
            grid-template-columns: 130px 1fr;
            gap: 12px;
            font-size: 14px;
            color: var(--text-gray);
        }

        .detail-item strong {
            color: var(--text-dark);
            font-weight: 600;
        }

        .detail-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            justify-content: space-between;
            padding: 10px 14px;
            background: #f8fafc;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            font-size: 14px;
            color: #475569;
        }

        .status-pill {
            display: inline-flex;
            padding: 6px 14px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
            text-transform: capitalize;
        }

        .status-pill.menunggu_validasi { background: #eff6ff; color: #2563eb; }
        .status-pill.proses { background: #fff7ed; color: #ea580c; }
        .status-pill.selesai { background: #dcfce7; color: #15803d; }
        .status-pill.ditolak { background: #fee2e2; color: #b91c1c; }

        .badge {
            display: inline-flex;
            padding: 6px 14px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .badge.sedang { background: #fefce8; color: #a16207; }
        .badge.tinggi { background: #fff7ed; color: #ea580c; }
        .badge.kritis { background: #fee2e2; color: #b91c1c; }

        .detail-divider {
            height: 1px;
            background: #e2e8f0;
            border: none;
            margin: 24px 0;
        }

        .photo-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px;
        }

        .photo-grid img {
            width: 100%;
            border-radius: 14px;
            object-fit: cover;
            min-height: 140px;
        }

        .tindak-list {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .tindak-card {
            background: #f8fafc;
            border-radius: 14px;
            padding: 18px;
            border: 1px solid #e2e8f0;
        }

        .tindak-card h4 {
            margin: 0 0 10px 0;
            font-size: 15px;
            color: var(--text-dark);
        }

        .btn-back,
        .btn-detail {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 10px 18px;
            border-radius: 10px;
            border: 1px solid transparent;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
        }

        .btn-back {
            background: #ffffff;
            color: #334155;
            border-color: #cbd5e1;
        }

        .btn-detail {
            background: #2563eb;
            color: #ffffff;
        }

        .tag-list {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 10px;
        }

        .tag {
            background: #eef2ff;
            color: #3730a3;
            padding: 6px 12px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 600;
        }
    </style>
</head>

<body>
    @include('admin.sidebar')

    <main class="main-content">
        <div class="page-header">
            <h1>Detail Log Aktivitas</h1>
            <p>Informasi lengkap laporan dan tindak lanjut terkait.</p>
        </div>

        <a href="{{ route('admin.history') }}" class="btn-back">Kembali ke History</a>

        <section class="detail-card">
            <div class="detail-grid">
                <div class="detail-section">
                    <div class="detail-item">
                        <strong>Kode</strong>
                        <span>{{ $laporan->kode }}</span>
                    </div>
                    <div class="detail-item">
                        <strong>Kelurahan</strong>
                        <span>{{ $laporan->kelurahan }}</span>
                    </div>
                    <div class="detail-item">
                        <strong>Kecamatan</strong>
                        <span>{{ $laporan->kecamatan }}</span>
                    </div>
                    <div class="detail-item">
                        <strong>Status</strong>
                        <span>{{ ucfirst(str_replace('_', ' ', $laporan->status)) }}</span>
                    </div>
                    <div class="detail-item">
                        <strong>Tingkat</strong>
                        <span><span class="badge {{ strtolower($laporan->tingkat_kekeringan) }}">{{ $laporan->tingkat_kekeringan }}</span></span>
                    </div>
                    <div class="detail-item">
                        <strong>Skor</strong>
                        <span>{{ number_format($laporan->skor_prioritas, 2) }}</span>
                    </div>
                    <div class="detail-item">
                        <strong>Tanggal Laporan</strong>
                        <span>{{ $laporan->created_at->format('d M Y') }}</span>
                    </div>
                    <div class="detail-item">
                        <strong>Kondisi Air</strong>
                        <span>{{ $laporan->kondisi_air }}</span>
                    </div>
                    <div class="detail-item">
                        <strong>Warga Terdampak</strong>
                        <span>{{ $laporan->warga_terdampak }}</span>
                    </div>
                    <div class="detail-item">
                        <strong>Durasi Kekeringan</strong>
                        <span>{{ $laporan->durasi_kekeringan }}</span>
                    </div>
                    <div class="detail-item">
                        <strong>Keterangan</strong>
                        <span>{{ $laporan->keterangan }}</span>
                    </div>
                </div>

                <div class="detail-section">
                    <div class="detail-badge">Informasi Tambahan</div>
                    <div class="tag-list">
                        <span class="tag">{{ $laporan->user->name ?? 'Petugas' }}</span>
                        <span class="tag">{{ ucfirst(str_replace('_', ' ', $laporan->status)) }}</span>
                        <span class="tag">{{ $laporan->created_at->format('H:i') }}</span>
                    </div>
                    @php
                        $photos = json_decode($laporan->foto, true) ?: [];
                    @endphp
                    @if(count($photos))
                        <div class="photo-grid">
                            @foreach($photos as $photo)
                                <img src="{{ asset($photo) }}" alt="Foto laporan">
                            @endforeach
                        </div>
                    @else
                        <p style="margin-top:18px;color:#475569;font-size:14px;">Tidak ada foto laporan.</p>
                    @endif
                </div>
            </div>

            <hr class="detail-divider">

            <div>
                <h2 style="margin:0 0 18px 0;font-size:18px;color:var(--text-dark);">Riwayat Tindak Lanjut</h2>
                @if($laporan->tindakLanjuts->isNotEmpty())
                    <div class="tindak-list">
                        @foreach($laporan->tindakLanjuts->sortByDesc('tanggal') as $item)
                            <div class="tindak-card">
                                <h4>{{ $item->status }}</h4>
                                <p style="margin:0 0 8px 0;color:var(--text-dark);"><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</p>
                                <p style="margin:0 0 10px 0;">{{ $item->deskripsi_aksi }}</p>
                                @if(!empty($item->deskripsi_selesai))
                                    <p style="margin:0;font-size:13px;color:#475569;"><strong>Catatan selesai:</strong> {{ $item->deskripsi_selesai }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <p style="margin:0;color:#475569;">Belum ada tindak lanjut untuk laporan ini.</p>
                @endif
            </div>
        </section>
    </main>
</body>

</html>
