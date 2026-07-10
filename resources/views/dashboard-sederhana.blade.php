@extends('layouts.app')

@section('content')
<style>
    .hero-dashboard {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 20px;
        padding: 40px;
        color: white;
        margin-bottom: 30px;
    }
    .stat-box {
        background: white;
        border-radius: 15px;
        padding: 20px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        text-align: center;
        transition: transform 0.3s;
        border-left: 4px solid #667eea;
    }
    .stat-box:hover {
        transform: translateY(-5px);
    }
    .stat-box .icon {
        font-size: 30px;
        color: #667eea;
        margin-bottom: 10px;
    }
    .stat-box .number {
        font-size: 28px;
        font-weight: bold;
        color: #333;
    }
    .stat-box .label {
        color: #888;
        font-size: 14px;
    }
    .menu-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-top: 20px;
    }
    .menu-card {
        background: white;
        border-radius: 15px;
        padding: 25px;
        text-align: center;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        transition: transform 0.3s;
        text-decoration: none;
        color: #333;
        border: 1px solid #f0f0f0;
    }
    .menu-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.2);
        border-color: #667eea;
    }
    .menu-card i {
        font-size: 35px;
        color: #667eea;
        margin-bottom: 10px;
    }
    .menu-card h6 {
        font-weight: 600;
        margin-bottom: 5px;
    }
    .menu-card p {
        font-size: 13px;
        color: #888;
        margin-bottom: 0;
    }
    .history-item {
        background: white;
        border-radius: 12px;
        padding: 15px 20px;
        margin-bottom: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        border-left: 4px solid #667eea;
    }
    .badge-status {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
    }
    .badge-status.completed { background: #d4edda; color: #155724; }
    .badge-status.pending { background: #fff3cd; color: #856404; }
</style>

<div class="container">
    <!-- Hero / Welcome -->
    <div class="hero-dashboard">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h2><i class="fas fa-crown me-2"></i> Halo, {{ Auth::user()->name }}!</h2>
                <p class="mb-0">Selamat datang di SEHAT KILAT. Konsultasi kesehatan jadi lebih mudah dan cepat.</p>
            </div>
            <div class="col-md-4 text-end">
                <span class="badge bg-light text-primary p-2 px-3 rounded-pill">
                    <i class="fas fa-star me-1"></i> Premium Member
                </span>
            </div>
        </div>
    </div>

    <!-- Statistik -->
    <div class="row mb-4">
        <div class="col-md-3 col-6 mb-3">
            <div class="stat-box">
                <div class="icon"><i class="fas fa-calendar-check"></i></div>
                <div class="number" id="total-konsultasi">0</div>
                <div class="label">Total Konsultasi</div>
            </div>
        </div>
        <div class="col-md-3 col-6 mb-3">
            <div class="stat-box" style="border-left-color: #f093fb;">
                <div class="icon" style="color: #f093fb;"><i class="fas fa-hourglass-half"></i></div>
                <div class="number" id="pending-konsultasi">0</div>
                <div class="label">Menunggu</div>
            </div>
        </div>
        <div class="col-md-3 col-6 mb-3">
            <div class="stat-box" style="border-left-color: #43e97b;">
                <div class="icon" style="color: #43e97b;"><i class="fas fa-check-circle"></i></div>
                <div class="number" id="selesai-konsultasi">0</div>
                <div class="label">Selesai</div>
            </div>
        </div>
        <div class="col-md-3 col-6 mb-3">
            <div class="stat-box" style="border-left-color: #fa709a;">
                <div class="icon" style="color: #fa709a;"><i class="fas fa-money-bill"></i></div>
                <div class="number" id="total-biaya">Rp 0</div>
                <div class="label">Total Biaya</div>
            </div>
        </div>
    </div>

    <!-- Menu Cepat -->
    <div class="row mb-4">
        <div class="col-12">
            <h5 class="mb-3"><i class="fas fa-th-large me-2"></i> Menu Cepat</h5>
            <div class="menu-grid">
                <a href="{{ route('ai-consultations.create') }}" class="menu-card">
                    <i class="fas fa-robot"></i>
                    <h6>Konsultasi AI</h6>
                    <p>Gratis • Dijawab AI</p>
                </a>
                <a href="{{ route('doctor-consultations.create') }}" class="menu-card">
                    <i class="fas fa-video"></i>
                    <h6>Konsultasi Dokter</h6>
                    <p>Rp 150.000 • Video Call</p>
                </a>
                <a href="{{ url('/prescriptions') }}" class="menu-card">
                    <i class="fas fa-prescription-bottle"></i>
                    <h6>Resep Obat Digital</h6>
                    <p>Lihat resep Anda</p>
                </a>
                <a href="{{ url('/medical-records') }}" class="menu-card">
                    <i class="fas fa-notes-medical"></i>
                    <h6>Rekam Medis Online</h6>
                    <p>Riwayat kesehatan</p>
                </a>
            </div>
        </div>
    </div>

    <!-- Riwayat Konsultasi -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0"><i class="fas fa-history me-2 text-primary"></i> Riwayat Konsultasi Terbaru</h5>
                </div>
                <div class="card-body" id="riwayat-container">
                    <div class="text-center py-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2">Memuat riwayat...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    function formatRupiah(angka) {
        return new Intl.NumberFormat('id-ID').format(angka);
    }

    fetch('/api/consultation-stats')
        .then(response => response.json())
        .then(data => {
            document.getElementById('total-konsultasi').innerText = data.total;
            document.getElementById('pending-konsultasi').innerText = data.pending;
            document.getElementById('selesai-konsultasi').innerText = data.completed;
            document.getElementById('total-biaya').innerHTML = 'Rp ' + formatRupiah(data.total_spent);
        })
        .catch(error => console.log('Error:', error));

    fetch('/api/recent-consultations')
        .then(response => response.json())
        .then(data => {
            const container = document.getElementById('riwayat-container');
            if (data.length === 0) {
                container.innerHTML = `
                    <div class="text-center py-4">
                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                        <p>Belum ada riwayat konsultasi</p>
                        <a href="{{ route('ai-consultations.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Buat Konsultasi AI
                        </a>
                    </div>
                `;
            } else {
                let html = '';
                data.forEach(cons => {
                    let statusClass = cons.status === 'completed' ? 'completed' : 'pending';
                    let statusText = cons.status === 'completed' ? 'Selesai' : 'Menunggu';
                    let typeIcon = cons.type === 'ai' ? 'fa-robot' : 'fa-video';
                    let typeText = cons.type === 'ai' ? 'Konsultasi AI' : 'Konsultasi Dokter';
                    let linkUrl = cons.type === 'ai' ? '/ai-consultations/' + cons.id : '#';
                    
                    html += `
                        <a href="${linkUrl}" class="history-item text-decoration-none d-block">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="fas ${typeIcon} text-primary me-2"></i>
                                    <strong>${typeText}</strong>
                                    <span class="ms-2 text-muted small">${cons.date}</span>
                                </div>
                                <span class="badge-status ${statusClass}">${statusText}</span>
                            </div>
                            <p class="mb-0 text-muted small mt-1">${cons.complaint.substring(0, 80)}${cons.complaint.length > 80 ? '...' : ''}</p>
                        </a>
                    `;
                });
                container.innerHTML = html;
            }
        })
        .catch(error => console.log('Error:', error));
});
</script>
@endsection