@extends('layouts.app')

@section('content')
<style>
    .prescription-container {
        max-width: 850px;
        margin: 40px auto;
        padding: 0 20px;
    }
    /* Style Struk Seperti Bon */
    .struk-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 30px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
        border: 1px solid #e8ecf1;
        margin-bottom: 25px;
        position: relative;
        transition: transform 0.3s;
        max-width: 500px;
        margin-left: auto;
        margin-right: auto;
    }
    .struk-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 50px rgba(0, 0, 0, 0.12);
    }
    .struk-header {
        text-align: center;
        border-bottom: 2px dashed #e0e0e0;
        padding-bottom: 15px;
        margin-bottom: 15px;
    }
    .struk-logo {
        font-size: 28px;
        font-weight: 700;
        color: #667eea;
        letter-spacing: 2px;
    }
    .struk-logo i {
        margin-right: 10px;
    }
    .struk-sub {
        font-size: 11px;
        color: #999;
        text-transform: uppercase;
        letter-spacing: 2px;
    }
    .struk-address {
        font-size: 10px;
        color: #aaa;
        margin-top: 3px;
    }
    .struk-divider {
        border: none;
        border-top: 2px dashed #e0e0e0;
        margin: 12px 0;
    }
    .struk-row {
        display: flex;
        justify-content: space-between;
        font-size: 13px;
        padding: 4px 0;
    }
    .struk-row .label {
        color: #888;
        font-weight: 500;
    }
    .struk-row .value {
        font-weight: 600;
        color: #1a1a2e;
    }
    .struk-title {
        text-align: center;
        font-size: 18px;
        font-weight: 700;
        color: #1a1a2e;
        letter-spacing: 3px;
        text-transform: uppercase;
        margin: 10px 0;
    }
    .struk-obat-item {
        background: #f8f9fe;
        border-radius: 8px;
        padding: 10px 14px;
        margin-bottom: 8px;
        border-left: 3px solid #667eea;
    }
    .struk-obat-item .nama {
        font-weight: 600;
        color: #1a1a2e;
        font-size: 14px;
    }
    .struk-obat-item .aturan {
        font-size: 12px;
        color: #888;
    }
    .struk-footer {
        text-align: center;
        border-top: 2px dashed #e0e0e0;
        padding-top: 15px;
        margin-top: 15px;
        font-size: 11px;
        color: #999;
    }
    .struk-ttd {
        margin-top: 15px;
        text-align: center;
    }
    .struk-ttd .line {
        width: 120px;
        border-top: 1px solid #1a1a2e;
        margin: 25px auto 5px;
    }
    .struk-ttd .name {
        font-weight: 600;
        color: #1a1a2e;
        font-size: 13px;
    }
    .struk-ttd .title {
        font-size: 10px;
        color: #999;
    }
    .struk-badge {
        background: #e8f5e9;
        color: #2e7d32;
        padding: 2px 12px;
        border-radius: 10px;
        font-size: 10px;
        font-weight: 600;
    }
    .btn-pdf {
        background: linear-gradient(135deg, #dc3545, #a71d2a);
        border: none;
        padding: 6px 18px;
        border-radius: 20px;
        font-size: 12px;
        color: white;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .btn-pdf:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 20px rgba(220, 53, 69, 0.3);
        color: white;
    }
    .btn-print {
        background: transparent;
        border: 1px solid #667eea;
        padding: 6px 18px;
        border-radius: 20px;
        font-size: 12px;
        color: #667eea;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .btn-print:hover {
        background: #667eea;
        color: white;
    }
    /* Search */
    .search-box {
        max-width: 500px;
        margin: 0 auto 30px;
    }
    .search-box input {
        border-radius: 30px;
        padding: 12px 25px;
        border: 2px solid #e8ecf1;
        width: 100%;
        font-size: 14px;
        transition: all 0.3s;
    }
    .search-box input:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        outline: none;
    }
    .search-box .search-icon {
        position: relative;
    }
    .search-box .search-icon i {
        position: absolute;
        right: 20px;
        top: 50%;
        transform: translateY(-50%);
        color: #999;
    }
    .empty-state {
        text-align: center;
        padding: 50px 20px;
    }
    .empty-state .icon {
        font-size: 60px;
        color: #e0e0e0;
        margin-bottom: 15px;
    }
    .empty-state h5 {
        color: #555;
    }
    .empty-state p {
        color: #999;
    }
    @media (max-width: 576px) {
        .struk-card { padding: 20px; margin: 0 10px 20px; }
        .struk-row { font-size: 12px; flex-wrap: wrap; }
    }
    /* Badge status */
    .badge-status {
        font-size: 10px;
        padding: 3px 12px;
        border-radius: 12px;
        font-weight: 600;
    }
    .badge-status.active { background: #e8f5e9; color: #2e7d32; }
    .badge-status.inactive { background: #fbe9e7; color: #c62828; }
</style>

<div class="prescription-container">

    <!-- JUDUL + SEARCH -->
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
        <h4 class="fw-bold mb-0"><i class="fas fa-prescription-bottle text-primary me-2"></i> Resep Obat Digital</h4>
        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <!-- SEARCH BOX -->
    <div class="search-box">
        <div class="search-icon">
            <input type="text" id="searchResep" placeholder="🔍 Cari resep... (contoh: batuk, demam, OBH, Antihistamin)" onkeyup="filterResep()">
            <i class="fas fa-search"></i>
        </div>
    </div>

    @php
        $consultations = App\Models\Consultation::where('patient_id', Auth::id())
            ->whereNotNull('ai_response')
            ->orWhereHas('medicalRecord', function($q) {
                $q->whereNotNull('prescription');
            })
            ->orderBy('created_at', 'desc')
            ->get();
    @endphp

    <div id="resepContainer">
        @forelse($consultations as $consultation)
            @php
                $resep = $consultation->medicalRecord->prescription ?? $consultation->ai_response ?? '';
                $obatList = [];
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
                // Ambil keyword untuk search
                $searchText = $consultation->complaint . ' ' . $resep . ' ' . $consultation->code;
                foreach ($obatList as $obat) {
                    $searchText .= ' ' . $obat;
                }
                $searchText = strtolower($searchText);
            @endphp

            <div class="struk-card resep-item" data-search="{{ $searchText }}">
                <!-- HEADER STRUK -->
                <div class="struk-header">
                    <div class="struk-logo">
                        <i class="fas fa-stethoscope"></i> SEHAT KILAT
                    </div>
                    <div class="struk-sub">Konsultasi Kesehatan Online</div>
                    <div class="struk-address">Jl. Kesehatan No. 1, Jakarta</div>
                </div>

                <!-- TITLE -->
                <div class="struk-title">RESEP OBAT</div>

                <!-- INFO -->
                <div class="struk-row">
                    <span class="label">No. Resep</span>
                    <span class="value">{{ $consultation->code }}</span>
                </div>
                <div class="struk-row">
                    <span class="label">Tanggal</span>
                    <span class="value">{{ $consultation->created_at->format('d F Y') }}</span>
                </div>
                <div class="struk-row">
                    <span class="label">Pasien</span>
                    <span class="value">{{ $consultation->patient->name ?? 'Pasien' }}</span>
                </div>
                <div class="struk-row">
                    <span class="label">Dokter</span>
                    <span class="value">{{ $consultation->doctor->name ?? 'AI SEHAT KILAT' }}</span>
                </div>
                <div class="struk-row">
                    <span class="label">Status</span>
                    <span class="value"><span class="badge-status active">✓ Aktif</span></span>
                </div>

                <hr class="struk-divider">

                <!-- KELUHAN -->
                <div style="background:#f8f9fe; padding:10px 14px; border-radius:8px; margin-bottom:12px;">
                    <div style="font-size:10px; color:#999; text-transform:uppercase; font-weight:600;">📋 Keluhan</div>
                    <div style="font-size:13px; color:#333;">"{{ \Illuminate\Support\Str::limit($consultation->complaint, 80) }}"</div>
                </div>

                <!-- DAFTAR OBAT -->
                <div style="font-size:11px; font-weight:700; color:#667eea; text-transform:uppercase; margin-bottom:8px;">💊 Daftar Obat</div>
                @foreach($obatList as $obat)
                    @php
                        $namaObat = $obat;
                        $aturan = 'Ikuti petunjuk dokter';
                        if (strpos($obat, ':') !== false) {
                            $parts = explode(':', $obat, 2);
                            $namaObat = trim($parts[0]);
                            $aturan = trim($parts[1]);
                        }
                    @endphp
                    <div class="struk-obat-item">
                        <div class="nama">{{ $namaObat }}</div>
                        <div class="aturan">📌 {{ $aturan }}</div>
                    </div>
                @endforeach

                <!-- CATATAN KHUSUS -->
                @if(strpos($resep, '⚠️') !== false)
                    <hr class="struk-divider">
                    <div style="background:#fff8e1; padding:10px 14px; border-radius:8px; border-left:3px solid #ffc107; font-size:12px; color:#555;">
                        <strong style="color:#1a1a2e;">⚠️ Catatan:</strong>
                        {{ strip_tags(explode('⚠️', $resep)[1] ?? '') }}
                    </div>
                @endif

                <hr class="struk-divider">

                <!-- FOOTER + TTD -->
                <div class="struk-ttd">
                    <div class="line"></div>
                    <div class="name">{{ $consultation->doctor->name ?? 'AI SEHAT KILAT' }}</div>
                    <div class="title">Dokter Penanggung Jawab</div>
                </div>

                <div class="struk-footer">
                    <div>📅 Resep berlaku 30 hari</div>
                    <div style="margin-top:3px;">🏥 SEHAT KILAT • 2026</div>
                    <div style="margin-top:5px; font-size:9px; color:#ccc;">Dicetak: {{ now()->format('d/m/Y H:i') }}</div>
                </div>

                <!-- TOMBOL AKSI -->
                <div class="d-flex justify-content-center gap-2 mt-3">
                    <a href="{{ route('ai-consultations.export-pdf', $consultation->id) }}" class="btn-pdf" target="_blank">
                        <i class="fas fa-file-pdf"></i> PDF
                    </a>
                    <a href="#" class="btn-print" onclick="window.print()">
                        <i class="fas fa-print"></i> Cetak
                    </a>
                </div>
            </div>

        @empty
            <div class="empty-state">
                <div class="icon"><i class="fas fa-prescription-bottle"></i></div>
                <h5>Belum Ada Resep Obat</h5>
                <p>Lakukan konsultasi dengan dokter untuk mendapatkan resep obat digital.</p>
                <a href="{{ route('ai-consultations.create') }}" class="btn btn-primary mt-2">
                    <i class="fas fa-plus me-2"></i> Konsultasi Sekarang
                </a>
            </div>
        @endforelse
    </div>
</div>

<script>
function filterResep() {
    let input = document.getElementById('searchResep').value.toLowerCase();
    let items = document.querySelectorAll('.resep-item');

    items.forEach(item => {
        let searchData = item.getAttribute('data-search').toLowerCase();
        if (searchData.includes(input)) {
            item.style.display = 'block';
        } else {
            item.style.display = 'none';
        }
    });
}
</script>
@endsection