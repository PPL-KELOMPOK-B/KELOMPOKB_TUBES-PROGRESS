<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GWM - Export Data Laporan</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- html2pdf.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <!-- ExcelJS -->
    <script src="https://cdn.jsdelivr.net/npm/exceljs@4.4.0/dist/exceljs.min.js"></script>

    <style>
        :root {
            --bg-color: #f8fafc;
            --sidebar-bg: #ffffff;
            --text-dark: #0f172a;
            --text-gray: #64748b;
            --border: #e2e8f0;
            --card-radius: 12px;
            --primary-color: #2563eb;
            --primary-hover: #1d4ed8;
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

        /* Sidebar styles are loaded globally from admin.sidebar layout */

        /* Main Content */
        .main-content {
            flex: 1;
            padding: 40px;
            overflow-y: auto;
            box-sizing: border-box;
        }

        .page-header {
            margin-bottom: 32px;
        }

        .page-header h1 {
            margin: 0 0 8px 0;
            font-size: 28px;
            font-weight: 700;
            color: var(--text-dark);
        }

        .page-header p {
            margin: 0;
            color: var(--text-gray);
            font-size: 15px;
        }

        /* Responsive Layout Grid */
        .export-grid {
            display: grid;
            grid-template-columns: 350px 1fr;
            gap: 30px;
            align-items: start;
        }

        @media (max-width: 1024px) {
            .export-grid {
                grid-template-columns: 1fr;
            }
        }

        /* Left Panel - Settings Card */
        .settings-card {
            background: #ffffff;
            border-radius: var(--card-radius);
            padding: 24px;
            border: 1px solid var(--border);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .form-group label {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-dark);
        }

        .form-select,
        .form-input {
            padding: 10px 14px;
            border-radius: 8px;
            border: 1px solid var(--border);
            font-size: 14px;
            font-family: inherit;
            color: var(--text-dark);
            background-color: #ffffff;
            outline: none;
            transition: border-color 0.2s;
        }

        .form-select:focus,
        .form-input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .custom-range-inputs {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-top: 4px;
            animation: fadeIn 0.2s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-4px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Custom Checkboxes */
        .checkbox-group {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .checkbox-label {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
            font-weight: 500;
            color: #475569;
            cursor: pointer;
            user-select: none;
        }

        .checkbox-label input {
            display: none;
        }

        .checkbox-custom {
            width: 20px;
            height: 20px;
            border: 2px solid #cbd5e1;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
            background-color: #fff;
            flex-shrink: 0;
        }

        .checkbox-label input:checked+.checkbox-custom {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .checkbox-custom::after {
            content: "";
            width: 5px;
            height: 10px;
            border: solid white;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg) translate(-1px, -1px);
            opacity: 0;
            transition: opacity 0.1s;
        }

        .checkbox-label input:checked+.checkbox-custom::after {
            opacity: 1;
        }

        .btn-export {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px 24px;
            background-color: var(--primary-color);
            color: #ffffff;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s, transform 0.1s;
            box-shadow: 0 4px 6px -1px rgba(37, 99, 235, 0.2);
        }

        .btn-export:hover {
            background-color: var(--primary-hover);
        }

        .btn-export:active {
            transform: scale(0.98);
        }

        .btn-export svg {
            width: 18px;
            height: 18px;
            stroke-width: 2;
        }

        /* Right Panel - Preview Card */
        .preview-card {
            background: #ffffff;
            border-radius: var(--card-radius);
            padding: 40px;
            border: 1px solid var(--border);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            display: flex;
            flex-direction: column;
            gap: 32px;
            position: relative;
        }

        .preview-title-bar {
            font-size: 12px;
            font-weight: 600;
            color: var(--text-gray);
            border-bottom: 1px solid var(--border);
            padding-bottom: 8px;
            margin-bottom: -12px;
        }

        /* Preview Header */
        .preview-header {
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 16px;
        }

        .preview-logo {
            width: 60px;
            height: 60px;
            object-fit: contain;
            border-radius: 12px;
            background-color: #eff6ff;
            padding: 8px;
            box-shadow: 0 4px 10px rgba(37, 99, 235, 0.1);
        }

        .preview-header h2 {
            margin: 0;
            font-size: 24px;
            font-weight: 700;
            color: var(--text-dark);
        }

        .preview-header p {
            margin: 4px 0 0 0;
            font-size: 14px;
            color: var(--text-gray);
            font-weight: 500;
        }

        .preview-date {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            color: var(--text-gray);
            background-color: #f1f5f9;
            padding: 6px 14px;
            border-radius: 20px;
            margin-top: 4px;
        }

        .preview-divider {
            height: 1px;
            background-color: var(--border);
            margin: 0;
        }

        /* Sections */
        .preview-section {
            display: flex;
            flex-direction: column;
            gap: 18px;
            animation: fadeIn 0.3s ease-in-out;
        }

        .preview-section h3 {
            margin: 0;
            font-size: 16px;
            font-weight: 700;
            color: var(--text-dark);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Ringkasan Grid */
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
        }

        @media (max-width: 768px) {
            .summary-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .summary-box {
            border-radius: 10px;
            padding: 16px 20px;
            display: flex;
            flex-direction: column;
            gap: 6px;
            border: 1px solid transparent;
        }

        .summary-box-blue {
            background-color: #eff6ff;
            color: #1e40af;
            border-color: #dbeafe;
        }

        .summary-box-red {
            background-color: #fef2f2;
            color: #991b1b;
            border-color: #fee2e2;
        }

        .summary-box-orange {
            background-color: #fff7ed;
            color: #9a3412;
            border-color: #ffedd5;
        }

        .summary-box-green {
            background-color: #f0fdf4;
            color: #166534;
            border-color: #dcfce7;
        }

        .summary-label {
            font-size: 12px;
            font-weight: 600;
            opacity: 0.8;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .summary-value {
            font-size: 28px;
            font-weight: 700;
            line-height: 1;
        }

        /* Tables */
        .table-responsive {
            width: 100%;
            overflow-x: auto;
            border: 1px solid var(--border);
            border-radius: 8px;
        }

        .preview-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            font-size: 13px;
        }

        .preview-table th {
            background-color: #f8fafc;
            padding: 12px 16px;
            font-weight: 600;
            color: #475569;
            border-bottom: 1px solid var(--border);
        }

        .preview-table td {
            padding: 12px 16px;
            color: var(--text-dark);
            border-bottom: 1px solid var(--border);
        }

        .preview-table tr:last-child td {
            border-bottom: none;
        }

        .preview-table tbody tr:hover {
            background-color: #f8fafc;
        }

        /* Badges */
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .badge-kritis {
            background-color: #fef2f2;
            color: #dc2626;
            border: 1px solid #fecaca;
        }

        .badge-tinggi {
            background-color: #fff7ed;
            color: #ea580c;
            border: 1px solid #fed7aa;
        }

        .badge-sedang {
            background-color: #fefce8;
            color: #a16207;
            border: 1px solid #fde68a;
        }

        .badge-selesai {
            background-color: #f0fdf4;
            color: #166534;
        }

        .badge-proses {
            background-color: #eff6ff;
            color: #1e40af;
        }

        .badge-diterima {
            background-color: #f1f5f9;
            color: #475569;
        }

        /* Charts Container */
        .charts-flex {
            display: grid;
            grid-template-columns: 1fr 1.5fr;
            gap: 20px;
        }

        @media (max-width: 768px) {
            .charts-flex {
                grid-template-columns: 1fr;
            }
        }

        .chart-box {
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 16px;
            background-color: #ffffff;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .chart-box h4 {
            margin: 0 0 12px 0;
            font-size: 13px;
            font-weight: 600;
            color: var(--text-gray);
            align-self: flex-start;
        }

        /* Timeline Styles */
        .timeline {
            position: relative;
            padding-left: 24px;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 5px;
            top: 6px;
            bottom: 6px;
            width: 2px;
            background-color: var(--border);
        }

        .timeline-item {
            position: relative;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .timeline-dot {
            position: absolute;
            left: -24px;
            top: 4px;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background-color: #cbd5e1;
            border: 2px solid #ffffff;
            box-shadow: 0 0 0 2px #cbd5e1;
            box-sizing: border-box;
            transition: all 0.2s;
        }

        .timeline-item.status-Selesai .timeline-dot {
            background-color: #10b981;
            box-shadow: 0 0 0 2px #10b981;
        }

        .timeline-item.status-Proses .timeline-dot {
            background-color: #3b82f6;
            box-shadow: 0 0 0 2px #3b82f6;
        }

        .timeline-item.status-Direncanakan .timeline-dot {
            background-color: #f59e0b;
            box-shadow: 0 0 0 2px #f59e0b;
        }

        .timeline-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 8px;
        }

        .timeline-date {
            font-size: 11px;
            font-weight: 600;
            color: var(--text-gray);
        }

        .timeline-title {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-dark);
        }

        .timeline-desc {
            font-size: 12px;
            color: #475569;
            line-height: 1.4;
        }

        .timeline-meta {
            font-size: 11px;
            color: var(--text-gray);
            font-style: italic;
        }

        /* Empty state */
        .empty-preview {
            text-align: center;
            padding: 40px 20px;
            color: var(--text-gray);
            font-size: 14px;
            border: 2px dashed var(--border);
            border-radius: 8px;
            background-color: #f8fafc;
        }

        /* PDF Export Styles (rendered via html2pdf) */
        .printing-pdf {
            width: 1000px !important;
            box-sizing: border-box !important;
            background: #ffffff !important;
            color: #0f172a !important;
            padding: 30px !important;
            border: none !important;
            box-shadow: none !important;
            font-family: 'Inter', sans-serif !important;
            height: auto !important;
            overflow: visible !important;
        }

        .printing-pdf,
        .printing-pdf * {
            animation: none !important;
            transition: none !important;
        }

        .printing-pdf .preview-section {
            opacity: 1 !important;
        }

        .printing-pdf .no-print,
        .printing-pdf .preview-title-bar {
            display: none !important;
        }

        .printing-pdf .preview-header h2 {
            color: #0f172a !important;
        }

        .printing-pdf .preview-header p {
            color: #475569 !important;
        }

        .printing-pdf .preview-divider {
            background-color: #e2e8f0 !important;
            height: 1px !important;
            display: block !important;
        }

        .printing-pdf .preview-section {
            page-break-inside: auto !important;
            break-inside: auto !important;
            margin-bottom: 25px !important;
        }

        .printing-pdf .preview-header,
        .printing-pdf .chart-box,
        .printing-pdf .timeline-item,
        .printing-pdf .preview-table tr,
        .printing-pdf .summary-box {
            page-break-inside: avoid !important;
            break-inside: avoid !important;
        }

        .printing-pdf .preview-section h3 {
            color: #0f172a !important;
            border-bottom: 1px solid #e2e8f0 !important;
            padding-bottom: 8px !important;
        }

        .printing-pdf .summary-box-blue {
            background-color: #eff6ff !important;
            color: #1e40af !important;
            border: 1px solid #bfdbfe !important;
        }

        .printing-pdf .summary-box-red {
            background-color: #fef2f2 !important;
            color: #991b1b !important;
            border: 1px solid #fecaca !important;
        }

        .printing-pdf .summary-box-orange {
            background-color: #fff7ed !important;
            color: #9a3412 !important;
            border: 1px solid #fed7aa !important;
        }

        .printing-pdf .summary-box-green {
            background-color: #f0fdf4 !important;
            color: #166534 !important;
            border: 1px solid #bbf7d0 !important;
        }

        .printing-pdf .summary-label {
            color: inherit !important;
            opacity: 0.9 !important;
            font-weight: 600 !important;
        }

        .printing-pdf .summary-value {
            color: inherit !important;
            font-weight: 700 !important;
        }

        .printing-pdf .summary-grid {
            display: flex !important;
            flex-direction: row !important;
            flex-wrap: wrap !important;
            gap: 15px !important;
            width: 100% !important;
        }

        .printing-pdf .summary-box {
            flex: 1 1 200px !important;
            min-width: 180px !important;
            box-sizing: border-box !important;
        }

        .printing-pdf .table-responsive {
            border: 1px solid #cbd5e1 !important;
            overflow: visible !important;
            width: 100% !important;
        }

        .printing-pdf .preview-table {
            width: 100% !important;
            table-layout: fixed !important;
            word-wrap: break-word !important;
            overflow-wrap: break-word !important;
        }

        .printing-pdf .preview-table th,
        .printing-pdf .preview-table td {
            word-wrap: break-word !important;
            overflow-wrap: break-word !important;
            font-size: 11px !important;
            padding: 8px 6px !important;
        }

        .printing-pdf .preview-table th {
            background-color: #f8fafc !important;
            color: #334155 !important;
            border-bottom: 1px solid #cbd5e1 !important;
        }

        .printing-pdf .preview-table td {
            color: #0f172a !important;
            border-bottom: 1px solid #e2e8f0 !important;
        }

        .printing-pdf .badge-kritis {
            background-color: #fef2f2 !important;
            color: #dc2626 !important;
            border: 1px solid #fecaca !important;
        }

        .printing-pdf .badge-tinggi {
            background-color: #fff7ed !important;
            color: #ea580c !important;
            border: 1px solid #fed7aa !important;
        }

        .printing-pdf .badge-sedang {
            background-color: #fefce8 !important;
            color: #a16207 !important;
            border: 1px solid #fde68a !important;
        }

        .printing-pdf .badge-selesai {
            background-color: #f0fdf4 !important;
            color: #166534 !important;
            border: 1px solid #bbf7d0 !important;
        }

        .printing-pdf .badge-proses {
            background-color: #eff6ff !important;
            color: #1e40af !important;
            border: 1px solid #bfdbfe !important;
        }

        .printing-pdf .badge-diterima {
            background-color: #f1f5f9 !important;
            color: #475569 !important;
            border: 1px solid #cbd5e1 !important;
        }

        .printing-pdf .charts-flex {
            display: flex !important;
            flex-direction: row !important;
            gap: 20px !important;
            width: 100% !important;
        }

        .printing-pdf .chart-box {
            flex: 1 !important;
            width: 50% !important;
            box-sizing: border-box !important;
            border: 1px solid #cbd5e1 !important;
            background-color: #ffffff !important;
        }

        .printing-pdf .chart-box h4 {
            color: #475569 !important;
        }

        .printing-pdf .timeline::before {
            background-color: #cbd5e1 !important;
        }

        .printing-pdf .timeline-dot {
            border-color: #ffffff !important;
            box-shadow: 0 0 0 2px #cbd5e1 !important;
        }

        .printing-pdf .timeline-item.status-Selesai .timeline-dot {
            background-color: #10b981 !important;
            box-shadow: 0 0 0 2px #10b981 !important;
        }

        .printing-pdf .timeline-item.status-Proses .timeline-dot {
            background-color: #3b82f6 !important;
            box-shadow: 0 0 0 2px #3b82f6 !important;
        }

        .printing-pdf .timeline-item.status-Direncanakan .timeline-dot {
            background-color: #f59e0b !important;
            box-shadow: 0 0 0 2px #f59e0b !important;
        }

        .printing-pdf .timeline-title {
            color: #0f172a !important;
        }

        .printing-pdf .timeline-date {
            color: #64748b !important;
        }

        .printing-pdf .timeline-desc {
            color: #334155 !important;
        }

        .printing-pdf .timeline-meta {
            color: #64748b !important;
        }

        /* Print CSS Styles for formal report */
        @media print {
            @page {
                size: A4;
                margin: 2cm;
            }

            body {
                background: #ffffff !important;
                color: #000000 !important;
                font-family: 'Times New Roman', Times, serif;
                font-size: 11pt;
                line-height: 1.5;
            }

            .sidebar,
            .page-header,
            .settings-card,
            .no-print,
            .preview-title-bar {
                display: none !important;
            }

            .main-content {
                padding: 0 !important;
                margin: 0 !important;
                overflow: visible !important;
                width: 100% !important;
            }

            .export-grid {
                display: block !important;
                margin: 0 !important;
                padding: 0 !important;
                width: 100% !important;
            }

            .preview-card {
                border: none !important;
                box-shadow: none !important;
                padding: 0 !important;
                margin: 0 !important;
                width: 100% !important;
                background: #ffffff !important;
            }

            .preview-header {
                border-bottom: 2px solid #000000 !important;
                padding-bottom: 15px !important;
                margin-bottom: 25px !important;
                text-align: center !important;
                display: block !important;
            }

            .preview-logo {
                display: none !important;
                /* Hide logo on printed report for formal layout */
            }

            .preview-header h2 {
                font-size: 18pt !important;
                font-weight: bold !important;
                margin: 0 !important;
                color: #000000 !important;
            }

            .preview-header p {
                font-size: 11pt !important;
                margin: 5px 0 0 0 !important;
                color: #000000 !important;
            }

            .preview-date {
                background: none !important;
                padding: 0 !important;
                font-size: 10pt !important;
                color: #000000 !important;
                margin-top: 5px !important;
            }

            .preview-date svg {
                display: none !important;
            }

            .preview-divider {
                display: none !important;
            }

            .preview-section {
                page-break-inside: avoid;
                margin-bottom: 30px !important;
            }

            .preview-section h3 {
                font-size: 13pt !important;
                font-weight: bold !important;
                color: #000000 !important;
                border-bottom: 1px solid #000000 !important;
                padding-bottom: 5px !important;
                margin-bottom: 15px !important;
            }

            .preview-section h3 svg {
                display: none !important;
            }

            /* Summary Grid formatting to plain table cells */
            .summary-grid {
                display: table !important;
                width: 100% !important;
                border-collapse: collapse !important;
            }

            .summary-box {
                display: table-cell !important;
                border: 1px solid #000000 !important;
                background: none !important;
                color: #000000 !important;
                padding: 10px !important;
                text-align: center !important;
                width: 25% !important;
                border-radius: 0 !important;
            }

            .summary-label {
                display: block !important;
                font-size: 9pt !important;
                font-weight: bold !important;
                color: #000000 !important;
                margin-bottom: 5px !important;
            }

            .summary-value {
                display: block !important;
                font-size: 16pt !important;
                font-weight: bold !important;
                color: #000000 !important;
            }

            /* Tables formatting to clean border-collapsed tabular layout */
            .table-responsive {
                border: none !important;
            }

            .preview-table {
                width: 100% !important;
                border-collapse: collapse !important;
            }

            .preview-table th {
                background: #f1f5f9 !important;
                color: #000000 !important;
                border: 1px solid #000000 !important;
                padding: 8px !important;
                font-weight: bold !important;
            }

            .preview-table td {
                border: 1px solid #000000 !important;
                padding: 8px !important;
                color: #000000 !important;
                background: none !important;
            }

            .badge {
                border: none !important;
                background: none !important;
                color: #000000 !important;
                padding: 0 !important;
                font-size: inherit !important;
                font-weight: normal !important;
                text-transform: none !important;
            }

            /* Charts layout */
            .charts-flex {
                display: block !important;
            }

            .chart-box {
                border: none !important;
                background: none !important;
                padding: 0 !important;
                margin-bottom: 20px !important;
                page-break-inside: avoid;
            }

            .chart-box h4 {
                font-size: 11pt !important;
                font-weight: bold !important;
                color: #000000 !important;
                margin-bottom: 10px !important;
            }

            canvas {
                max-width: 100% !important;
                height: auto !important;
            }

            /* Timeline layout to clean plain lists */
            .timeline {
                padding-left: 0 !important;
            }

            .timeline::before {
                display: none !important;
            }

            .timeline-item {
                border-bottom: 1px dashed #000000 !important;
                padding-bottom: 10px !important;
                margin-bottom: 10px !important;
                page-break-inside: avoid;
            }

            .timeline-dot {
                display: none !important;
            }

            .timeline-header {
                font-weight: bold !important;
                display: flex !important;
                justify-content: space-between !important;
            }

            .timeline-title {
                font-size: 11pt !important;
                color: #000000 !important;
            }

            .timeline-date {
                font-size: 10pt !important;
                color: #000000 !important;
            }

            .timeline-desc {
                font-size: 10pt !important;
                color: #000000 !important;
                margin: 4px 0 !important;
            }

            .timeline-meta {
                font-size: 9pt !important;
                color: #000000 !important;
            }
        }
    </style>
</head>

<body>

    @include('admin.sidebar')

    <!-- Main Content -->
    <main class="main-content">
        <div class="page-header no-print">
            <h1>Export Data</h1>
            <p>Export laporan dan data monitoring ke PDF atau Excel</p>
        </div>

        <div class="export-grid">
            <!-- Left Side: Export Settings -->
            <div class="settings-card no-print">
                <h3 style="margin: 0 0 4px 0; font-size: 16px; font-weight: 700;">Pengaturan Export</h3>
                <p style="margin: 0 0 12px 0; font-size: 12px; color: var(--text-gray);">Kustomisasi isi dan format
                    laporan</p>

                <div class="preview-divider"></div>

                <!-- Format File -->
                <div class="form-group">
                    <label for="select-format">Format File</label>
                    <select id="select-format" class="form-select">
                        <option value="PDF">PDF (Siap Cetak)</option>
                        <option value="Excel">Excel / CSV (Data Tabular)</option>
                    </select>
                </div>

                <!-- Rentang Waktu -->
                <div class="form-group">
                    <label for="select-range">Rentang Waktu</label>
                    <select id="select-range" class="form-select">
                        <option value="semua">Semua Data</option>
                        <option value="hari_ini">Hari Ini</option>
                        <option value="7_hari">7 Hari Terakhir</option>
                        <option value="30_hari">30 Hari Terakhir</option>
                        <option value="bulan_ini">Bulan Ini</option>
                        <option value="custom">Custom Range</option>
                    </select>

                    <!-- Custom Range Inputs (Hidden by default) -->
                    <div id="custom-range-inputs" class="custom-range-inputs" style="display: none;">
                        <input type="date" id="start-date" class="form-input" placeholder="Mulai">
                        <input type="date" id="end-date" class="form-input" placeholder="Selesai">
                    </div>
                </div>

                <!-- Bagian yang Disertakan -->
                <div class="form-group">
                    <label>Bagian yang Disertakan</label>
                    <div class="checkbox-group" style="margin-top: 4px;">
                        <label class="checkbox-label">
                            <input type="checkbox" id="chk-ringkasan">
                            <span class="checkbox-custom"></span>
                            Ringkasan
                        </label>
                        <label class="checkbox-label">
                            <input type="checkbox" id="chk-laporan">
                            <span class="checkbox-custom"></span>
                            Daftar Laporan
                        </label>
                        <label class="checkbox-label">
                            <input type="checkbox" id="chk-grafik">
                            <span class="checkbox-custom"></span>
                            Grafik & Statistik
                        </label>
                        <label class="checkbox-label">
                            <input type="checkbox" id="chk-timeline">
                            <span class="checkbox-custom"></span>
                            Timeline Aktivitas
                        </label>
                    </div>
                </div>

                <div class="preview-divider" style="margin-top: 8px;"></div>

                <!-- Export Button -->
                <button type="button" id="btn-export" class="btn-export">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                        <polyline points="7 10 12 15 17 10" />
                        <line x1="12" y1="15" x2="12" y2="3" />
                    </svg>
                    Export Data
                </button>
            </div>

            <!-- Right Side: Preview Pane -->
            <div class="preview-card" id="preview-pane">
                <div class="preview-title-bar no-print">PRATINJAU LAPORAN (DINAMIS)</div>

                <!-- Header Laporan -->
                <div class="preview-header">
                    <img src="{{ asset('images/logo-gwm.png') }}" class="preview-logo" alt="GWM Logo"
                        onerror="this.src='data:image/svg+xml;charset=UTF-8,%3Csvg xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22 width%3D%2260%22 height%3D%2260%22 viewBox%3D%220 0 24 24%22 fill%3D%22none%22 stroke%3D%22%232563eb%22 stroke-width%3D%222%22%3E%3Cpath d%3D%22M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z%22%2F%3E%3C%2Fsvg%3E'">
                    <div>
                        <h2>Gunungkidul Water Monitor</h2>
                        <p>Laporan Monitoring Kekeringan wilayah Gunungkidul</p>
                    </div>
                    <div class="preview-date">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            style="margin-right: 2px;">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                            <line x1="16" y1="2" x2="16" y2="6" />
                            <line x1="8" y1="2" x2="8" y2="6" />
                            <line x1="3" y1="10" x2="21" y2="10" />
                        </svg>
                        <span id="label-export-date">{{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</span>
                    </div>
                </div>

                <div class="preview-divider"></div>

                <!-- Section: Ringkasan Eksekutif -->
                <div id="section-ringkasan" class="preview-section">
                    <h3>
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2" />
                            <line x1="9" y1="9" x2="15" y2="9" />
                            <line x1="9" y1="13" x2="15" y2="13" />
                            <line x1="9" y1="17" x2="13" y2="17" />
                        </svg>
                        Ringkasan Eksekutif
                    </h3>
                    <div class="summary-grid">
                        <div class="summary-box summary-box-blue">
                            <span class="summary-label">Total Laporan</span>
                            <span id="stat-total" class="summary-value">0</span>
                        </div>
                        <div class="summary-box summary-box-red">
                            <span class="summary-label">Laporan Kritis</span>
                            <span id="stat-kritis" class="summary-value">0</span>
                        </div>
                        <div class="summary-box summary-box-orange">
                            <span class="summary-label">Warga Terdampak</span>
                            <span id="stat-warga" class="summary-value">0</span>
                        </div>
                        <div class="summary-box summary-box-green">
                            <span class="summary-label">Selesai Ditangani</span>
                            <span id="stat-selesai" class="summary-value">0</span>
                        </div>
                    </div>
                </div>

                <!-- Section: Daftar Laporan -->
                <div id="section-laporan" class="preview-section">
                    <h3>
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="8" y1="6" x2="21" y2="6" />
                            <line x1="8" y1="12" x2="21" y2="12" />
                            <line x1="8" y1="18" x2="21" y2="18" />
                            <line x1="3" y1="6" x2="3.01" y2="6" />
                            <line x1="3" y1="12" x2="3.01" y2="12" />
                            <line x1="3" y1="18" x2="3.01" y2="18" />
                        </svg>
                        Daftar Laporan Terkini
                    </h3>
                    <div class="table-responsive">
                        <table class="preview-table">
                            <thead>
                                <tr>
                                    <th style="width: 10%;">ID</th>
                                    <th style="width: 22%;">Kecamatan</th>
                                    <th style="width: 22%;">Kelurahan</th>
                                    <th style="width: 15%;">Tingkat</th>
                                    <th style="width: 15%;">Status</th>
                                    <th style="width: 16%; text-align: right;">Warga Terdampak</th>
                                </tr>
                            </thead>
                            <tbody id="laporan-table-body">
                                <!-- Dynamic rows -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Section: Grafik & Statistik -->
                <div id="section-grafik" class="preview-section">
                    <h3>
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 20V10" />
                            <path d="M12 20V4" />
                            <path d="M6 20V14" />
                        </svg>
                        Grafik & Statistik Visual
                    </h3>
                    <div class="charts-flex">
                        <div class="chart-box">
                            <h4>Proporsi Tingkat Kerawanan</h4>
                            <div style="width: 100%; height: 180px; position: relative; margin-bottom: 12px;">
                                <canvas id="proporsiChart"></canvas>
                            </div>
                            <div class="table-responsive" style="margin-top: 15px;">
                                <table class="preview-table" style="width: 100%; font-size: 11px;">
                                    <thead>
                                        <tr style="background-color: #3b82f6; color: #ffffff;">
                                            <th style="padding: 6px 10px; font-weight: 600; text-align: left; background-color: #3b82f6; color: #ffffff;">Tingkat Kerawanan</th>
                                            <th style="padding: 6px 10px; font-weight: 600; text-align: right; background-color: #3b82f6; color: #ffffff; width: 35%;">Jumlah</th>
                                        </tr>
                                    </thead>
                                    <tbody id="preview-proporsi-table-body">
                                        <!-- Dynamic rows -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="chart-box">
                            <h4>Dampak Warga Terbanyak per Kelurahan</h4>
                            <div style="width: 100%; height: 180px; position: relative; margin-bottom: 12px;">
                                <canvas id="wargaChart"></canvas>
                            </div>
                            <div class="table-responsive" style="margin-top: 15px;">
                                <table class="preview-table" style="width: 100%; font-size: 11px;">
                                    <thead>
                                        <tr style="background-color: #3b82f6; color: #ffffff;">
                                            <th style="padding: 6px 10px; font-weight: 600; text-align: left; background-color: #3b82f6; color: #ffffff;">Kelurahan</th>
                                            <th style="padding: 6px 10px; font-weight: 600; text-align: right; background-color: #3b82f6; color: #ffffff; width: 45%;">Warga Terdampak (Jiwa)</th>
                                        </tr>
                                    </thead>
                                    <tbody id="preview-warga-table-body">
                                        <!-- Dynamic rows -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section: Timeline Aktivitas -->
                <div id="section-timeline" class="preview-section" style="display: none;">
                    <h3>
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10" />
                            <polyline points="12 6 12 12 16 14" />
                        </svg>
                        Timeline Tindak Lanjut Aktivitas
                    </h3>
                    <div class="timeline" id="timeline-body">
                        <!-- Dynamic items -->
                    </div>
                </div>

                <!-- Empty State if no sections chosen -->
                <div id="empty-state-preview" class="empty-preview" style="display: none;">
                    Mohon pilih minimal satu bagian laporan di panel kiri untuk memunculkan pratinjau data.
                </div>
            </div>
        </div>
    </main>

    <!-- JS Logic -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Data sources passed from Laravel Controller
            const rawLaporans = @json($laporans);
            const rawTindakLanjuts = @json($tindakLanjuts);

            // UI Elements
            const selectFormat = document.getElementById('select-format');
            const selectRange = document.getElementById('select-range');
            const customRangeInputs = document.getElementById('custom-range-inputs');
            const startDateInput = document.getElementById('start-date');
            const endDateInput = document.getElementById('end-date');

            const chkRingkasan = document.getElementById('chk-ringkasan');
            const chkLaporan = document.getElementById('chk-laporan');
            const chkGrafik = document.getElementById('chk-grafik');
            const chkTimeline = document.getElementById('chk-timeline');

            const secRingkasan = document.getElementById('section-ringkasan');
            const secLaporan = document.getElementById('section-laporan');
            const secGrafik = document.getElementById('section-grafik');
            const secTimeline = document.getElementById('section-timeline');
            const emptyPreview = document.getElementById('empty-state-preview');

            const btnExport = document.getElementById('btn-export');
            const labelExportDate = document.getElementById('label-export-date');

            // Charts variables
            let proporsiChartObj = null;
            let wargaChartObj = null;

            // Setup Custom Range Visiblity Toggle
            selectRange.addEventListener('change', function () {
                if (this.value === 'custom') {
                    customRangeInputs.style.display = 'grid';
                } else {
                    customRangeInputs.style.display = 'none';
                    updatePreview();
                }
            });

            // Add events for dynamic updates
            startDateInput.addEventListener('change', updatePreview);
            endDateInput.addEventListener('change', updatePreview);

            [chkRingkasan, chkLaporan, chkGrafik, chkTimeline].forEach(chk => {
                chk.addEventListener('change', function () {
                    toggleSectionsVisibility();
                    updatePreview();
                });
            });

            // Initial UI Setup
            toggleSectionsVisibility();
            updatePreview();

            // Handle section Visibility Toggle
            function toggleSectionsVisibility() {
                let anyChecked = false;

                if (chkRingkasan.checked) { secRingkasan.style.display = 'flex'; anyChecked = true; }
                else { secRingkasan.style.display = 'none'; }

                if (chkLaporan.checked) { secLaporan.style.display = 'flex'; anyChecked = true; }
                else { secLaporan.style.display = 'none'; }

                if (chkGrafik.checked) { secGrafik.style.display = 'flex'; anyChecked = true; }
                else { secGrafik.style.display = 'none'; }

                if (chkTimeline.checked) { secTimeline.style.display = 'flex'; anyChecked = true; }
                else { secTimeline.style.display = 'none'; }

                if (!anyChecked) {
                    emptyPreview.style.display = 'block';
                } else {
                    emptyPreview.style.display = 'none';
                }
            }

            // Date filtering function
            function filterData() {
                const range = selectRange.value;
                const now = new Date();

                let startLimit = null;
                let endLimit = null;

                if (range === 'hari_ini') {
                    startLimit = new Date(now.getFullYear(), now.getMonth(), now.getDate());
                } else if (range === '7_hari') {
                    startLimit = new Date(now.getTime() - 7 * 24 * 60 * 60 * 1000);
                } else if (range === '30_hari') {
                    startLimit = new Date(now.getTime() - 30 * 24 * 60 * 60 * 1000);
                } else if (range === 'bulan_ini') {
                    startLimit = new Date(now.getFullYear(), now.getMonth(), 1);
                } else if (range === 'custom') {
                    if (startDateInput.value) {
                        startLimit = new Date(startDateInput.value);
                        startLimit.setHours(0, 0, 0, 0);
                    }
                    if (endDateInput.value) {
                        endLimit = new Date(endDateInput.value);
                        endLimit.setHours(23, 59, 59, 999);
                    }
                }

                // Filter Laporans
                const filteredLaporans = rawLaporans.filter(lap => {
                    const createdDate = new Date(lap.created_at);
                    if (startLimit && createdDate < startLimit) return false;
                    if (endLimit && createdDate > endLimit) return false;
                    return true;
                });

                // Filter Timelines (tindakLanjuts)
                const filteredTindakLanjuts = rawTindakLanjuts.filter(tl => {
                    const tlDate = new Date(tl.tanggal);
                    if (startLimit && tlDate < startLimit) return false;
                    if (endLimit && tlDate > endLimit) return false;
                    return true;
                });

                return {
                    laporans: filteredLaporans,
                    timelines: filteredTindakLanjuts
                };
            }

            // Main update controller
            function updatePreview() {
                const data = filterData();

                // Format export date label
                updateExportDateLabel();

                // 1. Update Executive Summary
                updateSummaryStats(data.laporans);

                // 2. Update Table
                updateLaporanTable(data.laporans);

                // 3. Update Charts
                if (chkGrafik.checked) {
                    updateCharts(data.laporans);
                }

                // 4. Update Timeline
                updateTimelineList(data.timelines);
            }

            function updateExportDateLabel() {
                const range = selectRange.value;
                if (range === 'custom' && startDateInput.value && endDateInput.value) {
                    const startFormatted = formatDateIndo(new Date(startDateInput.value));
                    const endFormatted = formatDateIndo(new Date(endDateInput.value));
                    labelExportDate.textContent = `${startFormatted} - ${endFormatted}`;
                } else {
                    labelExportDate.textContent = formatDateIndo(new Date());
                }
            }

            function formatDateIndo(date) {
                const months = [
                    'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                    'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                ];
                const d = date.getDate();
                const m = months[date.getMonth()];
                const y = date.getFullYear();
                return `${d} ${m} ${y}`;
            }

            function updateSummaryStats(laporans) {
                const total = laporans.length;
                const kritis = laporans.filter(l => l.tingkat === 'Kritis').length;
                const warga = laporans.reduce((sum, l) => sum + parseInt(l.warga_terdampak || 0), 0);
                const selesai = laporans.filter(l => l.status === 'selesai').length;

                document.getElementById('stat-total').textContent = total;
                document.getElementById('stat-kritis').textContent = kritis;
                document.getElementById('stat-warga').textContent = formatNumber(warga);
                document.getElementById('stat-selesai').textContent = selesai;
            }

            function formatNumber(num) {
                return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            }

            function updateLaporanTable(laporans) {
                const tbody = document.getElementById('laporan-table-body');
                tbody.innerHTML = '';

                if (laporans.length === 0) {
                    tbody.innerHTML = `
                        <tr>
                            <td colspan="6" style="text-align: center; color: var(--text-gray); padding: 24px;">
                                Tidak ada laporan dalam rentang waktu yang dipilih.
                            </td>
                        </tr>
                    `;
                    return;
                }

                laporans.forEach(l => {
                    const tr = document.createElement('tr');

                    let badgeClass = 'badge-sedang';
                    if (l.tingkat === 'Kritis') badgeClass = 'badge-kritis';
                    else if (l.tingkat === 'Tinggi') badgeClass = 'badge-tinggi';

                    let statusClass = 'badge-diterima';
                    let statusLabel = 'Diterima';
                    if (l.status === 'selesai') {
                        statusClass = 'badge-selesai';
                        statusLabel = 'Selesai';
                    } else if (l.status === 'proses') {
                        statusClass = 'badge-proses';
                        statusLabel = 'Proses';
                    }

                    tr.innerHTML = `
                        <td style="font-weight: 600;">${l.kode}</td>
                        <td>${l.kecamatan.replace('Petugas ', '')}</td>
                        <td>Kel. ${l.kelurahan}</td>
                        <td><span class="badge ${badgeClass}">${l.tingkat}</span></td>
                        <td><span class="badge ${statusClass}">${statusLabel}</span></td>
                        <td style="text-align: right; font-weight: 600;">${formatNumber(l.warga_terdampak)}</td>
                    `;
                    tbody.appendChild(tr);
                });
            }

            function updateCharts(laporans) {
                // Proporsi Chart (Sedang, Tinggi, Kritis)
                const sed = laporans.filter(l => l.tingkat === 'Sedang').length;
                const tng = laporans.filter(l => l.tingkat === 'Tinggi').length;
                const krt = laporans.filter(l => l.tingkat === 'Kritis').length;

                // Destruct old chart if exists
                if (proporsiChartObj) proporsiChartObj.destroy();

                const ctxProporsi = document.getElementById('proporsiChart').getContext('2d');
                proporsiChartObj = new Chart(ctxProporsi, {
                    type: 'doughnut',
                    data: {
                        labels: ['Sedang', 'Tinggi', 'Kritis'],
                        datasets: [{
                            data: [sed || 0, tng || 0, krt || 0],
                            backgroundColor: ['#eab308', '#f97316', '#ef4444'],
                            borderWidth: 1,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        animation: {
                            duration: 0
                        },
                        plugins: {
                            legend: {
                                position: 'right',
                                labels: {
                                    boxWidth: 12,
                                    font: { size: 11, family: "'Inter', sans-serif" }
                                }
                            }
                        }
                    }
                });

                // Update HTML explanation tables for PDF / Web preview
                const proporsiTbody = document.getElementById('preview-proporsi-table-body');
                if (proporsiTbody) {
                    proporsiTbody.innerHTML = `
                        <tr>
                            <td style="padding: 6px 10px; font-weight: 600; color: #a16207;">Sedang</td>
                            <td style="padding: 6px 10px; text-align: right; font-weight: 600;">${sed}</td>
                        </tr>
                        <tr>
                            <td style="padding: 6px 10px; font-weight: 600; color: #ea580c;">Tinggi</td>
                            <td style="padding: 6px 10px; text-align: right; font-weight: 600;">${tng}</td>
                        </tr>
                        <tr>
                            <td style="padding: 6px 10px; font-weight: 600; color: #dc2626;">Kritis</td>
                            <td style="padding: 6px 10px; text-align: right; font-weight: 600;">${krt}</td>
                        </tr>
                    `;
                }

                // Warga Terdampak per Kelurahan Chart (Top 5)
                const kelMap = {};
                laporans.forEach(l => {
                    if (l.kelurahan) {
                        kelMap[l.kelurahan] = (kelMap[l.kelurahan] || 0) + parseInt(l.warga_terdampak || 0);
                    }
                });

                // Sort and get Top 5
                const sortedKels = Object.keys(kelMap).map(k => ({
                    name: k,
                    value: kelMap[k]
                })).sort((a, b) => b.value - a.value).slice(0, 5);

                const labelsWarga = sortedKels.map(k => k.name);
                const dataWarga = sortedKels.map(k => k.value);

                // Destruct old bar chart if exists
                if (wargaChartObj) wargaChartObj.destroy();

                const ctxWarga = document.getElementById('wargaChart').getContext('2d');
                wargaChartObj = new Chart(ctxWarga, {
                    type: 'bar',
                    data: {
                        labels: labelsWarga.length > 0 ? labelsWarga : ['Data Kosong'],
                        datasets: [{
                            label: 'Jumlah Warga',
                            data: dataWarga.length > 0 ? dataWarga : [0],
                            backgroundColor: '#2563eb',
                            borderRadius: 4,
                            barThickness: 20
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        animation: {
                            duration: 0
                        },
                        scales: {
                            y: { beginAtZero: true, ticks: { font: { size: 9 } } },
                            x: { ticks: { font: { size: 9 } } }
                        },
                        plugins: {
                            legend: { display: false }
                        }
                    }
                });

                // Update HTML explanation tables for PDF / Web preview
                const wargaTbody = document.getElementById('preview-warga-table-body');
                if (wargaTbody) {
                    wargaTbody.innerHTML = '';
                    if (sortedKels.length === 0) {
                        wargaTbody.innerHTML = `
                            <tr>
                                <td colspan="2" style="padding: 6px 10px; text-align: center; font-style: italic; color: #64748b;">
                                    Data Kosong
                                </td>
                            </tr>
                        `;
                    } else {
                        sortedKels.forEach(item => {
                            wargaTbody.innerHTML += `
                                <tr>
                                    <td style="padding: 6px 10px;">Kel. ${item.name}</td>
                                    <td style="padding: 6px 10px; text-align: right; font-weight: 600;">${formatNumber(item.value)}</td>
                                </tr>
                            `;
                        });
                    }
                }
            }

            function updateTimelineList(timelines) {
                const timelineContainer = document.getElementById('timeline-body');
                timelineContainer.innerHTML = '';

                if (timelines.length === 0) {
                    timelineContainer.innerHTML = `
                        <div style="color: var(--text-gray); font-size: 13px; text-align: center; padding: 12px 0;">
                            Tidak ada aktivitas tindak lanjut dalam rentang waktu yang dipilih.
                        </div>
                    `;
                    return;
                }

                timelines.forEach(t => {
                    const item = document.createElement('div');
                    item.className = `timeline-item status-${t.status}`;

                    const tlDate = new Date(t.tanggal);
                    const formattedDate = formatDateIndo(tlDate);

                    const code = t.laporan ? t.laporan.kode : '-';
                    const location = t.laporan ? `Kel. ${t.laporan.kelurahan}, Kec. ${t.laporan.kecamatan.replace('Petugas ', '')}` : '';

                    item.innerHTML = `
                        <div class="timeline-dot"></div>
                        <div class="timeline-header">
                            <span class="timeline-title">${t.deskripsi_aksi}</span>
                            <span class="timeline-date">${formattedDate}</span>
                        </div>
                        <div class="timeline-desc">${t.deskripsi_selesai || 'Sedang dikerjakan / perencanaan aksi lanjutan.'}</div>
                        <div class="timeline-meta">Terkait Laporan: ${code} (${location}) · Status: <strong>${t.status}</strong></div>
                    `;
                    timelineContainer.appendChild(item);
                });
            }

            // Export Action Handler
            btnExport.addEventListener('click', function() {
                const format = selectFormat.value;
                const filtered = filterData();

                if (format === 'PDF') {
                    // Export to PDF and download directly
                    const element = document.getElementById('preview-pane');
                    
                    // Create an invisible wrapper to house our clone without affecting screen layout
                    const wrapper = document.createElement('div');
                    wrapper.style.position = 'fixed';
                    wrapper.style.top = '0';
                    wrapper.style.left = '0';
                    wrapper.style.width = '1000px';
                    wrapper.style.height = '0';
                    wrapper.style.overflow = 'hidden';
                    wrapper.style.zIndex = '-9999';
                    
                    // Clone the element to avoid changing the visible screen content
                    const clone = element.cloneNode(true);
                    
                    // Copy canvas contents from original to clone
                    const originalCanvases = element.querySelectorAll('canvas');
                    const clonedCanvases = clone.querySelectorAll('canvas');
                    for (let i = 0; i < originalCanvases.length; i++) {
                        const destCtx = clonedCanvases[i].getContext('2d');
                        destCtx.drawImage(originalCanvases[i], 0, 0);
                    }

                    // Add printing class to apply clean styles
                    clone.classList.add('printing-pdf');
                    
                    // Append clone to wrapper, and wrapper to body
                    wrapper.appendChild(clone);
                    document.body.appendChild(wrapper);

                    const rangeVal = selectRange.value;
                    const dateStr = new Date().toISOString().slice(0,10);
                    const filename = `GWM_Laporan_Export_${rangeVal}_${dateStr}.pdf`;

                    const opt = {
                        margin:       [15, 15, 15, 15],
                        filename:     filename,
                        image:        { type: 'jpeg', quality: 0.98 },
                        html2canvas:  { scale: 2, useCORS: true, logging: false },
                        jsPDF:        { unit: 'mm', format: 'a4', orientation: 'landscape' },
                        pagebreak:    { mode: ['css', 'legacy'] }
                    };

                    // Run html2pdf and trigger download
                    html2pdf().set(opt).from(clone).save().then(() => {
                        // Remove wrapper and clone after rendering is finished
                        document.body.removeChild(wrapper);
                    }).catch(err => {
                        console.error(err);
                        if (wrapper.parentNode) {
                            document.body.removeChild(wrapper);
                        }
                    });
                } else if (format === 'Excel') {
                    // Export to Styled Excel format
                    exportToExcel(filtered);
                }
            });
            async function exportToExcel(data) {
                // Initialize workbook
                const workbook = new ExcelJS.Workbook();
                const worksheet = workbook.addWorksheet('Laporan GWM');

                // Define standard column widths
                worksheet.columns = [
                    { key: 'col1', width: 15 },
                    { key: 'col2', width: 22 },
                    { key: 'col3', width: 22 },
                    { key: 'col4', width: 25 },
                    { key: 'col5', width: 18 },
                    { key: 'col6', width: 15 },
                    { key: 'col7', width: 15 },
                    { key: 'col8', width: 15 }
                ];

                let currentRow = 1;

                const thinBorder = {
                    top: { style: 'thin', color: { argb: 'FFCBD5E1' } },
                    left: { style: 'thin', color: { argb: 'FFCBD5E1' } },
                    bottom: { style: 'thin', color: { argb: 'FFCBD5E1' } },
                    right: { style: 'thin', color: { argb: 'FFCBD5E1' } }
                };

                // 1. Title Header
                worksheet.mergeCells(`A${currentRow}:H${currentRow}`);
                const titleCell = worksheet.getCell(`A${currentRow}`);
                titleCell.value = 'GUNUNGKIDUL WATER MONITOR - LAPORAN KEKERINGAN';
                titleCell.font = { name: 'Segoe UI', size: 16, bold: true, color: { argb: 'FFFFFFFF' } };
                titleCell.fill = { type: 'pattern', pattern: 'solid', fgColor: { argb: 'FF2563EB' } };
                titleCell.alignment = { vertical: 'middle', horizontal: 'center' };
                worksheet.getRow(currentRow).height = 40;
                
                currentRow += 2; // Leave a blank row

                // 2. Metadata Information
                worksheet.getCell(`A${currentRow}`).value = 'Tanggal Cetak:';
                worksheet.getCell(`A${currentRow}`).font = { bold: true, color: { argb: 'FF475569' } };
                worksheet.getCell(`B${currentRow}`).value = labelExportDate.textContent;
                
                worksheet.getCell(`D${currentRow}`).value = 'Total Data:';
                worksheet.getCell(`D${currentRow}`).font = { bold: true, color: { argb: 'FF475569' } };
                worksheet.getCell(`E${currentRow}`).value = `${data.laporans.length} Laporan`;
                
                currentRow += 2;

                // Helper to style section headers
                function addSectionHeader(title) {
                    worksheet.mergeCells(`A${currentRow}:H${currentRow}`);
                    const secCell = worksheet.getCell(`A${currentRow}`);
                    secCell.value = '  ' + title;
                    secCell.font = { name: 'Segoe UI', size: 12, bold: true, color: { argb: 'FF0F172A' } };
                    secCell.fill = { type: 'pattern', pattern: 'solid', fgColor: { argb: 'FFE2E8F0' } };
                    secCell.alignment = { vertical: 'middle' };
                    worksheet.getRow(currentRow).height = 30;
                    currentRow++;
                }

                // 3. Ringkasan Eksekutif Section
                if (chkRingkasan.checked) {
                    addSectionHeader('RINGKASAN EKSEKUTIF');
                    
                    // Stats calculation
                    const total = data.laporans.length;
                    const kritis = data.laporans.filter(l => l.tingkat === 'Kritis').length;
                    const warga = data.laporans.reduce((sum, l) => sum + parseInt(l.warga_terdampak || 0), 0);
                    const selesai = data.laporans.filter(l => l.status === 'selesai').length;

                    // Row headers and values for stats
                    const statCols = [
                        { start: 'A', end: 'B', header: 'Total Laporan', value: total, fg: 'FFEFF6FF', fontColor: 'FF1E40AF' },
                        { start: 'C', end: 'D', header: 'Laporan Kritis', value: kritis, fg: 'FFFEF2F2', fontColor: 'FF991B1B' },
                        { start: 'E', end: 'F', header: 'Warga Terdampak (Jiwa)', value: warga, fg: 'FFFFF7ED', fontColor: 'FF9A3412' },
                        { start: 'G', end: 'H', header: 'Selesai Ditangani', value: selesai, fg: 'FFF0FDF4', fontColor: 'FF166534' }
                    ];

                    const headerFill = { type: 'pattern', pattern: 'solid', fgColor: { argb: 'FF3B82F6' } };
                    const headerFont = { name: 'Segoe UI', size: 10, bold: true, color: { argb: 'FFFFFFFF' } };

                    worksheet.getRow(currentRow).height = 25;
                    worksheet.getRow(currentRow + 1).height = 30;

                    statCols.forEach(box => {
                        // Merge headers
                        worksheet.mergeCells(`${box.start}${currentRow}:${box.end}${currentRow}`);
                        worksheet.getCell(`${box.start}${currentRow}`).value = box.header;

                        // Merge values
                        worksheet.mergeCells(`${box.start}${currentRow + 1}:${box.end}${currentRow + 1}`);
                        worksheet.getCell(`${box.start}${currentRow + 1}`).value = box.value;

                        // Apply styling & borders to ALL cells in the merged range
                        const startColIndex = box.start.charCodeAt(0) - 65 + 1;
                        const endColIndex = box.end.charCodeAt(0) - 65 + 1;

                        for (let c = startColIndex; c <= endColIndex; c++) {
                            const hCell = worksheet.getCell(currentRow, c);
                            hCell.font = headerFont;
                            hCell.fill = headerFill;
                            hCell.border = thinBorder;
                            hCell.alignment = { horizontal: 'center', vertical: 'middle', wrapText: true };

                            const vCell = worksheet.getCell(currentRow + 1, c);
                            vCell.font = { name: 'Segoe UI', size: 14, bold: true, color: { argb: box.fontColor } };
                            vCell.fill = { type: 'pattern', pattern: 'solid', fgColor: { argb: box.fg } };
                            vCell.border = thinBorder;
                            vCell.alignment = { horizontal: 'center', vertical: 'middle' };
                        }
                    });

                    currentRow += 2;
                    currentRow += 2;
                }

                // 4. Grafik & Statistik Section (Visual Charts)
                if (chkGrafik.checked) {
                    addSectionHeader('GRAFIK & STATISTIK VISUAL');

                    // Write titles for the charts in the cells above
                    worksheet.mergeCells(`A${currentRow}:C${currentRow}`);
                    const titleLeft = worksheet.getCell(`A${currentRow}`);
                    titleLeft.value = 'Proporsi Tingkat Kerawanan';
                    titleLeft.font = { name: 'Segoe UI', size: 11, bold: true, color: { argb: 'FF475569' } };
                    titleLeft.alignment = { vertical: 'middle', horizontal: 'left' };

                    worksheet.mergeCells(`E${currentRow}:H${currentRow}`);
                    const titleRight = worksheet.getCell(`E${currentRow}`);
                    titleRight.value = 'Dampak Warga Terbanyak per Kelurahan';
                    titleRight.font = { name: 'Segoe UI', size: 11, bold: true, color: { argb: 'FF475569' } };
                    titleRight.alignment = { vertical: 'middle', horizontal: 'left' };

                    worksheet.getRow(currentRow).height = 25;
                    currentRow++; // Move past the title row
                    
                    // We will embed both charts side by side
                    const proporsiCanvas = document.getElementById('proporsiChart');
                    const wargaCanvas = document.getElementById('wargaChart');

                    // Set height for chart row
                    const chartRowStart = currentRow;
                    
                    try {
                        const proporsiImg = proporsiCanvas.toDataURL('image/png');
                        const wargaImg = wargaCanvas.toDataURL('image/png');

                        const proporsiImgId = workbook.addImage({
                            base64: proporsiImg,
                            extension: 'png',
                        });

                        const wargaImgId = workbook.addImage({
                            base64: wargaImg,
                            extension: 'png',
                        });

                        // Place charts: Proporsi on A to C, Warga on E to H
                        worksheet.addImage(proporsiImgId, {
                            tl: { col: 0, row: chartRowStart }, // Column A
                            ext: { width: 320, height: 180 }
                        });

                        worksheet.addImage(wargaImgId, {
                            tl: { col: 4, row: chartRowStart }, // Column E
                            ext: { width: 400, height: 180 }
                        });
                    } catch (e) {
                        console.error('Failed to embed charts: ', e);
                    }

                    // Increment current row to account for chart height (~10 excel rows of height 20)
                    for (let r = chartRowStart; r < chartRowStart + 10; r++) {
                        worksheet.getRow(r).height = 20;
                    }
                    
                    // Write data tables beneath each chart showing details
                    const sed = data.laporans.filter(l => l.tingkat === 'Sedang').length;
                    const tng = data.laporans.filter(l => l.tingkat === 'Tinggi').length;
                    const krt = data.laporans.filter(l => l.tingkat === 'Kritis').length;

                    const kelMap = {};
                    data.laporans.forEach(l => {
                        if (l.kelurahan) {
                            kelMap[l.kelurahan] = (kelMap[l.kelurahan] || 0) + parseInt(l.warga_terdampak || 0);
                        }
                    });
                    const sortedKels = Object.keys(kelMap).map(k => ({
                        name: k,
                        value: kelMap[k]
                    })).sort((a, b) => b.value - a.value).slice(0, 5);

                    const tblRowStart = chartRowStart + 10;
                    
                    // --- Left Chart Data Table (Proporsi) ---
                    // Table header
                    worksheet.getCell(`A${tblRowStart}`).value = 'Tingkat Kerawanan';
                    worksheet.getCell(`B${tblRowStart}`).value = 'Jumlah';
                    [`A${tblRowStart}`, `B${tblRowStart}`].forEach(ref => {
                        const cell = worksheet.getCell(ref);
                        cell.font = { name: 'Segoe UI', size: 9, bold: true, color: { argb: 'FFFFFFFF' } };
                        cell.fill = { type: 'pattern', pattern: 'solid', fgColor: { argb: 'FF3B82F6' } };
                        cell.border = thinBorder;
                        cell.alignment = { horizontal: 'center', vertical: 'middle' };
                    });
                    worksheet.getRow(tblRowStart).height = 20;

                    // Table rows
                    const propData = [
                        { label: 'Sedang', val: sed, color: 'FFA16207' },
                        { label: 'Tinggi', val: tng, color: 'FFEA580C' },
                        { label: 'Kritis', val: krt, color: 'FFDC2626' }
                    ];

                    propData.forEach((item, index) => {
                        const r = tblRowStart + 1 + index;
                        worksheet.getCell(`A${r}`).value = item.label;
                        worksheet.getCell(`B${r}`).value = item.val;
                        
                        worksheet.getCell(`A${r}`).font = { name: 'Segoe UI', size: 9, bold: true, color: { argb: item.color } };
                        worksheet.getCell(`B${r}`).font = { name: 'Segoe UI', size: 9 };
                        
                        [`A${r}`, `B${r}`].forEach(ref => {
                            const cell = worksheet.getCell(ref);
                            cell.border = thinBorder;
                            cell.alignment = { horizontal: 'center', vertical: 'middle' };
                        });
                        worksheet.getRow(r).height = 18;
                    });


                    // --- Right Chart Data Table (Dampak Kelurahan) ---
                    // Table header
                    worksheet.getCell(`E${tblRowStart}`).value = 'Kelurahan';
                    worksheet.getCell(`F${tblRowStart}`).value = 'Warga Terdampak (Jiwa)';
                    [`E${tblRowStart}`, `F${tblRowStart}`].forEach(ref => {
                        const cell = worksheet.getCell(ref);
                        cell.font = { name: 'Segoe UI', size: 9, bold: true, color: { argb: 'FFFFFFFF' } };
                        cell.fill = { type: 'pattern', pattern: 'solid', fgColor: { argb: 'FF3B82F6' } };
                        cell.border = thinBorder;
                        cell.alignment = { horizontal: 'center', vertical: 'middle' };
                    });

                    if (sortedKels.length === 0) {
                        worksheet.getCell(`E${tblRowStart + 1}`).value = 'Data Kosong';
                        worksheet.getCell(`F${tblRowStart + 1}`).value = 0;
                        [`E${tblRowStart + 1}`, `F${tblRowStart + 1}`].forEach(ref => {
                            const cell = worksheet.getCell(ref);
                            cell.border = thinBorder;
                            cell.alignment = { horizontal: 'center', vertical: 'middle' };
                            cell.font = { name: 'Segoe UI', size: 9, italic: true };
                        });
                        worksheet.getRow(tblRowStart + 1).height = 18;
                    } else {
                        sortedKels.forEach((item, index) => {
                            const r = tblRowStart + 1 + index;
                            worksheet.getCell(`E${r}`).value = 'Kel. ' + item.name;
                            worksheet.getCell(`F${r}`).value = item.value;
                            
                            worksheet.getCell(`E${r}`).font = { name: 'Segoe UI', size: 9 };
                            worksheet.getCell(`F${r}`).font = { name: 'Segoe UI', size: 9, bold: true };
                            
                            [`E${r}`, `F${r}`].forEach(ref => {
                                const cell = worksheet.getCell(ref);
                                cell.border = thinBorder;
                                cell.alignment = { horizontal: 'center', vertical: 'middle' };
                            });
                            worksheet.getRow(r).height = 18;
                        });
                    }

                    currentRow += 17;
                    currentRow++; // space
                }

                // 5. Daftar Laporan Section
                if (chkLaporan.checked) {
                    addSectionHeader('DAFTAR LAPORAN KEKERINGAN');

                    // Headers
                    const headers = ["ID", "Kecamatan", "Kelurahan", "Kondisi Air", "Warga Terdampak", "Durasi (Hari)", "Tingkat", "Status"];
                    const headerRow = worksheet.getRow(currentRow);
                    headerRow.values = headers;
                    headerRow.height = 25;
                    
                    for (let c = 1; c <= 8; c++) {
                        const cell = headerRow.getCell(c);
                        cell.font = { name: 'Segoe UI', bold: true, color: { argb: 'FFFFFFFF' } };
                        cell.fill = { type: 'pattern', pattern: 'solid', fgColor: { argb: 'FF3B82F6' } };
                        cell.alignment = { vertical: 'middle', horizontal: (c === 5 || c === 6) ? 'right' : (c === 7 || c === 8 ? 'center' : 'left') };
                        cell.border = {
                            top: { style: 'thin', color: { argb: 'FFCBD5E1' } },
                            left: { style: 'thin', color: { argb: 'FFCBD5E1' } },
                            bottom: { style: 'thin', color: { argb: 'FFCBD5E1' } },
                            right: { style: 'thin', color: { argb: 'FFCBD5E1' } }
                        };
                    }
                    currentRow++;

                    if (data.laporans.length === 0) {
                        worksheet.mergeCells(`A${currentRow}:H${currentRow}`);
                        const emptyCell = worksheet.getCell(`A${currentRow}`);
                        emptyCell.value = 'Tidak ada data laporan.';
                        emptyCell.alignment = { horizontal: 'center', vertical: 'middle' };
                        emptyCell.font = { italic: true, color: { argb: 'FF64748B' } };
                        worksheet.getRow(currentRow).height = 25;
                        currentRow++;
                    } else {
                        data.laporans.forEach(l => {
                            const row = worksheet.getRow(currentRow);
                            let cleanKec = l.kecamatan.replace('Petugas ', '');
                            let statusLabel = l.status === 'selesai' ? 'Selesai' : (l.status === 'proses' ? 'Proses' : 'Diterima');

                            row.values = [
                                l.kode,
                                cleanKec,
                                'Kel. ' + l.kelurahan,
                                l.kondisi_air,
                                parseInt(l.warga_terdampak || 0),
                                parseInt(l.durasi_kekeringan || 0),
                                l.tingkat,
                                statusLabel
                            ];

                            // Alignment & borders
                            for (let c = 1; c <= 8; c++) {
                                const cell = row.getCell(c);
                                cell.font = { name: 'Segoe UI', size: 10 };
                                cell.alignment = { vertical: 'middle', horizontal: (c === 5 || c === 6) ? 'right' : (c === 7 || c === 8 ? 'center' : 'left') };
                                cell.border = {
                                    top: { style: 'thin', color: { argb: 'FFE2E8F0' } },
                                    left: { style: 'thin', color: { argb: 'FFE2E8F0' } },
                                    bottom: { style: 'thin', color: { argb: 'FFE2E8F0' } },
                                    right: { style: 'thin', color: { argb: 'FFE2E8F0' } }
                                };
                                
                                // Color conditions
                                if (c === 7) { // Tingkat
                                    if (l.tingkat === 'Kritis') cell.font = { name: 'Segoe UI', bold: true, color: { argb: 'FFDC2626' } };
                                    else if (l.tingkat === 'Tinggi') cell.font = { name: 'Segoe UI', bold: true, color: { argb: 'FFEA580C' } };
                                    else cell.font = { name: 'Segoe UI', bold: true, color: { argb: 'FFA16207' } };
                                }
                                if (c === 8) { // Status
                                    if (l.status === 'selesai') cell.font = { name: 'Segoe UI', bold: true, color: { argb: 'FF166534' } };
                                    else if (l.status === 'proses') cell.font = { name: 'Segoe UI', bold: true, color: { argb: 'FF1E40AF' } };
                                    else cell.font = { name: 'Segoe UI', bold: true, color: { argb: 'FF475569' } };
                                }
                            }
                            row.height = 22;
                            currentRow++;
                        });
                    }
                    currentRow += 2;
                }

                // 6. Timeline Aktivitas Section
                if (chkTimeline.checked) {
                    addSectionHeader('TIMELINE AKTIVITAS TINDAK LANJUT');

                    // Headers (using merges for columns since it has fewer headers)
                    worksheet.mergeCells(`A${currentRow}:B${currentRow}`); // Tanggal
                    worksheet.mergeCells(`C${currentRow}:D${currentRow}`); // Lokasi
                    worksheet.mergeCells(`E${currentRow}:F${currentRow}`); // Deskripsi Aksi
                    worksheet.mergeCells(`G${currentRow}:H${currentRow}`); // Keterangan Selesai / Status

                    worksheet.getCell(`A${currentRow}`).value = 'Tanggal';
                    worksheet.getCell(`C${currentRow}`).value = 'Lokasi Laporan';
                    worksheet.getCell(`E${currentRow}`).value = 'Deskripsi Aksi & Tindak Lanjut';
                    worksheet.getCell(`G${currentRow}`).value = 'Status & Keterangan Selesai';

                    [`A${currentRow}`, `C${currentRow}`, `E${currentRow}`, `G${currentRow}`].forEach(cellRef => {
                        const cell = worksheet.getCell(cellRef);
                        cell.font = { name: 'Segoe UI', bold: true, color: { argb: 'FFFFFFFF' } };
                        cell.fill = { type: 'pattern', pattern: 'solid', fgColor: { argb: 'FF3B82F6' } };
                        cell.alignment = { vertical: 'middle', horizontal: 'center' };
                    });
                    worksheet.getRow(currentRow).height = 25;
                    currentRow++;

                    if (data.timelines.length === 0) {
                        worksheet.mergeCells(`A${currentRow}:H${currentRow}`);
                        const emptyCell = worksheet.getCell(`A${currentRow}`);
                        emptyCell.value = 'Tidak ada data aktivitas tindak lanjut.';
                        emptyCell.alignment = { horizontal: 'center', vertical: 'middle' };
                        emptyCell.font = { italic: true, color: { argb: 'FF64748B' } };
                        worksheet.getRow(currentRow).height = 25;
                        currentRow++;
                    } else {
                        data.timelines.forEach(t => {
                            const tgl = new Date(t.tanggal).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
                            const location = t.laporan ? `Kel. ${t.laporan.kelurahan}, Kec. ${t.laporan.kecamatan.replace('Petugas ', '')}` : '-';

                            worksheet.mergeCells(`A${currentRow}:B${currentRow}`);
                            worksheet.mergeCells(`C${currentRow}:D${currentRow}`);
                            worksheet.mergeCells(`E${currentRow}:F${currentRow}`);
                            worksheet.mergeCells(`G${currentRow}:H${currentRow}`);

                            worksheet.getCell(`A${currentRow}`).value = tgl;
                            worksheet.getCell(`C${currentRow}`).value = location;
                            worksheet.getCell(`E${currentRow}`).value = t.deskripsi_aksi;
                            worksheet.getCell(`G${currentRow}`).value = `[${t.status}] ${t.deskripsi_selesai || '-'}`;

                            [`A${currentRow}`, `C${currentRow}`, `E${currentRow}`, `G${currentRow}`].forEach(cellRef => {
                                const cell = worksheet.getCell(cellRef);
                                cell.font = { name: 'Segoe UI', size: 9 };
                                cell.alignment = { vertical: 'middle', wrapText: true };
                                cell.border = {
                                    top: { style: 'thin', color: { argb: 'FFE2E8F0' } },
                                    left: { style: 'thin', color: { argb: 'FFE2E8F0' } },
                                    bottom: { style: 'thin', color: { argb: 'FFE2E8F0' } },
                                    right: { style: 'thin', color: { argb: 'FFE2E8F0' } }
                                };
                            });
                            worksheet.getRow(currentRow).height = 35;
                            currentRow++;
                        });
                    }
                }

                // Download Excel File
                const buffer = await workbook.xlsx.writeBuffer();
                const blob = new Blob([buffer], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
                const url = URL.createObjectURL(blob);
                const link = document.createElement("a");
                link.setAttribute("href", url);

                const rangeVal = selectRange.value;
                const dateStr = new Date().toISOString().slice(0, 10);
                const filename = `GWM_Laporan_Export_${rangeVal}_${dateStr}.xlsx`;

                link.setAttribute("download", filename);
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            }
        });
    </script>
</body>

</html>