<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Resep Obat - SEHAT KILAT</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Times New Roman', Arial, sans-serif;
            background: white;
            padding: 30px;
        }
        .resep-container {
            max-width: 700px;
            margin: 0 auto;
            border: 2px solid #1a1a2e;
            padding: 30px;
            border-radius: 12px;
            background: #fff;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            border-bottom: 3px double #1a1a2e;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .header .logo {
            font-size: 28px;
            font-weight: 700;
            color: #667eea;
            letter-spacing: 2px;
        }
        .header .logo i {
            margin-right: 10px;
        }
        .header .sub {
            font-size: 12px;
            color: #888;
            letter-spacing: 3px;
            text-transform: uppercase;
        }
        .header .alamat {
            font-size: 11px;
            color: #999;
            margin-top: 3px;
        }
        .resep-title {
            text-align: center;
            font-size: 22px;
            font-weight: 700;
            color: #1a1a2e;
            margin: 15px 0;
            letter-spacing: 5px;
            text-transform: uppercase;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px 30px;
            margin: 15px 0;
            padding: 12px 15px;
            background: #f8f9fe;
            border-radius: 8px;
        }
        .info-grid .label {
            font-size: 12px;
            color: #888;
            font-weight: 600;
            text-transform: uppercase;
        }
        .info-grid .value {
            font-size: 14px;
            font-weight: 600;
            color: #1a1a2e;
        }
        .info-grid .value-sm {
            font-size: 14px;
            color: #333;
        }
        .obat-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        .obat-table th {
            background: #1a1a2e;
            color: white;
            padding: 10px 12px;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .obat-table td {
            padding: 10px 12px;
            border-bottom: 1px solid #eee;
            font-size: 13px;
            vertical-align: top;
        }
        .obat-table tr:last-child td {
            border-bottom: none;
        }
        .obat-table .no {
            width: 30px;
            text-align: center;
        }
        .obat-table .nama-obat {
            font-weight: 600;
            color: #1a1a2e;
        }
        .obat-table .aturan {
            font-size: 12px;
            color: #555;
        }
        .footer-resep {
            margin-top: 20px;
            padding-top: 15px;
            border-top: 1px dashed #ddd;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }
        .footer-resep .ttd {
            text-align: center;
        }
        .footer-resep .ttd .line {
            width: 150px;
            border-top: 1px solid #1a1a2e;
            margin-top: 30px;
        }
        .footer-resep .ttd .name {
            font-size: 14px;
            font-weight: 600;
            color: #1a1a2e;
            margin-top: 5px;
        }
        .footer-resep .ttd .title {
            font-size: 11px;
            color: #888;
        }
        .footer-resep .info-resep {
            font-size: 11px;
            color: #999;
            text-align: right;
        }
        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 80px;
            color: rgba(102, 126, 234, 0.06);
            font-weight: 700;
            letter-spacing: 10px;
            pointer-events: none;
            z-index: 0;
        }
        .catatan {
            background: #fff8e1;
            padding: 10px 15px;
            border-radius: 8px;
            border-left: 4px solid #ffc107;
            font-size: 12px;
            color: #555;
            margin-top: 15px;
        }
        .catatan strong {
            color: #1a1a2e;
        }
        .no-resep {
            text-align: center;
            font-size: 12px;
            color: #999;
            margin-top: 10px;
        }
        @media print {
            body { padding: 10px; }
            .resep-container { box-shadow: none; border-color: #333; }
        }
    </style>
</head>
<body>

<div class="watermark">SEHAT KILAT</div>

<div class="resep-container">
    <!-- HEADER -->
    <div class="header">
        <div class="logo">
            <i class="fas fa-stethoscope"></i> SEHAT KILAT
        </div>
        <div class="sub">Konsultasi Kesehatan Online</div>
        <div class="alamat">Jl. Kesehatan No. 1, Jakarta • Telp: (021) 1234-5678</div>
    </div>

    <!-- TITLE -->
    <div class="resep-title">RESEP OBAT</div>

    <!-- INFO PASIEN & DOKTER -->
    <div class="info-grid">
        <div><span class="label">No. Resep</span><br><span class="value">{{ $consultation->code }}</span></div>
        <div><span class="label">Tanggal</span><br><span class="value">{{ $consultation->created_at->format('d F Y') }}</span></div>
        <div><span class="label">Nama Pasien</span><br><span class="value">{{ $consultation->patient->name ?? 'Pasien' }}</span></div>
        <div><span class="label">Dokter</span><br><span class="value">{{ $consultation->doctor->name ?? 'AI SEHAT KILAT' }}</span></div>
        <div><span class="label">Spesialis</span><br><span class="value-sm">{{ $consultation->doctor->specialist ?? 'Konsultasi AI' }}</span></div>
        <div><span class="label">Status</span><br><span class="value-sm">{{ ucfirst($consultation->status) }}</span></div>
    </div>

    <!-- KELUHAN -->
    <div style="margin:10px 0; padding:10px 15px; background:#f0f4ff; border-radius:8px; font-size:13px; color:#333;">
        <strong>📋 Keluhan:</strong> "{{ $consultation->complaint }}"
    </div>

    <!-- DAFTAR OBAT -->
    <table class="obat-table">
        <thead>
            <tr>
                <th class="no">#</th>
                <th>Nama Obat</th>
                <th>Dosis</th>
                <th>Aturan Pakai</th>
            </tr>
        </thead>
        <tbody>
            @php
                $obatList = [];
                $resep = $consultation->ai_response ?? '';
                if (strpos($resep, 'Obat yang bisa dikonsumsi:') !== false) {
                    $parts = explode('Obat yang bisa dikonsumsi:', $resep);
                    if (isset($parts[1])) {
                        $obatPart = explode('⚠️', $parts[1])[0];
                        $lines = explode('-', $obatPart);
                        foreach ($lines as $line) {
                            $line = trim($line);
                            if (!empty($line) && strlen($line) > 3) {
                                $obatList[] = $line;
                            }
                        }
                    }
                }
                if (empty($obatList) && !empty($resep)) {
                    $obatList = [trim($resep)];
                }
                $counter = 1;
            @endphp
            @foreach($obatList as $obat)
                @php
                    $namaObat = $obat;
                    $dosis = '-';
                    $aturan = 'Ikuti petunjuk dokter';
                    if (strpos($obat, ':') !== false) {
                        $parts = explode(':', $obat, 2);
                        $namaObat = trim($parts[0]);
                        $aturan = trim($parts[1]);
                    }
                    if (preg_match('/(\d+)\s*[x×]\s*(\d+)/i', $aturan, $matches)) {
                        $dosis = $matches[0];
                    }
                @endphp
                <tr>
                    <td class="no">{{ $counter++ }}</td>
                    <td class="nama-obat">{{ $namaObat }}</td>
                    <td>{{ $dosis }}</td>
                    <td class="aturan">{{ $aturan }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- CATATAN KHUSUS -->
    @if(strpos($resep, '⚠️') !== false)
        <div class="catatan">
            <strong><i class="fas fa-exclamation-triangle"></i> Catatan:</strong>
            {{ strip_tags(explode('⚠️', $resep)[1] ?? '') }}
        </div>
    @endif

    <!-- FOOTER -->
    <div class="footer-resep">
        <div class="ttd">
            <div class="line"></div>
            <div class="name">{{ $consultation->doctor->name ?? 'AI SEHAT KILAT' }}</div>
            <div class="title">Dokter Penanggung Jawab</div>
        </div>
        <div class="info-resep">
            <div>📅 Resep berlaku 30 hari</div>
            <div style="margin-top:5px;">🏥 SEHAT KILAT • 2026</div>
        </div>
    </div>

    <div class="no-resep">
        Resep ini hanya untuk pasien atas nama {{ $consultation->patient->name ?? 'Pasien' }}
    </div>
</div>

</body>
</html>