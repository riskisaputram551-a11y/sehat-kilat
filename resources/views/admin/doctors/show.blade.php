@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card shadow-sm">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="fas fa-user-md me-2"></i> Detail Dokter</h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr><th style="width:200px">Nama</th><td>{{ $doctor->name }}</td></tr>
                    <tr><th>Email</th><td>{{ $doctor->email }}</td></tr>
                    <tr><th>No HP</th><td>{{ $doctor->phone ?? '-' }}</td></tr>
                    <tr><th>Spesialis</th><td>{{ $doctor->specialist ?? '-' }}</td></tr>
                    <tr><th>Nomor STR</th><td>{{ $doctor->license_number ?? '-' }}</td></tr>
                    <tr><th>Bio</th><td>{{ $doctor->bio ?? '-' }}</td></tr>
                    <tr><th>Role</th><td><span class="badge bg-success">Dokter</span></td></tr>
                    <tr><th>Member Sejak</th><td>{{ $doctor->created_at->format('d F Y') }}</td></tr>
                    <tr><th>Total Konsultasi</th>
                        <td>{{ App\Models\Consultation::where('doctor_id', $doctor->id)->count() }}</td>
                    </tr>
                </table>
                <a href="{{ route('admin.doctors.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>
</div>
@endsection