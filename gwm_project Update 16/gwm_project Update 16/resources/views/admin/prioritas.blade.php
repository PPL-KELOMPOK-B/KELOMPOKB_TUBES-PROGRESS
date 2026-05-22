<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GWM - Sistem Prioritas</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root { --bg-color:#f8fafc; --sidebar-bg:#fff; --text-dark:#0f172a; --text-gray:#64748b; --border:#e2e8f0; --card-radius:12px; }
        body { margin:0; padding:0; font-family:'Inter',sans-serif; background:var(--bg-color); color:var(--text-dark); display:flex; min-height:100vh; }

        /* Sidebar */
        .sidebar { width:260px; background:var(--sidebar-bg); border-right:1px solid var(--border); display:flex; flex-direction:column; padding:20px; box-sizing:border-box; }
        .brand { margin-bottom:24px; padding:0; }
        .profile-card { display:flex; align-items:center; gap:12px; padding:12px; background:#eff6ff; border-radius:10px; margin-bottom:32px; }
        .profile-avatar { width:36px; height:36px; background:#3b82f6; color:#fff; border-radius:50%; display:flex; align-items:center; justify-content:center; }
        .profile-info h4 { margin:0; font-size:14px; font-weight:600; }
        .profile-info p { margin:2px 0 0; font-size:11px; color:#64748b; }
        .nav-menu { list-style:none; padding:0; margin:0; flex:1; }
        .nav-item { margin-bottom:4px; }
        .nav-link { display:flex; align-items:center; gap:12px; padding:10px 12px; border-radius:8px; color:#475569; text-decoration:none; font-size:14px; font-weight:500; transition:all .2s; }
        .nav-link.active { background:#3b82f6; color:#fff; }
        .nav-link:hover:not(.active) { background:#f1f5f9; }
        .nav-icon { width:18px; height:18px; stroke-width:2; }
        .nav-bottom { margin-top:auto; }

        /* Main */
        .main-content { flex:1; padding:40px; overflow-y:auto; }
        .page-header { margin-bottom:28px; }
        .page-header h1 { margin:0 0 6px; font-size:28px; font-weight:600; }
        .page-header p { margin:0; color:var(--text-gray); font-size:15px; }

        /* Sort Bar */
        .sort-bar { background:#fff; border-radius:var(--card-radius); padding:16px 24px; border:1px solid var(--border); margin-bottom:24px; display:flex; align-items:center; gap:16px; flex-wrap:wrap; }
        .sort-bar label { font-size:14px; font-weight:500; color:var(--text-gray); }
        .sort-bar select { padding:8px 32px 8px 14px; border-radius:8px; border:1px solid var(--border); font-size:14px; font-family:inherit; outline:none; appearance:none; background:#fff url("data:image/svg+xml;charset=US-ASCII,%3Csvg xmlns='http://www.w3.org/2000/svg' width='292.4' height='292.4'%3E%3Cpath fill='%23131313' d='M287 69.4a17.6 17.6 0 0 0-13-5.4H18.4c-5 0-9.3 1.8-12.9 5.4A17.6 17.6 0 0 0 0 82.2c0 5 1.8 9.3 5.4 12.9l128 127.9c3.6 3.6 7.8 5.4 12.8 5.4s9.2-1.8 12.8-5.4L287 95c3.5-3.5 5.4-7.8 5.4-12.8 0-5-1.9-9.2-5.5-12.8z'/%3E%3C/svg%3E") no-repeat right 12px center/10px; cursor:pointer; }
        .sort-bar .filter-badge { display:inline-flex; align-items:center; gap:6px; padding:6px 14px; border-radius:20px; font-size:12px; font-weight:600; background:#eff6ff; color:#2563eb; border:1px solid #bfdbfe; }

        /* Klasifikasi Cards */
        .klasifikasi-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:16px; margin-bottom:28px; }
        .klasifikasi-card { border-radius:var(--card-radius); padding:20px 24px; position:relative; overflow:hidden; }
        .klasifikasi-card .kl-icon { width:40px; height:40px; border-radius:10px; display:flex; align-items:center; justify-content:center; margin-bottom:12px; }
        .klasifikasi-card h4 { margin:0 0 6px; font-size:15px; font-weight:600; }
        .klasifikasi-card p { margin:0; font-size:12px; line-height:1.5; opacity:.8; }
        .klasifikasi-card .kl-count { position:absolute; top:16px; right:20px; font-size:28px; font-weight:700; opacity:.15; }
        .kl-kritis { background:linear-gradient(135deg,#fef2f2,#fee2e2); color:#991b1b; }
        .kl-kritis .kl-icon { background:#fecaca; color:#dc2626; }
        .kl-tinggi { background:linear-gradient(135deg,#fff7ed,#ffedd5); color:#9a3412; }
        .kl-tinggi .kl-icon { background:#fed7aa; color:#ea580c; }
        .kl-sedang { background:linear-gradient(135deg,#fefce8,#fef9c3); color:#854d0e; }
        .kl-sedang .kl-icon { background:#fde68a; color:#a16207; }

        /* Priority Cards */
        .priority-list { display:flex; flex-direction:column; gap:16px; }
        .priority-card { background:#fff; border-radius:var(--card-radius); border:1px solid var(--border); padding:0; display:flex; overflow:hidden; transition:all .25s; position:relative; }
        .priority-card:hover { transform:translateY(-2px); box-shadow:0 8px 24px rgba(0,0,0,.07); }
        .priority-stripe { width:5px; flex-shrink:0; }
        .priority-body { flex:1; padding:20px 24px; display:flex; align-items:center; justify-content:space-between; gap:20px; }
        .priority-left { display:flex; align-items:center; gap:18px; flex:1; min-width:0; }
        .priority-rank { width:44px; height:44px; border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:16px; font-weight:700; color:#fff; flex-shrink:0; }
        .priority-info { flex:1; min-width:0; }
        .priority-title { font-size:15px; font-weight:600; margin:0 0 4px; }
        .priority-subtitle { font-size:12px; color:var(--text-gray); margin:0 0 8px; }
        .priority-tags { display:flex; align-items:center; gap:8px; flex-wrap:wrap; }
        .priority-tags .tag { display:inline-flex; align-items:center; gap:4px; font-size:11px; padding:3px 10px; border-radius:6px; font-weight:500; }
        .tag-status { background:#dbeafe; color:#1e40af; }
        .tag-prioritas { font-weight:600; }
        .priority-meta { display:flex; align-items:center; gap:16px; font-size:12px; color:var(--text-gray); margin-top:6px; }
        .priority-meta svg { width:13px; height:13px; stroke:currentColor; fill:none; stroke-width:2; flex-shrink:0; }
        .priority-meta span { display:inline-flex; align-items:center; gap:4px; }
        .priority-desc { font-size:12px; color:#94a3b8; margin-top:4px; }
        .priority-right { display:flex; align-items:center; gap:20px; flex-shrink:0; }
        .skor-box { text-align:center; }
        .skor-value { font-size:32px; font-weight:700; line-height:1; }
        .skor-label { font-size:11px; color:var(--text-gray); margin-top:2px; }
        .btn-detail { display:inline-flex; align-items:center; gap:6px; padding:10px 18px; border-radius:10px; font-size:13px; font-weight:600; text-decoration:none; border:1px solid var(--border); background:#fff; color:var(--text-dark); transition:all .2s; }
        .btn-detail:hover { background:#f1f5f9; border-color:#cbd5e1; transform:translateY(-1px); box-shadow:0 2px 8px rgba(0,0,0,.06); }

        .empty-state { text-align:center; padding:60px 20px; color:var(--text-gray); }
        .empty-state svg { width:48px; height:48px; stroke:var(--border); margin-bottom:12px; }
        .empty-state p { font-size:15px; margin:0; }

        @keyframes slideUp { from{opacity:0;transform:translateY(12px)} to{opacity:1;transform:translateY(0)} }
        .priority-card { animation:slideUp .3s ease forwards; opacity:0; }
        .priority-card:nth-child(1){animation-delay:.05s} .priority-card:nth-child(2){animation-delay:.1s}
        .priority-card:nth-child(3){animation-delay:.15s} .priority-card:nth-child(4){animation-delay:.2s}
        .priority-card:nth-child(5){animation-delay:.25s} .priority-card:nth-child(6){animation-delay:.3s}

        /* Chart Section */
        .chart-container { background:#fff; border-radius:var(--card-radius); padding:24px; border:1px solid var(--border); margin-bottom:28px; box-shadow:0 4px 6px -1px rgba(0,0,0,0.05); }
        .chart-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:20px; }
        .chart-header h3 { margin:0; font-size:16px; font-weight:600; }
        .chart-legend { display:flex; gap:16px; }
        .legend-item { display:flex; align-items:center; gap:6px; font-size:12px; color:var(--text-gray); }
        .legend-color { width:10px; height:10px; border-radius:2px; }
    </style>
</head>
<body>
    @include('admin.sidebar')

    <!-- Main Content -->
    <main class="main-content">
        <div class="page-header">
            <h1>Sistem Prioritas</h1>
            <p>Laporan diurutkan berdasarkan tingkat urgensi — hanya data <strong>tervalidasi</strong></p>
        </div>

        <!-- Sort & Filter Bar -->
        <div class="sort-bar">
            <label>Urutkan berdasarkan:</label>
            <form method="GET" action="{{ route('admin.prioritas') }}" id="sortForm" style="display:flex;gap:12px;align-items:center;flex:1;flex-wrap:wrap;">
                <select name="sort" onchange="document.getElementById('sortForm').submit()">
                    <option value="warga" {{ $sortBy=='warga'?'selected':'' }}>Warga Terdampak</option>
                    <option value="durasi" {{ $sortBy=='durasi'?'selected':'' }}>Durasi Kekeringan</option>
                    <option value="tingkat" {{ $sortBy=='tingkat'?'selected':'' }}>Tingkat Prioritas</option>
                </select>
                <select name="prioritas" onchange="document.getElementById('sortForm').submit()">
                    <option value="" {{ $filterPrioritas==''?'selected':'' }}>Semua Tingkat</option>
                    <option value="kritis" {{ $filterPrioritas=='kritis'?'selected':'' }}>Kritis</option>
                    <option value="tinggi" {{ $filterPrioritas=='tinggi'?'selected':'' }}>Tinggi</option>
                    <option value="sedang" {{ $filterPrioritas=='sedang'?'selected':'' }}>Sedang</option>
                </select>
                @if($filterPrioritas || $sortBy !== 'warga')
                    <a href="{{ route('admin.prioritas') }}" style="font-size:13px;color:#3b82f6;text-decoration:none;font-weight:500;">Reset</a>
                @endif
                <div style="margin-left:auto;">
                    <span class="filter-badge">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                        {{ $totalValidated }} Laporan Tervalidasi
                    </span>
                </div>
            </form>
        </div>

        <!-- Visualization Chart -->
        <div class="chart-container">
            <div class="chart-header">
                <h3>Visualisasi Distribusi Prioritas</h3>
                <div class="chart-legend">
                    <div class="legend-item"><span class="legend-color" style="background:#ef4444;"></span>Kritis</div>
                    <div class="legend-item"><span class="legend-color" style="background:#f97316;"></span>Tinggi</div>
                    <div class="legend-item"><span class="legend-color" style="background:#eab308;"></span>Sedang</div>
                </div>
            </div>
            <div style="height:250px; position:relative;">
                <canvas id="priorityChart"></canvas>
            </div>
        </div>

        <!-- Klasifikasi Cards -->
        <h3 style="font-size:16px;font-weight:600;margin:0 0 16px;">Perhitungan Skor Prioritas</h3>
        <div class="klasifikasi-grid">
            <div class="klasifikasi-card kl-kritis">
                <div class="kl-count">{{ $jumlahKritis }}</div>
                <div class="kl-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                </div>
                <h4>Klasifikasi Kritis</h4>
                <p>Skor 75 – 100. Diperlukan penanganan darurat segera.</p>
            </div>
            <div class="klasifikasi-card kl-tinggi">
                <div class="kl-count">{{ $jumlahTinggi }}</div>
                <div class="kl-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                <h4>Klasifikasi Tinggi</h4>
                <p>Skor 50 – 74. Kondisi kekeringan parah, perlu bantuan.</p>
            </div>
            <div class="klasifikasi-card kl-sedang">
                <div class="kl-count">{{ $jumlahSedang }}</div>
                <div class="kl-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                </div>
                <h4>Klasifikasi Sedang</h4>
                <p>Skor 0 – 49. Kondisi waspada, sumber air berkurang.</p>
            </div>
        </div>

        <!-- Priority List -->
        @if($laporans->count() > 0)
            <div id="priority-list" class="priority-list">
                @foreach($laporans as $index => $lap)
                    @php
                        $statusLabel = $lap->status === 'selesai' ? 'SELESAI' : ($lap->status === 'proses' ? 'PROSES' : 'DITERIMA');
                        $rankBg = $lap->tingkat === 'Kritis' ? '#ef4444' : ($lap->tingkat === 'Tinggi' ? '#f97316' : '#eab308');
                    @endphp
                    <div class="priority-card">
                        <div class="priority-stripe" style="background:{{ $rankBg }};"></div>
                        <div class="priority-body">
                            <div class="priority-left">
                                <div class="priority-rank" style="background:{{ $rankBg }};">#{{ $index + 1 }}</div>
                                <div class="priority-info">
                                    <p class="priority-title">Kelurahan {{ $lap->kelurahan }}</p>
                                    <p class="priority-subtitle">Kecamatan {{ str_replace('Petugas ', '', $lap->kecamatan) }}</p>
                                    <div class="priority-tags">
                                        <span class="tag tag-status">STATUS <strong style="margin-left:2px;">{{ $statusLabel }}</strong></span>
                                        <span class="tag tag-prioritas" style="background:{{ $lap->tingkat_bg }};color:{{ $lap->tingkat_color }};border:1px solid {{ $lap->tingkat_border }};">PRIORITAS <strong style="margin-left:2px;">{{ strtoupper($lap->tingkat) }}</strong></span>
                                    </div>
                                    <div class="priority-meta">
                                        <span>
                                            <svg viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                                            Tingkat: <strong>{{ strtolower($lap->tingkat) }}</strong>
                                        </span>
                                        <span>
                                            <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                                            Warga: <strong>{{ $lap->warga_terdampak }}</strong>
                                        </span>
                                        <span>
                                            <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                            Durasi: <strong>{{ $lap->durasi_kekeringan }} hari</strong>
                                        </span>
                                    </div>
                                    <p class="priority-desc">{{ $lap->kondisi_air }}</p>
                                </div>
                            </div>
                            <div class="priority-right">
                                <div class="skor-box">
                                    <div class="skor-value" style="color:{{ $rankBg }};">{{ $lap->skor_prioritas }}</div>
                                    <div class="skor-label">Skor Prioritas</div>
                                </div>
                                <a href="{{ route('admin.klasifikasi_kekeringan', $lap->id) }}" class="btn-detail">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                <p>Tidak ada laporan prioritas yang tervalidasi saat ini.</p>
            </div>
        @endif
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('priorityChart').getContext('2d');
            
            // Premium gradients
            const gradientKritis = ctx.createLinearGradient(0, 0, 0, 250);
            gradientKritis.addColorStop(0, 'rgba(239, 68, 68, 0.9)');
            gradientKritis.addColorStop(1, 'rgba(239, 68, 68, 0.4)');

            const gradientTinggi = ctx.createLinearGradient(0, 0, 0, 250);
            gradientTinggi.addColorStop(0, 'rgba(249, 115, 22, 0.9)');
            gradientTinggi.addColorStop(1, 'rgba(249, 115, 22, 0.4)');

            const gradientSedang = ctx.createLinearGradient(0, 0, 0, 250);
            gradientSedang.addColorStop(0, 'rgba(234, 179, 8, 0.9)');
            gradientSedang.addColorStop(1, 'rgba(234, 179, 8, 0.4)');

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Kritis', 'Tinggi', 'Sedang'],
                    datasets: [{
                        label: 'Jumlah Laporan',
                        data: [{{ $jumlahKritis }}, {{ $jumlahTinggi }}, {{ $jumlahSedang }}],
                        backgroundColor: [gradientKritis, gradientTinggi, gradientSedang],
                        borderColor: ['#ef4444', '#f97316', '#eab308'],
                        borderWidth: 2,
                        borderRadius: 8,
                        barThickness: 60,
                        hoverBackgroundColor: ['#dc2626', '#ea580c', '#ca8a04'],
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: '#1e293b',
                            padding: 12,
                            titleFont: { size: 14, weight: '600' },
                            bodyFont: { size: 13 },
                            cornerRadius: 8,
                            displayColors: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1,
                                font: { family: "'Inter', sans-serif", size: 12 },
                                color: '#64748b'
                            },
                            grid: {
                                borderDash: [4, 4],
                                color: '#e2e8f0',
                                drawBorder: false
                            }
                        },
                        x: {
                            grid: {
                                display: false,
                                drawBorder: false
                            },
                            ticks: {
                                font: { family: "'Inter', sans-serif", size: 13, weight: '500' },
                                color: '#475569'
                            }
                        }
                    },
                    animation: {
                        duration: 2000,
                        easing: 'easeOutQuart'
                    },
                    onClick: (event, elements) => {
                        if (elements.length > 0) {
                            const index = elements[0].index;
                            const labels = ['kritis', 'tinggi', 'sedang'];
                            const selectedPriority = labels[index];
                            
                            // Find the select element and update its value
                            const prioritySelect = document.querySelector('select[name="prioritas"]');
                            if (prioritySelect) {
                                prioritySelect.value = selectedPriority;
                                // Submit the form
                                document.getElementById('sortForm').submit();
                            }
                        }
                    },
                    onHover: (event, elements) => {
                        event.native.target.style.cursor = elements.length > 0 ? 'pointer' : 'default';
                    }
                }
            });

            // Auto-scroll to results if filter is active
            @if($filterPrioritas)
                setTimeout(() => {
                    const listElement = document.getElementById('priority-list');
                    if (listElement) {
                        listElement.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }
                }, 500); // Small delay to allow chart animation to start
            @endif
        });
    </script>
</body>
</html>
