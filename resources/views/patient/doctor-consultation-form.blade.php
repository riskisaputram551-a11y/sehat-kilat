@extends('layouts.app')

@section('content')
<style>
    .doctor-container {
        max-width: 850px;
        margin: 40px auto;
        padding: 0 20px;
    }
    .doctor-card {
        background: #ffffff;
        border-radius: 24px;
        padding: 35px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
        border: 1px solid #f0f0f0;
    }
    .doctor-header {
        text-align: center;
        margin-bottom: 25px;
    }
    .doctor-header .icon {
        font-size: 45px;
        color: #28a745;
        background: #e8f5e9;
        width: 75px;
        height: 75px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 12px;
    }
    .doctor-header h2 {
        font-weight: 700;
        color: #1a1a2e;
        margin-bottom: 3px;
    }
    .doctor-header p {
        color: #888;
        font-size: 15px;
    }
    .info-box-doctor {
        background: #fff8e1;
        border-radius: 12px;
        padding: 14px 18px;
        border-left: 4px solid #ffc107;
        margin-bottom: 25px;
        font-size: 14px;
        color: #444;
    }
    .info-box-doctor strong {
        color: #d39e00;
    }
    .form-label {
        font-weight: 600;
        color: #333;
        margin-bottom: 6px;
        font-size: 14px;
    }
    .form-control, .form-select {
        border-radius: 12px;
        border: 1.5px solid #e8ecf1;
        padding: 12px 16px;
        font-size: 14px;
        transition: all 0.3s;
        width: 100%;
    }
    .form-control:focus, .form-select:focus {
        border-color: #28a745;
        box-shadow: 0 0 0 4px rgba(40, 167, 69, 0.1);
        outline: none;
    }
    .btn-group-custom {
        display: flex;
        gap: 15px;
        justify-content: space-between;
        align-items: center;
        margin-top: 25px;
        flex-wrap: wrap;
    }
    .btn-back {
        background: transparent;
        border: 2px solid #e8ecf1;
        padding: 11px 30px;
        border-radius: 30px;
        font-weight: 600;
        color: #555;
        transition: all 0.3s;
        text-decoration: none;
    }
    .btn-back:hover {
        border-color: #28a745;
        color: #28a745;
    }
    .btn-submit-doctor {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        border: none;
        padding: 11px 40px;
        border-radius: 30px;
        font-weight: 600;
        color: white;
        transition: all 0.3s;
        text-decoration: none;
    }
    .btn-submit-doctor:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(40, 167, 69, 0.35);
        color: white;
    }
    .payment-methods {
        display: flex;
        gap: 20px;
        justify-content: center;
        flex-wrap: wrap;
        margin-top: 15px;
    }
    .payment-method-item {
        background: #f8f9fe;
        padding: 15px 25px;
        border-radius: 12px;
        text-align: center;
        border: 1px solid #e8ecf1;
        min-width: 130px;
        transition: all 0.3s;
    }
    .payment-method-item:hover {
        border-color: #28a745;
        box-shadow: 0 5px 15px rgba(40, 167, 69, 0.1);
    }
    .payment-method-item i {
        font-size: 30px;
        color: #28a745;
    }
    .payment-method-item .bank-name {
        font-weight: 600;
        font-size: 14px;
        margin-top: 5px;
    }
    .payment-method-item .bank-account {
        font-size: 12px;
        color: #888;
    }
    .qris-img {
        max-width: 150px;
        background: white;
        padding: 10px;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        margin-top: 10px;
    }
    @media (max-width: 576px) {
        .doctor-card { padding: 20px; }
        .btn-group-custom { flex-direction: column; align-items: stretch; }
        .btn-back, .btn-submit-doctor { text-align: center; width: 100%; }
        .payment-methods { flex-direction: column; align-items: center; }
    }
</style>

