@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="text-center mb-4">Layanan Dokter</h2>
    <div class="row">
        @php
            $doctors = App\Models\User::where('role', 'dokter')->get();
        @endphp
        @forelse($doctors as $doctor)
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <i class="fas fa-user-md fa-4x text-primary mb-3"></i>
                    <h5>{{ $doctor->name }}</h5>
                    <p class="text-muted">{{ $doctor->specialist ?? 'Dokter Umum' }}</p>
                    <p>{{ $doctor->bio ?? 'Dokter profesional siap melayani' }}</p>
                    <a href="{{ route('doctor-consultations.create') }}" class="btn btn-primary">Konsultasi</a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center">
            <p>Belum ada dokter tersedia</p>
        </div>
        @endforelse
    </div>
</div>
@endsection