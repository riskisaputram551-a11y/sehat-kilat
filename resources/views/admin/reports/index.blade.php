@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card shadow-sm">
            <div class="card-header bg-danger text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-file-alt me-2"></i> Laporan</h5>
                <div>
                    <a href="{{ route('admin.reports.export-pdf') }}" class="btn btn-light text-danger me-2">
                        <i class="fas fa-file-pdf me-2"></i> Export PDF
                    </a>
                    <a href="{{ route('admin.reports.export-excel') }}" class="btn btn-light text-danger">
                        <i class="fas fa-file-excel me-2"></i> Export Excel
                    </a>
                </div>
            </div>
            <div class="card-body">
                <!-- Statistik -->
                <div class="row mb-4">
                    <div class="col-md-3 mb-3">
                        <div class="card bg-primary text-white">
                            <div class="card-body">
                                <h6>Total Pasien</h6>
                                <h2>{{ $totalPatients }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card bg-info text-white">
                            <div class="card-body">
                                <h6>Total Dokter</h6>
                                <h2>{{ $totalDoctors }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card bg-success text-white">
                            <div class="card-body">
                                <h6>Total Konsultasi</h6>
                                <h2>{{ $totalConsultations }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card bg-warning text-white">
                            <div class="card-body">
                                <h6>Total Pendapatan</h6>
                                <h4>Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Grafik -->
                <div class="card mb-4">
                    <div class="card-header bg-danger text-white">
                        <h6 class="mb-0">Grafik Konsultasi per Bulan</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="reportChart" height="100"></canvas>
                    </div>
                </div>

                <!-- Tabel Data -->
                <div class="card">
                    <div class="card-header bg-danger text-white">
                        <h6 class="mb-0">Data Konsultasi</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead class="table-danger">
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
                                        <td>
                                            <span class="badge bg-{{ $cons->status == 'completed' ? 'success' : 'warning' }}">
                                                {{ $cons->status }}
                                            </span>
                                        </td>
                                        <td>Rp {{ number_format($cons->fee, 0, ',', '.') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('reportChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {{ json_encode($months) }},
            datasets: [{
                label: 'Jumlah Konsultasi',
                data: {{ json_encode($totals) }},
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
});
</script>
@endsection