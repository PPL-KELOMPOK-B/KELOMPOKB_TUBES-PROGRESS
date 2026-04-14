<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Petugas</title>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body {
            margin: 0;
            font-family: Arial;
            background: #f5f6fa;
        }

        .container {
            display: flex;
        }

        /* HEADER */
        .header {
            display: block;
            padding: 10px;
            margin-top: 10px;
            background: #EFF6FF; 
            color: black;
            text-align: center;
            border-radius: 10px;
        }

        .profile {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: transparent; /* penting! biar ga putih */
        }

        .profile img {
            border-radius: 50%;
        }

        /* Sidebar */
        .sidebar {
            width: 220px;
            background: #ffffff;
            height: 100vh;
            padding: 20px;
            border-right: 1px solid #ddd;
        }

        .sidebar h3 {
            margin-bottom: 20px;
        }

        .menu a {
            display: block;
            padding: 10px;
            margin-bottom: 5px;
            text-decoration: none;
            color: #333;
            border-radius: 5px;
        }

        .menu a:hover {
            background: #2f6df6;
            color: white;
        }

        /* Content */
        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        /* icon bulat */
        .icon-wrapper {
            width: 40px;
            height: 40px;
            background: #eef2ff;
            border-radius: 50%;

            display: flex;
            align-items: center;
            justify-content: center;
        }

        .icon-wrapper img {
            width: 20px;
            height: 20px;
        }
        .content {
            flex: 1;
            padding: 20px;
        }

        /* Cards */
                .card {
            position: relative;
            background: white;
            padding: 15px;
            border-radius: 10px;
            overflow: hidden;
        }

        /* text */
        .card-text h3 {
            margin: 5px 0 0;
        }

        /* icon BESAR di kanan */
        .card-icon {
            position: absolute;
            right: 10px;
            bottom: 10px;
            opacity: 0.4; /* biar jadi background */
        }
        /* logo */
        .sidebar {
            width: 220px;
            background: white;
            height: 100vh;
            padding: 20px;
        }

        /* 🔥 bikin sejajar kiri-kanan */
        .sidebar-header {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* logo besar kiri */
        .logo img {
            width: 50px;
            height: 50px;
            border-radius: 50%; /* bulat */
            object-fit: cover;
        }

        /* teks */
        .text h3 {
            margin: 0;
            font-size: 18px;
        }

        .text p {
            margin: 0;
            font-size: 12px;
            color: gray;
        }

        .card-icon img {
            width: 50px;   /* BESAR */
            height: 50px;
            border-radius: 50%;   
            object-fit: cover; 
        }
        .card-content {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
        }

        .card p {
            margin: 0;
            font-size: 14px;
            color: #555;
        }

        .card h3 {
            margin: 5px 0 0;
        }
        .cards {
            display: flex;
            gap: 15px;
        }

        .card {
            flex: 1;
            background: white;
            padding: 15px;
            border-radius: 10px;
        }

        /* Row Chart + Action */
        .row {
            display: flex;
            gap: 20px;
            margin-top: 20px;
        }

        .box {
            background: white;
            padding: 50px;
            border-radius: 10px;
        }

         .chart-box {
            width: 1015px;
            height: 200px;
        }

        canvas {
            width: 100% !important;
            height: 100% !important;
        }
        .action-box {
            flex: 1;
        }

        /* Button */

        .btn {
            display: block;
            padding: 10px;
            margin-top: 10px;
            background: #ddd;
            color: black;
            text-align: center;
            border-radius: 5px;
            text-decoration: none;
        
        }

        /* Laporan */
        .laporan {
            margin-top: 20px;
            background: white;
            padding: 20px;
            border-radius: 10px;
        }

        .item {
            border-bottom: 1px solid #eee;
            padding: 10px 0;
        }

        .status {
            padding: 3px 8px;
            border-radius: 5px;
            color: white;
            font-size: 12px;
        }

        .chart-wrapper {
            flex: 1;             /* 🔥 ini kunci utama */
            position: relative;
        }

        .chart-wrapper canvas {
            width: 100% !important;
            height: 100% !important;
            display: block;
        }
        .menunggu { background: blue; }
        .proses { background: orange; }
        .selesai { background: green; }

        /* Responsive */
        @media (max-width: 768px) {
            .row, .cards {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>

<div class="container">

    <!-- Sidebar -->
    
    <div class="sidebar">

            <div class="sidebar-header">
                <div class="logo">
                    <img src="{{ asset('images/waterdrop.jpg') }}" alt="logo">
                </div>

                <div class="text">
                    <h3>GWM</h3>
                    <p>Gunungkidul Water Monitor</p>
                </div>
            </div>
        
        <!-- HEADER -->
        <div class="header">
            <div class="profile">
                <img src="https://i.pravatar.cc/40" alt="foto">
                <span>Petugas Desa</span>
            </div>
        </div>
        <div class="menu">
            <a href="#">Dashboard</a>
            <a href="#">Laporan</a>
            <a href="#">Draft</a>
            <a href="#">Notifikasi</a>
        </div>
    </div>

    <!-- Content -->
    <div class="content">

        <h2>Dashboard</h2>
        <p>Selamat datang, Petugas</p>

        <!-- Cards -->
        <div class="cards">

        <div class="card">
            <div class="card-text">
                <p>Total Laporan</p>
                <h3>{{ $total }}</h3>
            </div>

            <div class="card-icon">
                <img src="{{ asset('images/draft.jpg') }}">
            </div>
        </div>

        <div class="card">
            <div class="card-text">      
                    <p>Menunggu</p>
                    <h3>{{ $menunggu }}</h3>           
            </div>

            <div class="card-icon">
                <img src="{{ asset('images/time.jpg') }}">
            </div>
        </div>

        <div class="card">
            <div class="card-text">               
                    <p>Proses</p>
                    <h3>{{ $proses }}</h3>
            </div>
            <div class="card-icon">
                <img src="{{ asset('images/proses.jpg') }}">
            </div>
        </div>

        <div class="card">
            <div class="card-text">
                    <p>Selesai</p>
                    <h3>{{ $selesai }}</h3>
            </div>
            <div class="card-icon">
                <img src="{{ asset('images/checklist.jpg') }}">
            </div>
        </div>

    </div>

        <!-- Chart + Action -->
        <div class="row">

            <!-- Chart -->
            <div class="box chart-box">
                <h4>Distribusi Status Laporan</h4>
                <canvas id="chart"></canvas>
            </div>

            <!-- Action -->
            <div class="box action-box">
                <h4>Tindakan Cepat</h4>
                <div class="menu">
                <a href="#" class="btn">+ Buat Laporan Baru</a>
                <a href="#" class="btn">Lihat Draft</a>
                <a href="#" class="btn">Semua Laporan</a>
                </div>
            </div>

        </div>

        <!-- Laporan -->
        <div class="laporan">
            <h4>Laporan Terbaru</h4>

            @foreach($laporan as $item)
            <div class="item">
                <b>{{ $item->id_laporan }}</b>
                <span class="status {{ $item->status }}">
                    {{ ucfirst($item->status) }}
                </span>

                <p>{{ $item->lokasi }}</p>
                <small>{{ $item->jumlah_warga }} warga - {{ $item->durasi }} hari</small>

                <span style="float:right">
                    {{ $item->created_at->format('d/m/Y') }}
                </span>
            </div>
            @endforeach

        </div>

    </div>

</div>

<!-- Chart Script -->
        <div class="box">
            <h4>Distribusi Status Laporan</h4>

            <div class="chart-wrapper">
                <canvas id="chart"></canvas>
            </div>
        </div>

        <script>
        new Chart(document.getElementById('chart'), {
            type: 'bar',
            data: {
                labels: ['Menunggu','Proses','Selesai'],
                datasets: [{
                    label: 'Jumlah',
                    data: [{{ $menunggu }}, {{ $proses }}, {{ $selesai }}]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                layout: {
                    padding: 10
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
        </script>
</body>
</html>