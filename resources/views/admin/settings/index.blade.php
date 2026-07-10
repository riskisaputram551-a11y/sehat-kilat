@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow-sm">
        <div class="card-header bg-danger text-white">
            <h5 class="mb-0"><i class="fas fa-cog me-2"></i> Pengaturan Sistem</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="card bg-light">
                        <div class="card-body">
                            <h6><i class="fas fa-info-circle text-primary me-2"></i> Informasi Sistem</h6>
                            <table class="table table-borderless">
                                <tr><td><strong>Nama Aplikasi</strong></td><td>SEHAT KILAT</td></tr>
                                <tr><td><strong>Versi</strong></td><td>1.0.0</td></tr>
                                <tr><td><strong>Framework</strong></td><td>Laravel 12</td></tr>
                                <tr><td><strong>PHP Version</strong></td><td>{{ phpversion() }}</td></tr>
                                <tr><td><strong>Total User</strong></td><td>{{ \App\Models\User::count() }}</td></tr>
                                <tr><td><strong>Total Konsultasi</strong></td><td>{{ \App\Models\Consultation::count() }}</td></tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card bg-light">
                        <div class="card-body">
                            <h6><i class="fas fa-tools text-warning me-2"></i> Pengaturan</h6>
                            <form action="{{ route('admin.settings.update') }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label class="form-label">Biaya Konsultasi</label>
                                    <input type="number" name="consultation_fee" class="form-control" value="150000">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Pajak (%)</label>
                                    <input type="number" name="tax" class="form-control" value="10">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Maksimal Upload (MB)</label>
                                    <input type="number" name="max_upload" class="form-control" value="2">
                                </div>
                                <button type="submit" class="btn btn-danger w-100">
                                    <i class="fas fa-save me-2"></i> Simpan Pengaturan
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection