<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GWM - Manajemen Tindak Lanjut</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        :root { --bg-color: #f8fafc; --sidebar-bg: #ffffff; --text-dark: #0f172a; --text-gray: #64748b; --primary: #3b82f6; --border: #e2e8f0; --card-radius: 12px; }
        body { margin: 0; padding: 0; font-family: 'Inter', sans-serif; background: var(--bg-color); color: var(--text-dark); display: flex; min-height: 100vh; }
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

        .main-content {
            flex: 1;
            padding: 40px;
            overflow-y: auto;
        }
        .page-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 32px; }
        .page-header h1 { margin: 0; font-size: 28px; font-weight: 700; }
        .page-header p { margin: 4px 0 0; color: var(--text-gray); }
        .btn-add { background: #3b82f6; color: white; padding: 10px 20px; border-radius: 8px; border: none; font-weight: 600; font-size: 14px; cursor: pointer; display: flex; align-items: center; gap: 8px; }
        .card { background: white; border-radius: var(--card-radius); border: 1px solid var(--border); overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
        table { width: 100%; border-collapse: collapse; }
        th { background: #f8fafc; padding: 18px 24px; font-size: 12px; font-weight: 800; color: #475569; text-transform: uppercase; letter-spacing: 0.05em; border-bottom: 1px solid var(--border); }
        td { padding: 20px 24px; border-bottom: 1px solid var(--border); font-size: 14px; vertical-align: middle; }
        
        .col-left { text-align: left; }
        .col-center { text-align: center; }
        
        .description-text { 
            color: #475569; 
            font-weight: 500; 
            line-height: 1.6;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 400px;
        }

        .location-info { font-weight: 700; font-size: 14px; color: var(--text-dark); }
        .location-sub { font-size: 12px; color: var(--text-gray); margin-top: 2px; }
        .id-badge { color: #94a3b8; font-size: 11px; margin-top: 2px; font-weight: 600; }
        .priority-badge { display: inline-flex; padding: 4px 14px; border-radius: 20px; font-size: 11px; font-weight: 700; color: #ef4444; background: #fef2f2; border: 1px solid #fecaca; min-width: 85px; justify-content: center; }
        .priority-tinggi { color: #ea580c; background: #fff7ed; border-color: #fed7aa; }
        .priority-sedang { color: #a16207; background: #fefce8; border-color: #fde68a; }
        
        .status-select { padding: 7px 14px; border-radius: 8px; border: 1px solid #f9a8d4; background: #fdf2f8; color: #9d174d; font-weight: 700; font-size: 12px; outline: none; cursor: pointer; appearance: none; background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%239d174d' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e"); background-repeat: no-repeat; background-position: right 10px center; background-size: 10px; padding-right: 32px; transition: all 0.2s; }
        .status-selesai { background: #dcfce7; border-color: #bbf7d0; color: #15803d; }
        .status-select:hover { border-color: #f472b6; }
        .status-selesai:hover { border-color: #86efac; }
        
        .status-badge-finished { background-image: none !important; padding-right: 14px !important; display: inline-flex; align-items: center; justify-content: center; min-width: 120px; gap: 6px; }
        
        .btn-delete { background: none; border: none; color: #cbd5e1; cursor: pointer; padding: 10px; border-radius: 10px; transition: all 0.2s; display: inline-flex; align-items: center; justify-content: center; }
        .btn-delete:hover { background: #fef2f2; color: #ef4444; transform: scale(1.1); }
        .btn-delete svg { pointer-events: none; }
        
        .btn-locked { background: none; border: none; color: #94a3b8; cursor: not-allowed; padding: 10px; border-radius: 10px; transition: all 0.2s; display: inline-flex; align-items: center; justify-content: center; }
        .btn-locked:hover { background: #f1f5f9; transform: scale(1.1); }
        .btn-locked svg { pointer-events: none; }
        
        .modal { display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); backdrop-filter: blur(4px); align-items: center; justify-content: center; }
        .modal-content { background: white; padding: 32px; border-radius: 20px; width: 550px; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.15); animation: modalIn 0.3s ease-out; }
        @keyframes modalIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        
        .modal-header h2 { font-size: 20px; color: var(--text-dark); margin: 0; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; font-size: 14px; font-weight: 700; color: #475569; margin-bottom: 8px; }
        .form-control { width: 100%; padding: 12px 16px; border-radius: 12px; border: 1.5px solid #e2e8f0; font-family: inherit; font-size: 14px; color: var(--text-dark); transition: all 0.2s; box-sizing: border-box; }
        .form-control:focus { outline: none; border-color: #3b82f6; box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1); }
        textarea.form-control { resize: vertical; min-height: 100px; }
        
        .modal-footer { display: flex; gap: 12px; margin-top: 24px; }
        .btn-submit { flex: 1; background: #2563eb; color: white; padding: 12px; border-radius: 12px; border: none; font-weight: 700; font-size: 14px; cursor: pointer; transition: all 0.2s; }
        .btn-submit:hover { background: #1d4ed8; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2); }
        .btn-cancel { flex: 1; background: #f1f5f9; color: #475569; padding: 12px; border-radius: 12px; border: none; font-weight: 700; font-size: 14px; cursor: pointer; transition: all 0.2s; text-align: center; text-decoration: none; }
        .btn-cancel:hover { background: #e2e8f0; color: #1e293b; }

        /* Filter Bar */
        .filter-section { background: white; border-radius: var(--card-radius); padding: 24px; border: 1px solid var(--border); margin-bottom: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
        .filter-form { display: flex; flex-direction: column; gap: 20px; }
        .search-row { width: 100%; }
        .filter-row { display: grid; grid-template-columns: 1fr 1fr 1fr auto; gap: 16px; align-items: flex-end; padding-top: 16px; border-top: 1px dashed var(--border); }
        
        .search-group { position: relative; }
        .search-input { width: 100%; padding: 14px 16px 14px 44px; border-radius: 12px; border: 1.5px solid #e2e8f0; font-size: 15px; transition: all 0.2s; box-sizing: border-box; background: #f8fafc; }
        .search-input:focus { border-color: #3b82f6; outline: none; background: #fff; box-shadow: 0 4px 12px rgba(59, 130, 246, 0.08); }
        .search-icon { position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: #94a3b8; }
        
        .filter-label { display: block; font-size: 11px; font-weight: 800; color: #64748b; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.05em; }
        .filter-select { width: 100%; padding: 10px 14px; border-radius: 10px; border: 1.5px solid #e2e8f0; font-size: 14px; color: var(--text-dark); outline: none; transition: all 0.2s; cursor: pointer; background: #fff; }
        .filter-select:focus { border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.05); }
        
        .btn-reset { padding: 10px 20px; border-radius: 10px; background: #f1f5f9; color: #475569; text-decoration: none; font-size: 13px; font-weight: 700; transition: all 0.2s; white-space: nowrap; border: 1px solid #e2e8f0; display: inline-flex; align-items: center; justify-content: center; height: 41px; }
        .btn-reset:hover { background: #e2e8f0; color: #1e293b; }
    </style>
</head>
<body>
    @include('admin.sidebar')

    <main class="main-content">
        @if(session('success'))
            <div style="background:#dcfce7; color:#166534; padding:16px; border-radius:8px; margin-bottom:24px; border:1px solid #bbf7d0; display: flex; align-items: center; gap: 8px;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div style="background:#fef2f2; color:#991b1b; padding:16px; border-radius:8px; margin-bottom:24px; border:1px solid #fecaca; display: flex; align-items: center; gap: 8px;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                {{ session('error') }}
            </div>
        @endif
        <div class="page-header">
            <div>
                <h1>Manajemen Tindak Lanjut</h1>
                <p>Kelola aksi penanganan untuk setiap laporan</p>
            </div>
            <button class="btn-add" onclick="document.getElementById('addModal').style.display='flex'"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg> Tambah Tindak Lanjut</button>
        </div>

        <!-- Filter & Search Section -->
        <div class="filter-section">
            <form action="{{ route('admin.tindak_lanjut') }}" method="GET" class="filter-form" id="filterForm">
                <!-- Top Row: Main Search -->
                <div class="search-row">
                    <div class="search-group">
                        <label class="filter-label">Pencarian Laporan</label>
                        <div style="position:relative;">
                            <svg class="search-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                            <input type="text" name="search" class="search-input" placeholder="Cari berdasarkan Kelurahan, Kecamatan, Kode Laporan, atau status..." value="{{ request('search') }}">
                        </div>
                    </div>
                </div>

                <!-- Bottom Row: Multi Filters -->
                <div class="filter-row">
                    <div>
                        <label class="filter-label">Wilayah Kecamatan</label>
                        <select name="kecamatan" class="filter-select">
                            <option value="">Semua Kecamatan</option>
                            @foreach($kecamatans as $kec)
                                <option value="{{ $kec }}" {{ request('kecamatan') == $kec ? 'selected' : '' }}>{{ $kec }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="filter-label">Tingkat Prioritas</label>
                        <select name="prioritas" class="filter-select">
                            <option value="">Semua Prioritas</option>
                            <option value="Kritis" {{ request('prioritas') == 'Kritis' ? 'selected' : '' }}>Kritis</option>
                            <option value="Tinggi" {{ request('prioritas') == 'Tinggi' ? 'selected' : '' }}>Tinggi</option>
                            <option value="Sedang" {{ request('prioritas') == 'Sedang' ? 'selected' : '' }}>Sedang</option>
                        </select>
                    </div>
                    <div>
                        <label class="filter-label">Status Tindak Lanjut</label>
                        <select name="status" class="filter-select">
                            <option value="">Semua Status</option>
                            <option value="Dalam proses" {{ request('status') == 'Dalam proses' ? 'selected' : '' }}>Dalam proses</option>
                            <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                    </div>
                    <div>
                        @if(request()->anyFilled(['search', 'kecamatan', 'prioritas', 'status']))
                            <a href="{{ route('admin.tindak_lanjut') }}" class="btn-reset">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="margin-right:6px;"><path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><path d="M3 3v5h5"/></svg>
                                Reset Filter
                            </a>
                        @else
                            <button type="submit" class="btn-reset" style="background:#3b82f6; color:white; border-color:#3b82f6;">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="margin-right:6px;"><polyline points="20 6 9 17 4 12"/></svg>
                                Terapkan
                            </button>
                        @endif
                    </div>
                </div>
            </form>
        </div>

        <div class="card">
            @if($tindakLanjuts->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th class="col-left" style="width: 200px;">LOKASI</th>
                        <th class="col-center" style="width: 120px;">PRIORITAS</th>
                        <th class="col-left">DESKRIPSI AKSI</th>
                        <th class="col-center" style="width: 150px;">TANGGAL</th>
                        <th class="col-center" style="width: 180px;">STATUS</th>
                        <th class="col-center" style="width: 80px;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tindakLanjuts as $tl)
                    <tr>
                        <td class="col-left">
                            <div class="location-info">Kec. {{ str_replace('Petugas ', '', $tl->laporan->kecamatan) }}</div>
                            <div class="location-sub">Kelurahan {{ $tl->laporan->kelurahan }}</div>
                            <div class="id-badge">ID: {{ $tl->laporan->kode }}</div>
                        </td>
                        <td class="col-center">
                            <span class="priority-badge {{ $tl->laporan->tingkat_prioritas == 'Tinggi' ? 'priority-tinggi' : ($tl->laporan->tingkat_prioritas == 'Sedang' ? 'priority-sedang' : '') }}">
                                {{ $tl->laporan->tingkat_prioritas }}
                            </span>
                        </td>
                        <td class="col-left">
                            <div class="description-text">{{ $tl->deskripsi_aksi }}</div>
                        </td>
                        <td class="col-center">
                            <div style="color: #64748b; font-weight: 600; display: inline-flex; align-items: center; gap: 6px;">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                {{ \Carbon\Carbon::parse($tl->tanggal)->format('d M Y') }}
                            </div>
                        </td>
                        <td class="col-center">
                        @if($tl->status == 'Selesai')
                        <div onclick="showLockedMessage()" style="cursor: not-allowed; display: inline-block;">
                            <select class="status-select status-selesai status-locked" disabled style="pointer-events: none;">
                                <option value="Selesai" selected>Selesai</option>
                            </select>
                        </div>
                        @else
                        <form action="{{ route('admin.tindak_lanjut.status', $tl->id) }}" method="POST">
                            @csrf
                            <select name="status" class="status-select" onchange="this.form.submit()">
                                <option value="Dalam proses" {{ $tl->status == 'Dalam proses' ? 'selected' : '' }}>Dalam proses</option>
                                <option value="Selesai" {{ $tl->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                            </select>
                        </form>
                        @endif
                        </td>
                        <td class="col-center">
                            <div style="display: flex; gap: 4px; justify-content: center;">
                                @if($tl->status == 'Selesai')
                                    <button type="button" class="btn-locked" onclick="showLockedMessage()" title="Data Terkunci">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                                    </button>
                                @else
                                    <button type="button" class="btn-delete" style="color: #6366f1;" onclick='openEditModal("{{ $tl->id }}", {!! json_encode($tl->deskripsi_aksi) !!}, {!! json_encode($tl->deskripsi_selesai) !!}, "{{ $tl->status }}")' title="Edit Aksi">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                    </button>
                                    <form action="{{ route('admin.tindak_lanjut.destroy', $tl->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus aksi ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-delete" title="Hapus Aksi">
                                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div style="text-align:center; padding:100px 40px; color:var(--text-gray);">
                <div style="background:#f1f5f9; width:64px; height:64px; border-radius:16px; display:flex; align-items:center; justify-content:center; margin:0 auto 20px;">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#cbd5e1" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                </div>
                <h3 style="margin:0 0 8px; color:var(--text-dark); font-size:20px; font-weight:700;">Belum Ada Tindak Lanjut</h3>
                <p style="margin:0; font-size:14px; max-width:400px; margin:0 auto; line-height:1.6; color:#64748b;">Klik tombol "Tambah Tindak Lanjut" untuk membuat aksi penanganan baru bagi laporan yang tervalidasi.</p>
            </div>
            @endif
        </div>
    </main>

    <div id="addModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Tambah Aksi Penanganan</h2>
                <p>Pilih laporan tervalidasi dan tentukan aksinya</p>
            </div>
            <form action="{{ route('admin.tindak_lanjut.store') }}" method="POST" id="addForm" onsubmit="return validateDate(event)">
                @csrf
                <div class="form-group">
                    <label>Pilih Laporan</label>
                    <select name="laporan_id" class="form-control" required>
                        <option value="">-- Pilih Laporan --</option>
                        @foreach($laporansReady as $lap)
                        <option value="{{ $lap->id }}">{{ $lap->kode }} - {{ $lap->kelurahan }} ({{ $lap->tingkat_prioritas }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Deskripsi Aksi (Saat Proses)</label>
                    <textarea name="deskripsi_aksi" class="form-control" rows="2" placeholder="Contoh: Distribusi air bersih 5000 tangki" required></textarea>
                </div>
                <div class="form-group">
                    <label>Deskripsi Aksi (Saat Selesai - Opsional)</label>
                    <textarea name="deskripsi_selesai" class="form-control" rows="2" placeholder="Contoh: Air telah didistribusikan ke seluruh warga Kelurahan Planjan"></textarea>
                </div>
                <div class="form-group">
                    <label>Tanggal Pelaksanaan</label>
                    <input type="date" name="tanggal" id="tanggal_pelaksanaan" class="form-control" value="{{ date('Y-m-d') }}" required>
                </div>
                <div class="form-group">
                    <label>Status Awal</label>
                    <select name="status" class="form-control" required>
                        <option value="Dalam proses">Dalam proses</option>
                        <option value="Selesai">Selesai</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn-submit">Simpan Aksi</button>
                    <button type="button" class="btn-cancel" onclick="document.getElementById('addModal').style.display='none'">Batal</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Edit Aksi Penanganan</h2>
                <p>Perbarui detail aksi penanganan laporan</p>
            </div>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label>Deskripsi Aksi (Saat Proses)</label>
                    <textarea name="deskripsi_aksi" id="edit_deskripsi_aksi" class="form-control" rows="2" required></textarea>
                </div>
                <div class="form-group">
                    <label>Deskripsi Aksi (Saat Selesai)</label>
                    <textarea name="deskripsi_selesai" id="edit_deskripsi_selesai" class="form-control" rows="2"></textarea>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select name="status" id="edit_status" class="form-control" required>
                        <option value="Dalam proses">Dalam proses</option>
                        <option value="Selesai">Selesai</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn-submit">Update Aksi</button>
                    <button type="button" class="btn-cancel" onclick="document.getElementById('editModal').style.display='none'">Batal</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Polyfill untuk mendukung klik pada elemen SVG (khusus untuk testing otomatis seperti Selenium/Katalon/Playwright)
        if (window.SVGElement && !SVGElement.prototype.click) {
            SVGElement.prototype.click = function() {
                var ev = new MouseEvent('click', {
                    view: window,
                    bubbles: true,
                    cancelable: true
                });
                this.dispatchEvent(ev);
            };
        }

        function openEditModal(id, deskripsi, deskripsiSelesai, status) {
            const form = document.getElementById('editForm');
            form.action = `/admin/tindak-lanjut/${id}`;
            
            document.getElementById('edit_deskripsi_aksi').value = deskripsi;
            document.getElementById('edit_deskripsi_selesai').value = deskripsiSelesai;
            document.getElementById('edit_status').value = status;
            
            document.getElementById('editModal').style.display = 'flex';
        }

        function showLockedMessage() {
            alert('Mohon maaf, tindak lanjut yang telah berstatus Selesai bersifat permanen dan tidak dapat diubah kembali untuk menjaga validitas riwayat data.');
        }

        function validateDate(event) {
            const dateInput = document.getElementById('tanggal_pelaksanaan').value;
            const selectedDate = new Date(dateInput);
            selectedDate.setHours(0,0,0,0);
            const today = new Date();
            today.setHours(0,0,0,0);
            
            if (selectedDate < today) {
                event.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Tanggal Tidak Valid',
                    text: 'Tanggal pelaksanaan tidak boleh kurang dari hari ini!',
                    confirmButtonColor: '#3b82f6'
                });
                return false;
            }
            return true;
        }
    </script>
</body>
</html>
