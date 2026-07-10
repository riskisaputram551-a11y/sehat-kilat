@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0"><i class="fas fa-file-medical me-2"></i> Detail Konsultasi Dokter</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <tr>
                            <th style="width:150px;">Kode</th>
                            <td>{{ $consultation->code }}</td>
                        </tr>
                        <tr>
                            <th>Dokter</th>
                            <td>{{ $consultation->doctor->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Kategori</th>
                            <td>{{ $consultation->category->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal</th>
                            <td>{{ \Carbon\Carbon::parse($consultation->consultation_date)->format('d/m/Y') }}</td>
                        </tr>
                        <tr>
                            <th>Jam</th>
                            <td>{{ $consultation->consultation_time }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                <span class="badge bg-{{ $consultation->status == 'completed' ? 'success' : ($consultation->status == 'pending' ? 'warning' : 'secondary') }}">
                                    {{ ucfirst($consultation->status) }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Biaya</th>
                            <td>Rp {{ number_format($consultation->fee, 0, ',', '.') }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-light">
                            <strong>Keluhan</strong>
                        </div>
                        <div class="card-body">
                            <p>{{ $consultation->complaint }}</p>
                        </div>
                    </div>
                    @if($consultation->doctor_note)
                    <div class="card mt-3">
                        <div class="card-header bg-light">
                            <strong>Catatan Dokter</strong>
                        </div>
                        <div class="card-body">
                            <p>{{ $consultation->doctor_note }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i> Kembali ke Beranda
                </a>
                @if($consultation->status == 'pending')
                    <a href="{{ route('doctor-consultations.payment', $consultation) }}" class="btn btn-success">
                        <i class="fas fa-credit-card me-2"></i> Bayar Sekarang
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection