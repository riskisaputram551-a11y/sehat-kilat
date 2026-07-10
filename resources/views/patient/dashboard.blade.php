@extends('layouts.app')

@section('content')
<div class="row">
    <!-- Sidebar -->
    <div class="col-md-3 mb-4">
        <div class="card shadow-sm">
            <div class="card-body text-center">
                <div class="mb-3">
                    <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center" 
                         style="width: 80px; height: 80px; font-size: 32px;">
                        <i class="fas fa-user"></i>
                    </div>
                </div>
                <h5>{{ Auth::user()->name }}</h5>
                <p class="text-muted small">Pasien</p>
                <hr>
                <div class="list-group list-group-flush text-start">
                    <a href="{{ route('dashboard') }}" class="list-group-item list-group-item-action active">
                        <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                    </a>
                    <a href="{{ route('consultations.index') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-calendar-check me-2"></i> Konsultasi Saya
                    </a>
                    <a href="{{ route('consultations.create') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-plus-circle me-2"></i> Konsultasi Baru
                    </a>
                    <a href="{{ route('payments.index') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-credit-card me-2"></i> Pembayaran
                    </a>
                    <a href="{{ route('profile') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-user-circle me-2"></i> Profil Saya
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="col-md-9">
        <!-- Welcome Banner -->
        <div class="card bg-gradient-primary bg-primary text-white mb-4">
            <div class="card-body">
                <h4>Halo, {{ Auth::user()->name }}!</h4>
                <p>Selamat datang di SEHAT KILAT. Konsultasi kesehatan jadi lebih mudah.</p>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="card border-0 shadow-sm bg-info text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-0">Total Konsultasi</h6>
                                <h3 class="mb-0">{{ $stats['total_consultations'] }}</h3>
                            </div>
                            <i class="fas fa-calendar-alt fa-2x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card border-0 shadow-sm bg-warning text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-0">Menunggu</h6>
                                <h3 class="mb-0">{{ $stats['pending_consultations'] }}</h3>
                            </div>
                            <i class="fas fa-hourglass-half fa-2x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card border-0 shadow-sm bg-success text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-0">Selesai</h6>
                                <h3 class="mb-0">{{ $stats['completed_consultations'] }}</h3>
                            </div>
                            <i class="fas fa-check-circle fa-2x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card border-0 shadow-sm bg-danger text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-0">Total Biaya</h6>
                                <h5 class="mb-0">Rp {{ number_format($stats['total_spent'], 0, ',', '.') }}</h5>
                            </div>
                            <i class="fas fa-money-bill fa-2x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Consultations -->
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0">
                    <i class="fas fa-history me-2 text-primary"></i>
                    Riwayat Konsultasi Terbaru
                </h5>
            </div>
            <div class="card-body">
                @if($recentConsultations->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Kode</th>
                                    <th>Dokter</th>
                                    <th>Kategori</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentConsultations as $consultation)
                                <tr>
                                    <td>{{ $consultation->code }}</td>
                                    <td>{{ $consultation->doctor->name }}</td>
                                    <td>{{ $consultation->category->name }}</td>
                                    <td>{{ date('d/m/Y', strtotime($consultation->consultation_date)) }}</td>
                                    <td>
                                        @php
                                            $statusClass = [
                                                'pending' => 'warning',
                                                'approved' => 'info',
                                                'in_progress' => 'primary',
                                                'completed' => 'success',
                                                'cancelled' => 'danger'
                                            ][$consultation->status] ?? 'secondary';
                                        @endphp
                                        <span class="badge bg-{{ $statusClass }}">
                                            {{ ucfirst($consultation->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('consultations.show', $consultation) }}" 
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                        <p>Belum ada riwayat konsultasi</p>
                        <a href="{{ route('consultations.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Buat Konsultasi
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Quick Action -->
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card bg-light">
                    <div class="card-body text-center">
                        <i class="fas fa-stethoscope fa-3x text-primary mb-3"></i>
                        <h5>Butuh Konsultasi?</h5>
                        <p>Konsultasi dengan dokter profesional</p>
                        <a href="{{ route('consultations.create') }}" class="btn btn-primary">
                            Konsultasi Sekarang
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card bg-light">
                    <div class="card-body text-center">
                        <i class="fas fa-credit-card fa-3x text-success mb-3"></i>
                        <h5>Pembayaran</h5>
                        <p>Lihat status pembayaran Anda</p>
                        <a href="{{ route('payments.index') }}" class="btn btn-success">
                            Cek Pembayaran
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection