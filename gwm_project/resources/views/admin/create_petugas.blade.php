<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GWM - Dashboard Administrator</title>
    <!-- Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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

        .brand-icon {
            width: 36px;
            height: 36px;
            background-color: #0ea5e9;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .brand-text h2 {
            margin: 0;
            font-size: 16px;
            font-weight: 700;
        }

        .brand-text p {
            margin: 0;
            font-size: 11px;
            color: var(--text-gray);
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

        .page-header {
            margin-bottom: 32px;
        }

        .page-header h1 {
            margin: 0 0 8px 0;
            font-size: 28px;
            font-weight: 600;
        }

        .page-header p {
            margin: 0;
            color: var(--text-gray);
            font-size: 15px;
        }

        /* Stat Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 32px;
        }

        .stat-card {
            background: white;
            border-radius: var(--card-radius);
            padding: 20px;
            border: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
        }

        .stat-info {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .stat-label {
            font-size: 13px;
            font-weight: 500;
            color: var(--text-gray);
        }

        .stat-value {
            font-size: 32px;
            font-weight: 600;
            color: var(--text-dark);
            margin: 0;
            line-height: 1;
        }

        .stat-extra {
            font-size: 13px;
            color: var(--text-gray);
            margin: 0;
        }

        .stat-icon {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Icons Colors */
        .icon-blue {
            background-color: #eff6ff;
            color: #3b82f6;
        }

        .icon-red {
            background-color: #fef2f2;
            color: #ef4444;
        }

        .icon-orange {
            background-color: #fff7ed;
            color: #f97316;
        }

        .icon-green {
            background-color: #f0fdf4;
            color: #10b981;
        }

        /* Charts Section */
        .charts-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
        }

        .chart-card {
            background: white;
            border-radius: var(--card-radius);
            padding: 24px;
            border: 1px solid var(--border);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
            height: 400px;
            display: flex;
            flex-direction: column;
        }

        .chart-card h3 {
            margin: 0 0 20px 0;
            font-size: 15px;
            font-weight: 600;
        }

        .chart-container {
            flex: 1;
            position: relative;
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Custom Legends for Pie Chart */
        .custom-legend {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-top: 20px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: #475569;
        }

        .legend-color {
            width: 10px;
            height: 10px;
            border-radius: 50%;
        }

        /* Password Toggle Styles */
        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
            width: 100%;
        }

        .toggle-password {
            position: absolute;
            right: 12px;
            cursor: pointer;
            color: #94a3b8;
            background: none;
            border: none;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10;
            transition: color 0.2s;
        }

        .toggle-password:hover {
            color: #0ea5e9;
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
                <p>Admin</p>
            </div>
        </div>

        <ul class="nav-menu">
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="nav-link">
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
                <a href="{{ route('admin.create_petugas') }}" class="nav-link active">
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
                <a href="#" class="nav-link">
                    <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor">
                        <polyline points="20 6 9 17 4 12" />
                    </svg>
                    Validasi
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor">
                        <polyline points="22 12 18 12 15 21 9 3 6 12 2 12" />
                    </svg>
                    Prioritas
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
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
                <a href="#" class="nav-link">
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
        <div class="page-header">
            <h1>Buat Akun Petugas</h1>
            <p>Tambahkan akun login baru untuk petugas lapangan</p>
        </div>

        @if(session('success'))
            <div
                style="background: #10b981; color: white; padding: 12px 20px; border-radius: var(--card-radius); margin-bottom: 24px; font-weight: 500;">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div
                style="background: #ef4444; color: white; padding: 12px 20px; border-radius: var(--card-radius); margin-bottom: 24px; font-weight: 500;">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div style="display: flex; flex-direction: column; gap: 24px; max-width: 800px;">
            <div class="chart-card" style="height: auto; max-width: none;">
                <h3>Detail Akun Baru</h3>
                <form action="{{ route('admin.store_petugas') }}" method="POST"
                    style="display: flex; flex-direction: column; gap: 16px;">
                    @csrf
                    <div>
                        <label
                            style="font-size: 13px; font-weight: 600; color: var(--text-gray); margin-bottom: 8px; display: block;">Kecamatan</label>
                        <select name="name" id="kecamatan_select" required
                            style="width: 100%; padding: 10px; border: 1px solid var(--border); border-radius: 8px; font-family: inherit; background-color: white;">
                            <option value="" disabled selected>Pilih Kecamatan</option>
                            <option value="Wonosari">Wonosari</option>
                            <option value="Playen">Playen</option>
                            <option value="Patuk">Patuk</option>
                            <option value="Gedangsari">Gedangsari</option>
                            <option value="Nglipar">Nglipar</option>
                            <option value="Ngawen">Ngawen</option>
                            <option value="Semin">Semin</option>
                            <option value="Ponjong">Ponjong</option>
                            <option value="Karangmojo">Karangmojo</option>
                            <option value="Paliyan">Paliyan</option>
                            <option value="Saptosari">Saptosari</option>
                            <option value="Tepus">Tepus</option>
                            <option value="Tanjungsari">Tanjungsari</option>
                            <option value="Rongkop">Rongkop</option>
                            <option value="Girisubo">Girisubo</option>
                            <option value="Panggang">Panggang</option>
                            <option value="Purwosari">Purwosari</option>
                            <option value="Semanu">Semanu</option>
                        </select>
                    </div>
                    <div>
                        <label
                            style="font-size: 13px; font-weight: 600; color: var(--text-gray); margin-bottom: 8px; display: block;">Kelurahan
                            (Bisa banyak, pisahkan dengan koma)</label>
                        <input type="text" name="kelurahan" placeholder="Contoh: Mulo, Kepek, Baleharjo" required
                            style="width: 100%; padding: 10px; border: 1px solid var(--border); border-radius: 8px; font-family: inherit;">
                    </div>
                    <div>
                        <label
                            style="font-size: 13px; font-weight: 600; color: var(--text-gray); margin-bottom: 8px; display: block;">Username
                            (Email)</label>
                        <input type="text" name="email" required
                            style="width: 100%; padding: 10px; border: 1px solid var(--border); border-radius: 8px; font-family: inherit;">
                    </div>
                    <div>
                        <label
                            style="font-size: 13px; font-weight: 600; color: var(--text-gray); margin-bottom: 8px; display: block;">Password
                            Login (Min. 8)</label>
                        <div class="input-wrapper">
                            <input type="password" id="password" name="password" required
                                style="width: 100%; padding: 10px; padding-right: 40px; border: 1px solid var(--border); border-radius: 8px; font-family: inherit;">
                            <button type="button" id="togglePassword" class="toggle-password">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div style="margin-top: 10px;">
                        <button type="submit"
                            style="padding: 12px 24px; background-color: #0ea5e9; color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">Buat
                            Akun Petugas</button>
                    </div>
                </form>
            </div>

            <div class="chart-card" style="height: auto; max-width: none;">
                <h3>Daftar Akun Petugas</h3>
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 13px;">
                        <thead>
                            <tr style="border-bottom: 1px solid var(--border);">
                                <th style="padding: 12px 8px; color: var(--text-gray); font-weight: 600;">Kecamatan</th>
                                <th style="padding: 12px 8px; color: var(--text-gray); font-weight: 600;">Kelurahan</th>
                                <th style="padding: 12px 8px; color: var(--text-gray); font-weight: 600;">Username
                                    (Email)</th>
                                <th style="padding: 12px 8px; color: var(--text-gray); font-weight: 600;">Tgl Dibuat
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($accounts as $acc)
                                <tr style="border-bottom: 1px solid #f1f5f9;">
                                    <td style="padding: 12px 8px; font-weight: 500; color: var(--text-dark);">
                                        {{ $acc->name }}</td>
                                    <td style="padding: 12px 8px; color: var(--text-gray);">{{ $acc->kelurahan }}</td>
                                    <td style="padding: 12px 8px; color: var(--text-gray);">{{ $acc->email }}</td>
                                    <td style="padding: 12px 8px; color: var(--text-gray);">
                                        {{ $acc->created_at->format('d M Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" style="padding: 24px 8px; text-align: center; color: #94a3b8;">Belum ada
                                        akun petugas yang dibuat.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <script>
        // Pie Chart Initialization
        const pieCtx = document.getElementById('pieChart').getContext('2d');
        new Chart(pieCtx, {
            type: 'pie',
            data: {
                labels: ['Rendah', 'Sedang', 'Tinggi', 'Kritis'],
                datasets: [{
                    data: [0, 0, 0, 0],
                    backgroundColor: [
                        '#10b981', // Green
                        '#eab308', // Yellow
                        '#f97316', // Orange
                        '#ef4444'  // Red
                    ],
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false // We use custom HTML legend below it
                    },
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                return ' ' + context.label + ': ' + context.raw;
                            }
                        }
                    }
                }
            }
        });

        // Bar Chart Initialization
        const barCtx = document.getElementById('barChart').getContext('2d');
        new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: ['Desa Bleberan', 'Desa Nglipar', 'Desa Karangmojo', 'Desa Gedangsari', 'Desa Ponjong'],
                datasets: [{
                    label: 'Warga Terdampak',
                    data: [0, 0, 0, 0, 0],
                    backgroundColor: '#0ea5e9',
                    borderRadius: 4,
                    barPercentage: 0.6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 320,
                        ticks: {
                            stepSize: 80,
                            color: '#94a3b8',
                            font: { size: 11 }
                        },
                        grid: {
                            color: '#f1f5f9',
                            drawBorder: false
                        }
                    },
                    x: {
                        ticks: {
                            color: '#94a3b8',
                            font: { size: 10 },
                            maxRotation: 45,
                            minRotation: 45
                        },
                        grid: {
                            display: false,
                            drawBorder: false
                        }
                    }
                }
            }
        });

        // Toggle Password Visibility
        const togglePassword = document.querySelector('#togglePassword');
        const passwordField = document.querySelector('#password');

        togglePassword.addEventListener('click', function () {
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);

            this.innerHTML = type === 'password' ?
                `<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                    <circle cx="12" cy="12" r="3"></circle>
                </svg>` :
                `<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                    <line x1="1" y1="1" x2="23" y2="23"></line>
                </svg>`;
        });
    </script>
</body>

</html>