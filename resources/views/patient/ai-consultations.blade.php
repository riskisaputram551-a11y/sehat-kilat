@extends('layouts.app')

@section('content')
<style>
    .history-card {
        background: white;
        border-radius: 15px;
        padding: 20px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        margin-bottom: 15px;
        border-left: 4px solid #667eea;
        transition: transform 0.3s;
    }
    .history-card:hover {
        transform: translateX(5px);
    }
    .history-card .date {
        font-size: 13px;
        color: #888;
    }
    .history-card .complaint {
        font-size: 16px;
        font-weight: 500;
        color: #333;
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
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h4 class="mb-4"><i class="fas fa-robot text-primary me-2"></i> Riwayat Konsultasi AI</h4>

            @forelse($consultations as $consultation)
                <a href="{{ route('ai-consultations.show', $consultation) }}" class="text-decoration-none text-dark">
                    <div class="history-card">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="complaint">
                                    <i class="fas fa-quote-left text-primary me-2"></i>
                                    {{ \Illuminate\Support\Str::limit($consultation->complaint, 60) }}
                                </div>
                                <div class="date">
                                    <i class="far fa-calendar-alt me-1"></i> {{ $consultation->created_at->format('d/m/Y H:i') }}
                                </div>
                            </div>
                            <span class="badge-status completed">Selesai</span>
                        </div>
                    </div>
                </a>
            @empty
                <div class="text-center py-5">
                    <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
                    <p>Belum ada riwayat konsultasi AI</p>
                    <a href="{{ route('ai-consultations.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i> Konsultasi AI Sekarang
                    </a>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection