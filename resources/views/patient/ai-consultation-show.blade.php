@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">
                    <i class="fas fa-robot me-2"></i>
                    Hasil Konsultasi AI
                </h5>
            </div>
            <div class="card-body">
                <div class="alert alert-secondary">
                    <strong><i class="fas fa-user me-2"></i>Keluhan Anda:</strong>
                    <p class="mt-2 mb-0">{{ $consultation->complaint }}</p>
                </div>

                <div class="alert alert-success">
                    <strong><i class="fas fa-robot me-2"></i>Respon AI SEHAT KILAT:</strong>
                    <div class="mt-2 mb-0" style="white-space: pre-line;">{{ $consultation->ai_response }}</div>
                </div>

                <hr>

                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Disclaimer:</strong> Ini adalah saran awal dari sistem AI. Bukan pengganti diagnosis dokter profesional.
                    Jika keluhan berlanjut atau memburuk, segera konsultasi dengan dokter.
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('ai-consultations.index') }}" class="btn btn-secondary">
                        <i class="fas fa-history me-2"></i>Riwayat Konsultasi
                    </a>
                    <a href="{{ route('ai-consultations.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Konsultasi Lagi
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection