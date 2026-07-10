<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Konsultasi</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header { text-align: center; border-bottom: 2px solid #dc3545; padding-bottom: 10px; }
        .header h2 { color: #dc3545; margin: 0; }
        .stats { margin: 20px 0; }
        .stats table { width: 100%; }
        .stats td { padding: 5px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #dc3545; color: white; }
        .footer { text-align: center; margin-top: 20px; font-size: 10px; color: #999; }
    </style>
</head>
<body>
    <div class="header">
        <h2>SEHAT KILAT</h2>
        <p>Laporan Konsultasi</p>
        <p>Tanggal: {{ date('d F Y') }}</p>
    </div>

    <div class="stats">
        <table>
            <tr>
                <td><strong>Total Pasien:</strong> {{ $totalPatients }}</td>
                <td><strong>Total Dokter:</strong> {{ $totalDoctors }}</td>
            </tr>
            <tr>
                <td><strong>Total Konsultasi:</strong> {{ $totalConsultations }}</td>
                <td><strong>Total Pendapatan:</strong> Rp {{ number_format($totalRevenue, 0, ',', '.') }}</td>
            </tr>
        </table>
    </div>

    <table>
        <thead>
            <tr>
                <th>Kode</th>
                <th>Pasien</th>
                <th>Dokter</th>
                <th>Keluhan</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Biaya</th>
            </tr>
        </thead>
        <tbody>
            @foreach($consultations as $cons)
            <tr>
                <td>{{ $cons->code }}</td>
                <td>{{ $cons->patient->name ?? '-' }}</td>
                <td>{{ $cons->doctor->name ?? '-' }}</td>
                <td>{{ Str::limit($cons->complaint, 30) }}</td>
                <td>{{ $cons->consultation_date }}</td>
                <td>{{ $cons->status }}</td>
                <td>Rp {{ number_format($cons->fee, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak pada: {{ date('d/m/Y H:i') }}</p>
        <p>© 2026 KEMENTERIAN KESEHATAN - SEHAT KILAT</p>
    </div>
</body>
</html>