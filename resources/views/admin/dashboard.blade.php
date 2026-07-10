@extends('layouts.app')

@section('content')
<div class="row">
    <!-- Sidebar Admin -->
    <div class="col-md-3 mb-4">
        <div class="card shadow-sm border-danger">
            <div class="card-body text-center">
                <div class="mb-3">
                    <div class="bg-gradient-danger text-white rounded-circle d-inline-flex align-items-center justify-content-center" 
                         style="width: 80px; height: 80px; font-size: 32px; background: linear-gradient(135deg, #dc3545, #ff6b6b);">
                        <i class="fas fa-user-shield"></i>
                    </div>
                </div>
                <h5 class="text-danger">{{ Auth::user()->name }}</h5>
                <p class="text-muted small"><span class="badge bg-danger">Administrator</span></p>
                <hr>
                <div class="list-group list-group-flush text-start">
                    <a href="{{ route('admin.dashboard') }}" class="list-group-item list-group-item-action active bg-danger text-white border-0">
                        <i class="fas fa-tachometer-alt me-2"></i> Dashboard Admin
                    </a>
                    <a href="{{ route('admin.patients.index') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-users me-2"></i> Manajemen User
                    </a>
                    <a href="{{ route('admin.doctors.index') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-user-md me-2"></i> Manajemen Dokter
                    </a>
                    <a href="{{ route('admin.categories.index') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-tags me-2"></i> Kategori
                    </a>
                    <a href="{{ route('admin.transactions.index') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-credit-card me-2"></i> Transaksi
                    </a>
                    <a href="{{ route('admin.reports.index') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-file-alt me-2"></i> Laporan
                    </a>
                    <a href="{{ route('admin.consultations.index') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-calendar-check me-2"></i> Konsultasi
                    </a>
                    <a href="{{ route('admin.settings.index') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-cog me-2"></i> Pengaturan
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Admin -->
    <div class="col-md-9">
        <div class="card mb-4" style="background: linear-gradient(135deg, #dc3545, #a71d2a, #ff6b6b);">
            <div class="card-body text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3><i class="fas fa-crown me-2"></i> Dashboard Administrator</h3>
                        <p class="mb-0">Selamat datang di panel admin SEHAT KILAT. Kelola seluruh sistem di sini.</p>
                    </div>
                    <div>
                        <span class="badge bg-light text-danger p-2 fs-6">
                            <i class="fas fa-calendar-alt me-1"></i> {{ date('d F Y') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #007bff, #0056b3);">
                    <div class="card-body text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-white-50">Total User</small>
                                <h2 class="mb-0" id="total-user">0</h2>
                            </div>
                            <i class="fas fa-users fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #17a2b8, #0f6674);">
                    <div class="card-body text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-white-50">Total Dokter</small>
                                <h2 class="mb-0" id="total-dokter">0</h2>
                            </div>
                            <i class="fas fa-user-md fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #28a745, #1e7e34);">
                    <div class="card-body text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-white-50">Total Konsultasi</small>
                                <h2 class="mb-0" id="total-konsultasi">0</h2>
                            </div>
                            <i class="fas fa-calendar-check fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #ffc107, #d39e00);">
                    <div class="card-body text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-white-50">Total Pendapatan</small>
                                <h4 class="mb-0" id="total-pendapatan">Rp 0</h4>
                            </div>
                            <i class="fas fa-money-bill fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header" style="background: linear-gradient(135deg, #dc3545, #a71d2a);">
                        <h5 class="mb-0 text-white"><i class="fas fa-chart-line me-2"></i> Grafik Konsultasi per Bulan (2026)</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="consultationChart" height="120"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-header" style="background: linear-gradient(135deg, #dc3545, #a71d2a);">
                        <h5 class="mb-0 text-white"><i class="fas fa-info-circle me-2"></i> Info Sistem</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="fas fa-circle text-success me-2"></i> <strong>User Aktif:</strong> <span id="total-user-aktif">0</span></li>
                            <li class="mb-2"><i class="fas fa-circle text-success me-2"></i> <strong>Selesai:</strong> <span id="total-selesai">0</span></li>
                            <li class="mb-2"><i class="fas fa-circle text-warning me-2"></i> <strong>Menunggu:</strong> <span id="total-menunggu">0</span></li>
                            <li class="mb-2"><i class="fas fa-circle text-danger me-2"></i> <strong>Dibatalkan:</strong> <span id="total-batal">0</span></li>
                            <li><i class="fas fa-calendar-alt text-primary me-2"></i> <strong>Hari Ini:</strong> {{ date('d/m/Y') }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header" style="background: linear-gradient(135deg, #dc3545, #a71d2a);">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-white"><i class="fas fa-list me-2"></i> Konsultasi Terbaru</h5>
                    <span class="badge bg-light text-danger">{{ App\Models\Consultation::count() }} Total</span>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead style="background: linear-gradient(135deg, #dc3545, #a71d2a); color: white;">
                            <tr>
                                <th>Kode</th>
                                <th>Pasien</th>
                                <th>Dokter</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="konsultasi-table">
                            <tr><td colspan="5" class="text-center">Loading...</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    function formatRupiah(angka) {
        return new Intl.NumberFormat('id-ID').format(angka);
    }

    fetch('/api/admin-stats')
        .then(response => response.json())
        .then(data => {
            document.getElementById('total-user').innerText = data.total_patients;
            document.getElementById('total-dokter').innerText = data.total_doctors;
            document.getElementById('total-konsultasi').innerText = data.total_consultations;
            document.getElementById('total-pendapatan').innerHTML = 'Rp ' + formatRupiah(data.total_revenue);
            document.getElementById('total-user-aktif').innerText = data.total_patients;
            document.getElementById('total-selesai').innerText = data.completed || 0;
            document.getElementById('total-menunggu').innerText = data.pending || 0;
            document.getElementById('total-batal').innerText = data.cancelled || 0;
            
            const ctx = document.getElementById('consultationChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: data.months,
                    datasets: [{
                        label: 'Jumlah Konsultasi',
                        data: data.totals,
                        backgroundColor: 'rgba(220, 53, 69, 0.7)',
                        borderColor: '#dc3545',
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: { legend: { display: false } }
                }
            });

            let html = '';
            if (data.recent_consultations && data.recent_consultations.length > 0) {
                data.recent_consultations.forEach(cons => {
                    let statusClass = cons.status === 'completed' ? 'bg-success' : 
                                    cons.status === 'pending' ? 'bg-warning' : 
                                    cons.status === 'cancelled' ? 'bg-danger' : 'bg-secondary';
                    html += `
                        <tr>
                            <td><span class="badge bg-secondary">${cons.code}</span></td>
                            <td>${cons.patient}</td>
                            <td>${cons.doctor}</td>
                            <td>${cons.date}</td>
                            <td><span class="badge ${statusClass}">${cons.status}</span></td>
                        </tr>
                    `;
                });
            } else {
                html = '<tr><td colspan="5" class="text-center">Belum ada data konsultasi</td></tr>';
            }
            document.getElementById('konsultasi-table').innerHTML = html;
        })
        .catch(error => {
            console.log('Error:', error);
            document.getElementById('konsultasi-table').innerHTML = '<tr><td colspan="5" class="text-center text-danger">Gagal memuat data</td></tr>';
        });
});
</script>
@endsection