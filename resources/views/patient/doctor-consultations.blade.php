@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h4 class="fw-bold mb-3"><i class="fas fa-video text-success me-2"></i> Riwayat Konsultasi Dokter</h4>

    @forelse($consultations as $consultation)
    <div class="card mb-3 shadow-sm">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="fw-bold">{{ $consultation->doctor->name ?? 'Dokter' }}</h6>
                    <small class="text-muted">{{ $consultation->consultation_date }} {{ $consultation->consultation_time }}</small>
                    <p class="mb-0 mt-1">{{ Str::limit($consultation->complaint, 60) }}</p>
                </div>
                <div>
                    <span class="badge bg-{{ $consultation->status == 'completed' ? 'success' : 'warning' }}">
                        {{ ucfirst($consultation->status) }}
                    </span>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="text-center py-5">
        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
        <p>Belum ada riwayat konsultasi dokter</p>
    </div>
    @endforelse
</div>
@endsection