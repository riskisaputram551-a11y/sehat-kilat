@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-3">
        <div class="card shadow-sm">
            <div class="card-body text-center">
                <div class="mb-3">
                    <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center" 
                         style="width: 80px; height: 80px; font-size: 32px;">
                        <i class="fas fa-user"></i>
                    </div>
                </div>
                <h5>{{ Auth::user()->name }}</h5>
                <p class="text-muted small">Pasien</p>
                <hr>
                <div class="list-group list-group-flush text-start">
                    <a href="{{ route('dashboard') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                    </a>
                    <a href="{{ route('consultations.index') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-calendar-check me-2"></i> Konsultasi Saya
                    </a>
                    <a href="{{ route('consultations.create') }}" class="list-group-item list-group-item-action active">
                        <i class="fas fa-plus-circle me-2"></i> Konsultasi Baru
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-9">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0">
                    <i class="fas fa-plus-circle me-2 text-primary"></i>
                    Konsultasi Baru
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('consultations.store') }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Pilih Dokter <span class="text-danger">*</span></label>
                            <select name="doctor_id" class="form-select @error('doctor_id') is-invalid @enderror" required>
                                <option value="">Pilih Dokter</option>
                                @foreach($doctors as $doctor)
                                    <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                                        {{ $doctor->name }} - {{ $doctor->specialist }}
                                    </option>
                                @endforeach
                            </select>
                            @error('doctor_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Kategori Konsultasi <span class="text-danger">*</span></label>
                            <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal Konsultasi <span class="text-danger">*</span></label>
                            <input type="date" name="consultation_date" class="form-control @error('consultation_date') is-invalid @enderror" 
                                   value="{{ old('consultation_date') }}" min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                            @error('consultation_date')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Jam Konsultasi <span class="text-danger">*</span></label>
                            <select name="consultation_time" class="form-select @error('consultation_time') is-invalid @enderror" required>
                                <option value="">Pilih Jam</option>
                                @for($i=8; $i<=20; $i++)
                                    @php
                                        $time = sprintf("%02d:00", $i);
                                    @endphp
                                    <option value="{{ $time }}" {{ old('consultation_time') == $time ? 'selected' : '' }}>
                                        {{ $time }} WIB
                                    </option>
                                    @php
                                        $time30 = sprintf("%02d:30", $i);
                                    @endphp
                                    <option value="{{ $time30 }}" {{ old('consultation_time') == $time30 ? 'selected' : '' }}>
                                        {{ $time30 }} WIB
                                    </option>
                                @endfor
                            </select>
                            @error('consultation_time')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jenis Konsultasi <span class="text-danger">*</span></label>
                        <div>
                            <div class="form-check form-check-inline">
                                <input type="radio" name="type" value="online" class="form-check-input" 
                                       {{ old('type', 'online') == 'online' ? 'checked' : '' }} required>
                                <label class="form-check-label">Online (Video Call)</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="radio" name="type" value="offline" class="form-check-input"
                                       {{ old('type') == 'offline' ? 'checked' : '' }}>
                                <label class="form-check-label">Offline (Datang ke Klinik)</label>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Keluhan <span class="text-danger">*</span></label>
                        <textarea name="complaint" rows="5" class="form-control @error('complaint') is-invalid @enderror" 
                                  placeholder="Jelaskan keluhan Anda dengan detail..." required>{{ old('complaint') }}</textarea>
                        @error('complaint')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                        <small class="text-muted">Minimal 10 karakter. Semakin detail keluhan, semakin baik diagnosis yang diberikan.</small>
                    </div>

                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Informasi Biaya:</strong> Biaya konsultasi Rp 150.000 (sudah termasuk pajak 10%)
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('consultations.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Ajukan Konsultasi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection