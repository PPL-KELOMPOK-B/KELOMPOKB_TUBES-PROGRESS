<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GWM - Detail Level Kondisi</title>
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
            flex-shrink: 0;
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
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        
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
            align-self: flex-start;
            margin-left: 20px;
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

        .page-title {
            text-align: center;
            margin-bottom: 40px;
            font-size: 32px;
            font-weight: 600;
            color: var(--text-dark);
        }

        /* Card Container */
        .level-card-container {
            background: white;
            border-radius: 24px;
            padding: 40px;
            width: 100%;
            max-width: 1100px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            display: flex;
            gap: 40px;
            align-items: center;
            justify-content: space-between;
        }

        /* Left Column - Image */
        .image-section {
            background: #f1f5f9;
            border-radius: 16px;
            padding: 20px;
            width: 320px;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .image-title {
            font-size: 16px;
            font-weight: 600;
            color: var(--text-dark);
        }

        .image-preview {
            width: 100%;
            height: 220px;
            border-radius: 12px;
            object-fit: cover;
            background: #e2e8f0;
        }

        /* Middle Column - Legend */
        .legend-section {
            display: flex;
            flex-direction: column;
            gap: 24px;
            padding: 0 20px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .legend-circle {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .legend-circle.darurat { background-color: #ef4444; }
        .legend-circle.siaga { background-color: #f97316; }
        .legend-circle.waspada { background-color: #eab308; }
        .legend-circle.aman { background-color: #10b981; }

        .legend-text {
            font-size: 18px;
            font-weight: 600;
            color: var(--text-dark);
        }

        /* Right Column - Detected Section */
        .detected-section-wrapper {
            flex: 1;
            max-width: 380px;
        }

        .detected-title {
            font-size: 18px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 12px;
        }

        .detected-card {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.02);
            height: 100%;
        }

        .detected-header {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 16px;
            margin-bottom: 24px;
        }

        .detected-circle {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background-color: {{ $laporan->tingkat_color }};
        }

        .detected-status {
            font-size: 20px;
            font-weight: 600;
            color: var(--text-dark);
        }

        .detected-desc-title {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 8px;
        }

        .detected-desc-text {
            font-size: 14px;
            color: #475569;
            line-height: 1.6;
        }
    </style>
</head>

<body>

    <!-- Sidebar -->
    @include('admin.sidebar')

    <!-- Main Content -->
    <main class="main-content">
        @if(request()->routeIs('admin.monitoring.*'))
            <a href="{{ route('admin.monitoring') }}" class="btn-back">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
                Kembali ke Monitoring
            </a>
        @else
            <a href="{{ route('admin.dashboard') }}" class="btn-back">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
                Kembali ke Dashboard
            </a>
        @endif

        <h1 class="page-title">Penentuan Level Kondisi</h1>

        <div class="level-card-container">
            <!-- Left: Tabel Referensi -->
            <div class="image-section" style="background: white; color: #0f172a; padding: 24px; display: flex; flex-direction: column; gap: 16px; border-radius: 16px; border: 1px solid #e2e8f0; width: 320px; box-sizing: border-box;">
                <div style="display: flex; border-bottom: 1px solid #e2e8f0; padding-bottom: 12px; font-weight: 600; font-size: 15px;">
                    <div style="flex: 1; border-right: 1px solid #e2e8f0; padding-right: 12px;">Tingkat Kekeringan</div>
                    <div style="flex: 1; padding-left: 12px; text-align: left;">Level Kondisi</div>
                </div>

                <div style="display: flex; font-size: 15px; border-bottom: 1px solid #f1f5f9; padding-bottom: 8px; padding-top: 8px;">
                    <div style="flex: 1; border-right: 1px solid #e2e8f0; padding-right: 12px; color: #64748b;">Sedang</div>
                    <div style="flex: 1; padding-left: 12px; text-align: left; color: #0f172a;">Waspada</div>
                </div>
                <div style="display: flex; font-size: 15px; border-bottom: 1px solid #f1f5f9; padding-bottom: 8px; padding-top: 8px;">
                    <div style="flex: 1; border-right: 1px solid #e2e8f0; padding-right: 12px; color: #64748b;">Tinggi</div>
                    <div style="flex: 1; padding-left: 12px; text-align: left; color: #0f172a;">Siaga</div>
                </div>
                <div style="display: flex; font-size: 15px; border-bottom: 1px solid #f1f5f9; padding-bottom: 8px; padding-top: 8px;">
                    <div style="flex: 1; border-right: 1px solid #e2e8f0; padding-right: 12px; color: #64748b;">Kritis</div>
                    <div style="flex: 1; padding-left: 12px; text-align: left; color: #0f172a;">Darurat</div>
                </div>
            </div>

            <!-- Middle: Legend -->
            <div class="legend-section">
                <div class="legend-item">
                    <div class="legend-circle darurat"></div>
                    <div class="legend-text">Darurat</div>
                </div>
                <div class="legend-item">
                    <div class="legend-circle siaga"></div>
                    <div class="legend-text">Siaga</div>
                </div>
                <div class="legend-item">
                    <div class="legend-circle waspada"></div>
                    <div class="legend-text">Waspada</div>
                </div>
            </div>

            <!-- Right: Detected -->
            <div class="detected-section-wrapper">
                <div class="detected-title">Terdeteksi:</div>
                <div class="detected-card">
                    <div class="detected-header">
                        <div class="detected-circle"></div>
                        <div class="detected-status" style="color: {{ $laporan->tingkat_color }};">
                            @if($tingkat === 'Kritis')
                                Darurat
                            @elseif($tingkat === 'Tinggi')
                                Siaga
                            @else
                                Waspada
                            @endif
                        </div>
                    </div>
                    <div class="detected-desc-title">Penjelasan:</div>
                    <div class="detected-desc-text">
                        {{ $laporan->desc }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Peta Lokasi -->
        <div class="level-card-container" style="margin-top: 24px; padding: 30px;">
            <div style="width: 100%;">
                <div class="detected-title" style="margin-bottom: 16px;">Peta Lokasi Laporan: Kelurahan {{ $laporan->kelurahan }}, Kecamatan {{ str_replace('Petugas ', '', $laporan->kecamatan) }}</div>
                <div style="width: 100%; height: 550px; border-radius: 16px; overflow: hidden; border: 1px solid #e2e8f0;">
                    <iframe 
                        width="100%" 
                        height="100%" 
                        style="border:0;" 
                        loading="lazy" 
                        allowfullscreen 
                        referrerpolicy="no-referrer-when-downgrade"
                        src="https://maps.google.com/maps?q={{ urlencode('Kelurahan ' . $laporan->kelurahan . ', Kecamatan ' . str_replace('Petugas ', '', $laporan->kecamatan) . ', Gunungkidul, Yogyakarta, Indonesia') }}&t=&z=14&ie=UTF8&iwloc=&output=embed">
                    </iframe>
                </div>
            </div>
        </div>

        <!-- Detail Laporan bergaya ulasan -->
        <div class="level-card-container" style="margin-top: 24px; padding: 30px; display: block;">
            <div class="review-header" style="display: flex; align-items: center; gap: 16px; margin-bottom: 20px;">
                <!-- Warna tanda level kondisi -->
                <div class="review-avatar" style="width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; background-color: {{ $laporan->tingkat_color }};">
                </div>
                <div class="review-info">
                    <!-- Nama Kecamatan -->
                    <h3 style="margin: 0; font-size: 18px; font-weight: 600; color: #0f172a;">Kecamatan {{ str_replace('Petugas ', '', $laporan->kecamatan) }}</h3>
                    <!-- Nama Kelurahan -->
                    <p style="margin: 4px 0 0; font-size: 14px; color: #64748b;">Kelurahan {{ $laporan->kelurahan }}</p>
                </div>
            </div>
            <div style="display: flex; gap: 32px; flex-wrap: wrap;">
                <!-- Kiri: Tanggal & Teks Konten -->
                <div style="flex: 1; min-width: 300px;">
                    <!-- Tanggal laporan -->
                    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 16px;">
                        <span style="font-size: 14px; color: #64748b;">{{ \Carbon\Carbon::parse($laporan->created_at)->translatedFormat('d F Y') }} ({{ \Carbon\Carbon::parse($laporan->created_at)->diffForHumans() }})</span>
                    </div>
                    
                    <!-- Konten Laporan -->
                    <div style="font-size: 16px; color: #0f172a; line-height: 1.6; margin-bottom: 24px;">
                        Rincian Laporan : <br>
                        • Warga Terdampak : <strong>{{ number_format($laporan->warga_terdampak) }} Jiwa</strong><br>
                        • Kondisi Air : <strong>{{ $laporan->kondisi_air }}</strong><br>
                        • Durasi Kekeringan : <strong>{{ $laporan->durasi_kekeringan }} Hari</strong><br>
                        • Keterangan : <strong>{{ $laporan->keterangan }}</strong>
                    </div>
                </div>

                <!-- Kanan: Galeri Foto Slider -->
                @php
                    $decoded = json_decode($laporan->foto, true);
                    $fotos = is_array($decoded) ? $decoded : ($laporan->foto ? [$laporan->foto] : []);
                    $fotoCount = count($fotos);
                @endphp
                
                @if($fotoCount > 0)
                    <div style="flex: 1; min-width: 300px; max-width: 400px;">
                        <style>
                            .slider-container {
                                display: flex;
                                overflow-x: auto;
                                scroll-snap-type: x mandatory;
                                gap: 12px;
                                border-radius: 16px;
                                padding-bottom: 12px; /* Ruang untuk scrollbar */
                            }
                            .slider-container::-webkit-scrollbar {
                                height: 8px;
                            }
                            .slider-container::-webkit-scrollbar-track {
                                background: #f1f5f9;
                                border-radius: 4px;
                            }
                            .slider-container::-webkit-scrollbar-thumb {
                                background: #cbd5e1;
                                border-radius: 4px;
                            }
                            .slide-item {
                                flex: 0 0 100%;
                                scroll-snap-align: center;
                                height: 260px;
                                border-radius: 16px;
                                overflow: hidden;
                            }
                            .gallery-img { width: 100%; height: 100%; object-fit: cover; cursor: pointer; transition: opacity 0.2s; }
                            .gallery-img:hover { opacity: 0.9; }
                            .modal { display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.9); align-items: center; justify-content: center; }
                            .modal.active { display: flex; }
                            .modal-content { max-width: 90%; max-height: 90%; object-fit: contain; }
                            .modal-close { position: absolute; top: 20px; right: 30px; color: #fff; font-size: 40px; font-weight: bold; cursor: pointer; }
                        </style>
                        <div class="slider-container">
                            @foreach($fotos as $foto)
                                <div class="slide-item">
                                    <img src="{{ asset('storage/' . $foto) }}" class="gallery-img" onclick="openModal(this.src)">
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </main>

    <!-- Modal for Image Viewing -->
    <div id="imageModal" class="modal" onclick="closeModal()">
        <span class="modal-close">&times;</span>
        <img class="modal-content" id="modalImg">
    </div>

    <script>
        function openModal(src) {
            document.getElementById('modalImg').src = src;
            document.getElementById('imageModal').classList.add('active');
        }
        function closeModal() {
            document.getElementById('imageModal').classList.remove('active');
        }
    </script>
</body>

</html>
