@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card shadow-sm">
            <div class="card-header bg-warning">
                <h5 class="mb-0"><i class="fas fa-edit me-2"></i> Edit Pasien</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.patients.update', $patient->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $patient->name) }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $patient->email) }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">No Handphone</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone', $patient->phone) }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password (kosongkan jika tidak diubah)</label>
                        <input type="password" name="password" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="form-control">
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.patients.index') }}" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-warning">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection