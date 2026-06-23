<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Data Laporan KTH</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #0E4C34;
            padding-bottom: 10px;
        }

        .header h1 {
            color: #0E4C34;
            font-size: 18px;
            margin: 0;
        }

        .header p {
            color: #666;
            font-size: 12px;
            margin: 5px 0 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th {
            background-color: #0E4C34;
            color: white;
            padding: 8px 6px;
            text-align: left;
            font-size: 9px;
            text-transform: uppercase;
        }

        td {
            padding: 6px;
            border-bottom: 1px solid #ddd;
            font-size: 9px;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 10px;
            color: #999;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }

        .badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 8px;
            font-weight: bold;
        }

        .badge-verified {
            background-color: #d4edda;
            color: #155724;
        }

        .badge-pending {
            background-color: #fff3cd;
            color: #856404;
        }

        .badge-rejected {
            background-color: #f8d7da;
            color: #721c24;
        }

        .badge-aktif {
            background-color: #d4edda;
            color: #155724;
        }

        .badge-tidak-aktif {
            background-color: #e2e3e5;
            color: #383d41;
        }

        .text-center {
            text-align: center;
        }

        .text-muted {
            color: #999;
        }

        .mt-2 {
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>LAPORAN DATA KELOMPOK TANI HUTAN (KTH)</h1>
        <p>Periode: {{ now()->format('d F Y') }}</p>
        <p>Total Data: {{ count($data) }} Laporan</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 4%;">No</th>
                <th style="width: 15%;">Nama KTH</th>
                <th style="width: 12%;">Jenis Usaha</th>
                <th style="width: 10%;">Periode</th>
                <th style="width: 10%;">Status</th>
                <th style="width: 12%;">Penyuluh</th>
                <th style="width: 12%;">Produksi</th>
                <th style="width: 15%;">NTE/Bulan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $index => $laporan)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td><strong>{{ $laporan->kth->nama_kth ?? '-' }}</strong></td>
                    <td>{{ $laporan->jenis_usaha ?? '-' }}</td>
                    <td>{{ $laporan->periode_laporan ? $laporan->periode_laporan->format('M Y') : '-' }}</td>
                    <td>
                        @if (($laporan->status_verifikasi ?? '') == 'verified')
                            <span class="badge badge-verified">Verified</span>
                        @elseif(($laporan->status_verifikasi ?? '') == 'pending')
                            <span class="badge badge-pending">Pending</span>
                        @else
                            <span class="badge badge-rejected">Rejected</span>
                        @endif
                    </td>
                    <td>{{ $laporan->penyuluh->nama_lengkap ?? '-' }}</td>
                    <td>{{ $laporan->potensi_produksi ?? '-' }} {{ $laporan->satuan_produksi ?? '' }}</td>
                    <td>Rp {{ number_format($laporan->nte_per_bulan ?? 0, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Dokumen ini dibuat secara otomatis oleh Sistem SI-KTH pada {{ now()->format('d/m/Y H:i:s') }}</p>
        <p>© {{ now()->year }} SI-KTH - Manajemen Kelompok Tani Hutan</p>
    </div>
</body>

</html>
