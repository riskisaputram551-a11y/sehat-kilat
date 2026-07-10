@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card shadow-sm">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="fas fa-user me-2"></i> Detail Pasien</h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr><th style="width:200px">Nama</th><td>{{ $patient->name }}</td></tr>
                    <tr><th>Email</th><td>{{ $patient->email }}</td></tr>
                    <tr><th>No HP</th><td>{{ $patient->phone ?? '-' }}</td></tr>
                    <tr><th>Role</th><td><span class="badge bg-primary">Pasien</span></td></tr>
                    <tr><th>Member Sejak</th><td>{{ $patient->created_at->format('d F Y') }}</td></tr>
                    <tr><th>Total Konsultasi</th>
                        <td>{{ App\Models\Consultation::where('patient_id', $patient->id)->count() }}</td>
                    </tr>
                </table>
                <a href="{{ route('admin.patients.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>
</div>
@endsection