<div class="doctor-container">
    <div class="doctor-card">

        <div class="doctor-header">
            <div class="icon">
                <i class="fas fa-video"></i>
            </div>
            <h2>Konsultasi Dokter</h2>
            <p>Berbayar • Konsultasi dengan dokter profesional via video call</p>
        </div>

        <div class="info-box-doctor">
            <i class="fas fa-info-circle me-2" style="color: #d39e00;"></i>
            <strong>Informasi Biaya:</strong> Rp 150.000 + Pajak 10% = <strong>Rp 165.000</strong>
        </div>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('doctor-consultations.store') }}" method="POST">
            @csrf

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Pilih Dokter <span class="text-danger">*</span></label>
                    <select name="doctor_id" class="form-select" required>
                        <option value="">-- Pilih Dokter --</option>
                        @foreach($doctors as $doctor)
                            <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                                {{ $doctor->name }} - {{ $doctor->specialist ?? 'Dokter Umum' }}
                            </option>
                        @endforeach
                    </select>
                    @if($doctors->isEmpty())
                        <small class="text-danger">Belum ada dokter tersedia. Hubungi admin.</small>
                    @endif
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Kategori <span class="text-danger">*</span></label>
                    <select name="category_id" class="form-select" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Tanggal Konsultasi <span class="text-danger">*</span></label>
                    <input type="date" name="consultation_date" class="form-control" min="{{ date('Y-m-d', strtotime('+1 day')) }}" value="{{ old('consultation_date') }}" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Jam Konsultasi <span class="text-danger">*</span></label>
                    <select name="consultation_time" class="form-select" required>
                        <option value="">-- Pilih Jam --</option>
                        @for($i=8; $i<=20; $i++)
                            <option value="{{ sprintf('%02d:00', $i) }}" {{ old('consultation_time') == sprintf('%02d:00', $i) ? 'selected' : '' }}>
                                {{ sprintf('%02d:00', $i) }} WIB
                            </option>
                            <option value="{{ sprintf('%02d:30', $i) }}" {{ old('consultation_time') == sprintf('%02d:30', $i) ? 'selected' : '' }}>
                                {{ sprintf('%02d:30', $i) }} WIB
                            </option>
                        @endfor
                    </select>
                </div>

                <div class="col-12 mb-3">
                    <label class="form-label">Keluhan <span class="text-danger">*</span></label>
                    <textarea name="complaint" rows="4" class="form-control" placeholder="Jelaskan keluhan Anda dengan detail..." required>{{ old('complaint') }}</textarea>
                </div>
            </div>

            <div class="btn-group-custom">
                <a href="{{ route('dashboard') }}" class="btn-back">
                    <i class="fas fa-arrow-left me-2"></i> Kembali
                </a>
                <button type="submit" class="btn-submit-doctor">
                    <i class="fas fa-calendar-check me-2"></i> Ajukan Konsultasi
                </button>
            </div>
        </form>

        <div class="mt-4 pt-3 border-top">
            <h6 class="text-center fw-bold text-primary mb-3">
                <i class="fas fa-credit-card me-2"></i> Metode Pembayaran
            </h6>
            <div class="payment-methods">
                <div class="payment-method-item">
                    <i class="fas fa-university"></i>
                    <div class="bank-name">BCA</div>
                    <div class="bank-account">1234567890</div>
                    <div class="bank-account" style="font-size:11px; color:#999;">a.n SEHAT KILAT</div>
                </div>
                <div class="payment-method-item">
                    <i class="fas fa-university"></i>
                    <div class="bank-name">Mandiri</div>
                    <div class="bank-account">0987654321</div>
                    <div class="bank-account" style="font-size:11px; color:#999;">a.n SEHAT KILAT</div>
                </div>
                <div class="payment-method-item">
                    <i class="fas fa-qrcode"></i>
                    <div class="bank-name">QRIS</div>
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=SEHATKILAT-{{ date('Ymd') }}" alt="QRIS" class="qris-img">
                    <div class="bank-account" style="font-size:11px; color:#999;">Scan untuk bayar</div>
                </div>
            </div>
            <p class="text-center text-muted small mt-3">
                <i class="fas fa-info-circle me-1"></i> 
                Setelah mengajukan konsultasi, Anda akan diarahkan ke halaman pembayaran.
            </p>
        </div>

    </div>
</div>
@endsection