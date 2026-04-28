<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GWM - Edit Laporan</title>
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

        .card {
            background: var(--bg-card);
            border-radius: var(--radius-lg);
            padding: 24px;
            box-shadow: var(--shadow-md);
        }

        .card-header {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 24px;
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
                    <strong>Kecamatan {{ str_replace('Petugas ', '', auth()->user()->name) }}</strong>
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
                <a href="{{ route('petugas.laporan.index') }}" class="active">
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
        <div style="margin-bottom: 24px;">
            <a href="{{ route('petugas.laporan.index') }}" style="display: inline-flex; align-items: center; gap: 8px; color: var(--text-dark); text-decoration: none; font-size: 14px; font-weight: 600;">
                <svg width="18" height="18" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                Kembali
            </a>
        </div>
        
        <div class="page-title" style="margin-bottom: 32px;">
            <h1 style="font-size: 24px; color: var(--text-dark);">Edit Laporan #R{{ str_pad($laporan->id, 3, '0', STR_PAD_LEFT) }}</h1>
            <p style="font-size: 14px; color: var(--text-gray); margin-top: 4px;">Perbarui data laporan kondisi air di desa Anda</p>
        </div>

        <form action="{{ route('petugas.update_laporan_list', $laporan->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <!-- Lokasi Section -->
            <div class="card" style="margin-bottom: 24px;">
                <div class="card-header" style="margin-bottom: 16px;">
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:var(--text-dark);"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                        <h3 style="font-size: 15px; font-weight: 600; color:var(--text-dark);">Lokasi</h3>
                    </div>
                </div>
                
                <div style="display: grid; gap: 20px;">
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 500; color: var(--text-dark); margin-bottom: 8px;">Kecamatan</label>
                        <input type="text" name="kecamatan" readonly value="{{ $laporan->kecamatan }}" style="width: 100%; padding: 12px 16px; border-radius: 8px; border: 1px solid var(--border); background-color: #f8fafc; color: var(--text-gray); font-family: inherit; font-size: 14px; outline: none;">
                    </div>
                    
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; color: var(--text-dark); margin-bottom: 8px;">Kelurahan</label>
                        <select name="kelurahan" required style="width: 100%; padding: 12px 16px; border-radius: 8px; border: 1px solid {{ $errors->has('kelurahan') ? '#ef4444' : '#cbd5e1' }}; background-color: white; color: var(--text-dark); font-family: inherit; font-size: 14px; outline: none; appearance: none; cursor: pointer; background-image: url('data:image/svg+xml;utf8,<svg fill=%22none%22 stroke=%22currentColor%22 viewBox=%220 0 24 24%22 xmlns=%22http://www.w3.org/2000/svg%22><path stroke-linecap=%22round%22 stroke-linejoin=%22round%22 stroke-width=%222%22 d=%22M19 9l-7 7-7-7%22></path></svg>'); background-repeat: no-repeat; background-position: right 16px center; background-size: 16px;">
                            <option value="">Pilih Kelurahan</option>
                            @foreach($kelurahans as $k)
                                @if(trim($k) != '')
                                    <option value="{{ trim($k) }}" {{ $laporan->kelurahan == trim($k) || old('kelurahan') == trim($k) ? 'selected' : '' }}>{{ trim($k) }}</option>
                                @endif
                            @endforeach
                        </select>
                        @error('kelurahan')
                            <span style="font-size: 12px; color: #ef4444; display: block; margin-top: 6px;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Kondisi Air Section -->
            <div class="card" style="margin-bottom: 24px;">
                <div class="card-header" style="margin-bottom: 16px;">
                    <h3 style="font-size: 15px; font-weight: 600; color:var(--text-dark);">Kondisi Air</h3>
                </div>
                
                <div style="display: grid; gap: 20px;">
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; color: var(--text-dark); margin-bottom: 8px;">Kondisi Ketersediaan Air</label>
                        <select name="kondisi_air" required style="width: 100%; padding: 12px 16px; border-radius: 8px; border: 1px solid {{ $errors->has('kondisi_air') ? '#ef4444' : '#cbd5e1' }}; background-color: white; color: var(--text-dark); font-family: inherit; font-size: 14px; outline: none; appearance: none; cursor: pointer; background-image: url('data:image/svg+xml;utf8,<svg fill=%22none%22 stroke=%22currentColor%22 viewBox=%220 0 24 24%22 xmlns=%22http://www.w3.org/2000/svg%22><path stroke-linecap=%22round%22 stroke-linejoin=%22round%22 stroke-width=%222%22 d=%22M19 9l-7 7-7-7%22></path></svg>'); background-repeat: no-repeat; background-position: right 16px center; background-size: 16px;">
                            <option value="">Pilih kondisi air</option>
                            <option value="Ketersediaan air mulai berkurang" {{ $laporan->kondisi_air == 'Ketersediaan air mulai berkurang' || old('kondisi_air') == 'Ketersediaan air mulai berkurang' ? 'selected' : '' }}>Ketersediaan air mulai berkurang</option>
                            <option value="Ketersediaan air tidak mencukupi" {{ $laporan->kondisi_air == 'Ketersediaan air tidak mencukupi' || old('kondisi_air') == 'Ketersediaan air tidak mencukupi' ? 'selected' : '' }}>Ketersediaan air tidak mencukupi</option>
                            <option value="Air tidak tersedia" {{ $laporan->kondisi_air == 'Air tidak tersedia' || old('kondisi_air') == 'Air tidak tersedia' ? 'selected' : '' }}>Air tidak tersedia</option>
                        </select>
                        @error('kondisi_air')
                            <span style="font-size: 12px; color: #ef4444; display: block; margin-top: 6px;">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <div>
                            <label style="display: block; font-size: 13px; font-weight: 500; color: var(--text-dark); margin-bottom: 8px;">Jumlah Warga Terdampak</label>
                            <input type="number" name="warga_terdampak" placeholder="0" required value="{{ old('warga_terdampak', $laporan->warga_terdampak) }}" style="width: 100%; padding: 12px 16px; border-radius: 8px; border: 1px solid {{ $errors->has('warga_terdampak') ? '#ef4444' : '#cbd5e1' }}; background-color: white; color: var(--text-dark); font-family: inherit; font-size: 14px; outline: none;">
                            @error('warga_terdampak')
                                <span style="font-size: 12px; color: #ef4444; display: block; margin-top: 6px;">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label style="display: block; font-size: 13px; font-weight: 500; color: var(--text-dark); margin-bottom: 8px;">Durasi Kekeringan (hari)</label>
                            <input type="number" name="durasi_kekeringan" placeholder="0" required value="{{ old('durasi_kekeringan', $laporan->durasi_kekeringan) }}" style="width: 100%; padding: 12px 16px; border-radius: 8px; border: 1px solid {{ $errors->has('durasi_kekeringan') ? '#ef4444' : '#cbd5e1' }}; background-color: white; color: var(--text-dark); font-family: inherit; font-size: 14px; outline: none;">
                            @error('durasi_kekeringan')
                                <span style="font-size: 12px; color: #ef4444; display: block; margin-top: 6px;">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Upload Foto Section -->
            <div class="card" style="margin-bottom: 24px;">
                <div class="card-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <svg width="18" height="18" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:var(--text-dark);"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                        <h3 style="font-size: 15px; font-weight: 600; color:var(--text-dark);">Upload Foto <span style="font-size:12px; color:var(--text-gray); font-weight:normal;">(Maksimal 3 Foto)</span></h3>
                    </div>
                    <div id="upload-indicator" style="font-size: 13px; font-weight: 600; color: var(--primary); background: #e2f0fb; padding: 4px 10px; border-radius: 20px;">
                        0/3 Foto
                    </div>
                </div>
                
                <div style="position: relative; border: 2px dashed #cbd5e1; border-radius: 12px; padding: 32px 20px; text-align: center; background-color: #fafbfc; transition: all 0.2s; overflow: visible; display: flex; flex-direction: column; align-items: center;" id="dropzone" onmouseover="this.style.backgroundColor='#f1f5f9'; this.style.borderColor='#63a4d9'" onmouseout="this.style.backgroundColor='#fafbfc'; this.style.borderColor='#cbd5e1'">
                    
                    <input type="file" id="foto-input" name="foto_upload[]" accept="image/png, image/jpeg" multiple style="position: absolute; inset: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer; z-index: 10;" onchange="handleFileSelect(event)">
                    
                    <div id="default-icon-container" style="display: flex; flex-direction: column; align-items: center; pointer-events: none; z-index: 1;">
                        <svg width="40" height="40" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="color: #64748b; margin-bottom: 12px;"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                        <p style="font-size: 15px; font-weight: 500; color: var(--text-dark); margin-bottom: 4px;">Klik atau drag & drop foto ke area ini</p>
                        <p style="font-size: 13px; color: var(--text-gray);">PNG, JPG up to 10MB per foto</p>
                    </div>

                    <!-- Peringatan batas maksimal -->
                    <div id="limit-warning" style="display: none; margin-top: 12px; font-size: 13px; color: #ef4444; background: #fef2f2; padding: 6px 12px; border-radius: 6px; font-weight: 500; z-index: 2;">
                        Maksimal hanya 3 foto yang diperbolehkan!
                    </div>
                </div>

                <!-- Preview Container -->
                <div id="preview-container" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-top: 20px;">
                    <!-- Previews will be generated here -->
                </div>

                @error('foto_upload')
                    <div style="margin-top: 12px; font-size: 13px; color: #ef4444; background: #fef2f2; padding: 8px 12px; border-radius: 6px; font-weight: 500;">
                        {{ $message }}
                    </div>
                @enderror

                <!-- Input to store removed existing photos (useful for editing mode) -->
                <input type="hidden" name="removed_fotos" id="removed-fotos-input" value="[]">

                <script>
                    let uploadedFiles = [];
                    const maxFiles = 3;
                    const defaultIconContainer = document.getElementById('default-icon-container');
                    const dropzone = document.getElementById('dropzone');
                    const limitWarning = document.getElementById('limit-warning');
                    const indicator = document.getElementById('upload-indicator');
                    const previewContainer = document.getElementById('preview-container');
                    const fileInput = document.getElementById('foto-input');
                    const removedFotosInput = document.getElementById('removed-fotos-input');
                    
                    let existingFotos = [];
                    let removedExistingFotos = [];

                    @if($laporan->foto)
                        @php
                            // Cek apakah string adalah JSON array
                            $rawFoto = $laporan->foto;
                            $fotosArray = json_decode($rawFoto, true);
                            if (json_last_error() === JSON_ERROR_NONE && is_array($fotosArray)) {
                                $fotos = $fotosArray;
                            } else {
                                $fotos = [$rawFoto];
                            }
                        @endphp
                        existingFotos = {!! json_encode($fotos) !!};
                        existingFotos.forEach((path, index) => {
                            if(path) renderExistingPreview(path, index);
                        });
                        updateUI();
                    @endif

                    function handleFileSelect(event) {
                        const files = Array.from(event.target.files);
                        
                        fileInput.value = ''; // Reset input
                        limitWarning.style.display = 'none';

                        const totalCurrent = uploadedFiles.length + existingFotos.length;
                        let availableSlots = maxFiles - totalCurrent;

                        if (files.length > availableSlots) {
                            limitWarning.style.display = 'inline-block';
                        }

                        const filesToAdd = files.slice(0, availableSlots);
                        
                        filesToAdd.forEach(file => {
                            if(file.size <= 10485760) { // 10MB
                                uploadedFiles.push(file);
                                renderNewPreview(file, uploadedFiles.length - 1);
                            } else {
                                alert("File " + file.name + " terlalu besar. Maksimal 10MB.");
                            }
                        });

                        updateUI();
                        updateHiddenFileInput();
                    }

                    function renderNewPreview(file, index) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const wrapper = createPreviewElement(e.target.result, file.name, false, index);
                            previewContainer.appendChild(wrapper);
                        }
                        reader.readAsDataURL(file);
                    }

                    function renderExistingPreview(path, index) {
                        const baseUrl = "{{ asset('storage') }}";
                        const wrapper = createPreviewElement(`${baseUrl}/${path}`, path.split('/').pop(), true, index);
                        previewContainer.appendChild(wrapper);
                    }

                    function createPreviewElement(src, name, isExisting, index) {
                        const wrapper = document.createElement('div');
                        wrapper.className = 'preview-item';
                        wrapper.dataset.index = index;
                        wrapper.dataset.isExisting = isExisting;
                        wrapper.style.cssText = 'position: relative; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border: 1px solid var(--border); background: white; aspect-ratio: 4/3;';
                        
                        const img = document.createElement('img');
                        img.src = src;
                        img.style.cssText = 'width: 100%; height: 100%; object-fit: cover; display: block;';
                        
                        const nameOverlay = document.createElement('div');
                        nameOverlay.style.cssText = 'position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(to top, rgba(0,0,0,0.7), transparent); color: white; padding: 20px 8px 8px; font-size: 11px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;';
                        nameOverlay.textContent = name;

                        const btn = document.createElement('button');
                        btn.type = 'button';
                        btn.innerHTML = '<svg width="14" height="14" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>';
                        btn.style.cssText = 'position: absolute; top: 6px; right: 6px; background: #ef4444; color: white; border: none; border-radius: 50%; width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; cursor: pointer; z-index: 10; box-shadow: 0 2px 4px rgba(0,0,0,0.2); transition: transform 0.2s;';
                        btn.onmouseover = () => btn.style.transform = 'scale(1.1)';
                        btn.onmouseout = () => btn.style.transform = 'scale(1)';
                        
                        btn.onclick = () => {
                            if (isExisting) {
                                let path = existingFotos[index];
                                removedExistingFotos.push(path);
                                existingFotos.splice(index, 1);
                                removedFotosInput.value = JSON.stringify(removedExistingFotos);
                                refreshAllPreviews();
                            } else {
                                uploadedFiles.splice(index, 1);
                                updateHiddenFileInput();
                                refreshAllPreviews();
                            }
                            limitWarning.style.display = 'none';
                            updateUI();
                        };

                        wrapper.appendChild(img);
                        wrapper.appendChild(nameOverlay);
                        wrapper.appendChild(btn);
                        return wrapper;
                    }

                    function refreshAllPreviews() {
                        const existingElements = document.querySelectorAll('.preview-item');
                        existingElements.forEach(el => el.remove());
                        existingFotos.forEach((path, i) => renderExistingPreview(path, i));
                        uploadedFiles.forEach((file, i) => renderNewPreview(file, i));
                    }

                    function updateHiddenFileInput() {
                        const dt = new DataTransfer();
                        uploadedFiles.forEach(file => dt.items.add(file));
                        
                        let hiddenInput = document.getElementById('hidden-foto-files');
                        if(!hiddenInput) {
                            hiddenInput = document.createElement('input');
                            hiddenInput.type = 'file';
                            hiddenInput.id = 'hidden-foto-files';
                            hiddenInput.name = 'foto_upload[]';
                            hiddenInput.multiple = true;
                            hiddenInput.style.display = 'none';
                            document.forms[0].appendChild(hiddenInput);
                        }
                        hiddenInput.files = dt.files;
                        // Hapus name file input ori biar gak ke submit ganda / error formatnya
                        fileInput.removeAttribute('name');
                    }

                    function updateUI() {
                        const total = uploadedFiles.length + existingFotos.length;
                        indicator.textContent = total + '/3 Foto';
                        
                        if (total >= maxFiles) {
                            dropzone.style.display = 'none';
                        } else {
                            dropzone.style.display = 'flex';
                        }
                    }
                </script>
            </div>

            <!-- Keterangan Section -->
            <div class="card" style="margin-bottom: 32px;">
                <div class="card-header" style="margin-bottom: 16px;">
                    <h3 style="font-size: 15px; font-weight: 600; color:var(--text-dark);">Keterangan</h3>
                </div>
                <textarea name="keterangan" required rows="4" placeholder="Jelaskan kondisi kekeringan secara detail..." style="width: 100%; padding: 16px; border-radius: 8px; border: 1px solid {{ $errors->has('keterangan') ? '#ef4444' : '#cbd5e1' }}; background-color: white; color: var(--text-dark); font-family: inherit; font-size: 14px; outline: none; resize: vertical;">{{ old('keterangan', $laporan->keterangan) }}</textarea>
                @error('keterangan')
                    <span style="font-size: 12px; color: #ef4444; display: block; margin-top: 6px;">{{ $message }}</span>
                @enderror
            </div>

            <!-- Footer Buttons -->
            <div style="display: flex; justify-content: flex-end; gap: 16px; margin-bottom: 40px;">
                <a href="{{ route('petugas.laporan.index') }}" style="display: flex; align-items: center; gap: 8px; padding: 12px 24px; background: white; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 14px; font-weight: 600; color: #1e293b; cursor: pointer; text-decoration: none; font-family: inherit; transition: all 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='white'">
                    Batal
                </a>
                <button type="submit" style="display: flex; align-items: center; justify-content: center; gap: 8px; padding: 12px 24px; background: #3b82f6; border: none; border-radius: 8px; font-size: 14px; font-weight: 600; color: white; cursor: pointer; font-family: inherit; box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3); transition: all 0.2s;" onmouseover="this.style.background='#2563eb'" onmouseout="this.style.background='#3b82f6'">
                    <svg width="18" height="18" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                    Update Laporan
                </button>
            </div>
        </form>
    </main>
</body>
</html>
