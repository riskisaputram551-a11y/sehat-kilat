@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow-sm">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0">Rekam Medis Online</h5>
        </div>
        <div class="card-body">
            @php
                $records = App\Models\MedicalRecord::whereHas('consultation', function($q) {
                    $q->where('patient_id', Auth::id());
                })->get();
            @endphp
            @forelse($records as $record)
            <div class="border-bottom py-3">
                <h6>Konsultasi: {{ $record->consultation->code }}</h6>
                <p><strong>Diagnosis:</strong> {{ $record->diagnosis }}</p>
                <p><strong>Obat:</strong> {{ $record->prescription }}</p>
                <p><strong>Catatan:</strong> {{ $record->notes }}</p>
            </div>
            @empty
            <p class="text-center">Belum ada rekam medis</p>
            @endforelse
        </div>
    </div>
</div>
@endsection