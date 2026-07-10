@extends('layouts.app')

@section('content')
<style>
    .doctor-dashboard {
        max-width: 1200px;
        margin: 0 auto;
    }
    .doctor-header {
        background: linear-gradient(135deg, #28a745, #20c997);
        border-radius: 20px;
        padding: 30px;
        color: white;
        margin-bottom: 30px;
    }
    .stat-card {
        background: white;
        border-radius: 15px;
        padding: 20px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        border-left: 4px solid #28a745;
    }
    .stat-card .number {
        font-size: 28px;
        font-weight: 700;
        color: #28a745;
    }
    .stat-card .label {
        font-size: 14px;
        color: #888;
    }
</style>

<div class="doctor-dashboard">
    <div class="doctor-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h3><i class="fas fa-user-md me-2"></i> Dashboard Dokter</h3>
                <p class="mb-0">Selamat datang, {{ Auth::user()->name }}!</p>
            </div>
            <div>
                <span class="badge bg-light text-success p-2">{{ $stats['today_schedule'] }} Jadwal Hari Ini</span>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="stat-card">
                <div class="number">{{ $stats['total_patients'] }}</div>
                <div class="label">Total Pasien</div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stat-card" style="border-left-color: #17a2b8;">
                <div class="number" style="color: #17a2b8;">{{ $stats['total_consultations'] }}</div>
                <div class="label">Total Konsultasi</div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stat-card" style="border-left-color: #ffc107;">
                <div class="number" style="color: #ffc107;">{{ $stats['pending'] }}</div>
                <div class="label">Menunggu</div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stat-card" style="border-left-color: #dc3545;">
                <div class="number" style="color: #dc3545;">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</div>
                <div class="label">Total Pendapatan</div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <h5 class="mb-0"><i class="fas fa-history me-2 text-success"></i> Konsultasi Terbaru</h5>
        </div>
        <div class="card-body">
            @forelse($consultations as $cons)
            <div class="border-bottom py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <strong>{{ $cons->patient->name ?? 'Pasien' }}</strong>
                        <br>
                        <small class="text-muted">{{ $cons->consultation_date }} {{ $cons->consultation_time }}</small>
                        <br>
                        <small>{{ Str::limit($cons->complaint, 50) }}</small>
                    </div>
                    <div>
                        <span class="badge bg-{{ $cons->status == 'completed' ? 'success' : 'warning' }}">
                            {{ ucfirst($cons->status) }}
                        </span>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-4">
                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                <p>Belum ada konsultasi</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection