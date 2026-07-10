@extends('layouts.app')

@section('content')
<style>
    .payment-container {
        max-width: 750px;
        margin: 40px auto;
        padding: 0 20px;
    }
    /* INVOICE STYLE */
    .invoice-wrapper {
        background: #ffffff;
        border-radius: 20px;
        padding: 0;
        box-shadow: 0 15px 50px rgba(0, 0, 0, 0.1);
        border: 1px solid #e8ecf1;
        overflow: hidden;
    }
    .invoice-header {
        background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
        padding: 30px 35px;
        color: white;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
    }
    .invoice-header .logo {
        font-size: 26px;
        font-weight: 700;
        letter-spacing: 2px;
    }
    .invoice-header .logo i {
        color: #667eea;
        margin-right: 10px;
    }
    .invoice-header .sub {
        font-size: 12px;
        color: rgba(255,255,255,0.6);
        letter-spacing: 3px;
        text-transform: uppercase;
    }
    .invoice-header .status-badge {
        background: #28a745;
        padding: 6px 20px;
        border-radius: 30px;
        font-size: 13px;
        font-weight: 600;
        color: white;
    }
    .invoice-body {
        padding: 30px 35px;
    }
    .invoice-title {
        text-align: center;
        font-size: 22px;
        font-weight: 700;
        color: #1a1a2e;
        margin-bottom: 25px;
        letter-spacing: 3px;
        text-transform: uppercase;
        position: relative;
    }
    .invoice-title::after {
        content: '';
        display: block;
        width: 60px;
        height: 3px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        margin: 8px auto 0;
        border-radius: 2px;
    }
    .invoice-info {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
        background: #f8f9fe;
        padding: 18px 22px;
        border-radius: 12px;
        margin-bottom: 25px;
    }
    .invoice-info .item .label {
        font-size: 11px;
        color: #999;
        text-transform: uppercase;
        font-weight: 600;
        letter-spacing: 0.5px;
    }
    .invoice-info .item .value {
        font-size: 15px;
        font-weight: 600;
        color: #1a1a2e;
        margin-top: 2px;
    }
    .invoice-table {
        width: 100%;
        border-collapse: collapse;
        margin: 15px 0 20px;
    }
    .invoice-table th {
        background: #f0f2f5;
        padding: 12px 16px;
        text-align: left;
        font-size: 12px;
        text-transform: uppercase;
        font-weight: 700;
        color: #555;
        letter-spacing: 0.5px;
    }
    .invoice-table td {
        padding: 12px 16px;
        border-bottom: 1px solid #f0f2f5;
        font-size: 14px;
    }
    .invoice-table .total-row {
        background: #f8f9fe;
        font-weight: 700;
    }
    .invoice-table .total-row td {
        border-bottom: none;
        font-size: 16px;
    }
    .invoice-table .grand-total {
        background: linear-gradient(135deg, #28a745, #20c997);
        color: white;
    }
    .invoice-table .grand-total td {
        color: white;
        font-size: 18px;
        border-bottom: none;
        padding: 14px 16px;
    }
    .payment-qr {
        text-align: center;
        background: #f8f9fe;
        border-radius: 12px;
        padding: 20px;
        margin: 20px 0;
    }
    .payment-qr img {
        max-width: 160px;
        background: white;
        padding: 12px;
        border-radius: 12px;
        box-shadow: 0 2px 15px rgba(0,0,0,0.08);
    }
    .payment-qr .qr-label {
        font-weight: 600;
        color: #1a1a2e;
        margin-bottom: 8px;
    }
    .payment-qr .qr-desc {
        font-size: 12px;
        color: #888;
        margin-top: 6px;
    }
    .bank-list {
        display: flex;
        gap: 20px;
        justify-content: center;
        flex-wrap: wrap;
        margin: 15px 0 20px;
    }
    .bank-item {
        background: #f8f9fe;
        border-radius: 12px;
        padding: 15px 25px;
        text-align: center;
        min-width: 140px;
        border: 1px solid #e8ecf1;
        transition: all 0.3s;
    }
    .bank-item:hover {
        border-color: #667eea;
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.1);
    }
    .bank-item i {
        font-size: 28px;
        color: #667eea;
    }
    .bank-item .bank-name {
        font-weight: 700;
        font-size: 15px;
        margin-top: 5px;
        color: #1a1a2e;
    }
    .bank-item .bank-account {
        font-size: 12px;
        color: #888;
        font-weight: 600;
    }
    .bank-item .bank-owner {
        font-size: 11px;
        color: #aaa;
    }
    .upload-section {
        background: #f8f9fe;
        border-radius: 12px;
        padding: 20px 25px;
        margin-top: 20px;
        border: 2px dashed #d0d5dd;
        transition: all 0.3s;
    }
    .upload-section:hover {
        border-color: #667eea;
        background: #f0f4ff;
    }
    .upload-section .upload-label {
        font-weight: 600;
        color: #1a1a2e;
        margin-bottom: 8px;
        display: block;
    }
    .upload-section .form-control-file {
        border: none;
        padding: 10px 0;
        background: transparent;
    }
    .upload-section .form-control-file::-webkit-file-upload-button {
        background: linear-gradient(135deg, #667eea, #764ba2);
        border: none;
        padding: 10px 25px;
        border-radius: 30px;
        color: white;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
    }
    .upload-section .form-control-file::-webkit-file-upload-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
    }
    .upload-section .file-hint {
        font-size: 12px;
        color: #999;
        margin-top: 5px;
    }
    .invoice-footer {
        background: #f8f9fe;
        padding: 15px 35px;
        text-align: center;
        font-size: 11px;
        color: #aaa;
        border-top: 1px solid #e8ecf1;
    }
    .btn-upload-submit {
        background: linear-gradient(135deg, #28a745, #20c997);
        border: none;
        padding: 12px 40px;
        border-radius: 30px;
        font-weight: 600;
        color: white;
        transition: all 0.3s;
        width: 100%;
        margin-top: 10px;
    }
    .btn-upload-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(40, 167, 69, 0.35);
        color: white;
    }
    .btn-back-payment {
        background: transparent;
        border: 2px solid #e8ecf1;
        padding: 11px 30px;
        border-radius: 30px;
        font-weight: 600;
        color: #555;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-block;
    }
    .btn-back-payment:hover {
        border-color: #667eea;
        color: #667eea;
    }
    @media (max-width: 576px) {
        .invoice-header { padding: 20px; flex-direction: column; text-align: center; gap: 10px; }
        .invoice-body { padding: 20px; }
        .invoice-info { grid-template-columns: 1fr; }
        .bank-list { flex-direction: column; align-items: center; }
        .bank-item { width: 100%; max-width: 250px; }
    }
</style>

<div class="payment-container">
    <div class="invoice-wrapper">

        <!-- HEADER -->
        <div class="invoice-header">
            <div>
                <div class="logo"><i class="fas fa-stethoscope"></i> SEHAT KILAT</div>
                <div class="sub">Konsultasi Kesehatan Online</div>
            </div>
            <div>
                <span class="status-badge"><i class="fas fa-clock me-1"></i> Menunggu Pembayaran</span>
            </div>
        </div>

        <!-- BODY -->
        <div class="invoice-body">

            <div class="invoice-title">Invoice Pembayaran</div>

            <!-- INFO -->
            <div class="invoice-info">
                <div class="item">
                    <div class="label">Kode Konsultasi</div>
                    <div class="value">{{ $consultation->code }}</div>
                </div>
                <div class="item">
                    <div class="label">Tanggal</div>
                    <div class="value">{{ now()->format('d F Y') }}</div>
                </div>
                <div class="item">
                    <div class="label">Pasien</div>
                    <div class="value">{{ Auth::user()->name }}</div>
                </div>
                <div class="item">
                    <div class="label">Dokter</div>
                    <div class="value">{{ $consultation->doctor->name ?? 'Dokter' }}</div>
                </div>
            </div>

            <!-- TABEL TAGIHAN -->
            <table class="invoice-table">
                <thead>
                    <tr>
                        <th style="width:60%;">Deskripsi</th>
                        <th style="text-align:right;">Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Konsultasi Dokter ({{ $consultation->doctor->specialist ?? 'Umum' }})</td>
                        <td style="text-align:right;">Rp {{ number_format($consultation->fee, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td>Pajak (10%)</td>
                        <td style="text-align:right;">Rp {{ number_format($payment->tax ?? 15000, 0, ',', '.') }}</td>
                    </tr>
                    <tr class="grand-total">
                        <td><strong>Total</strong></td>
                        <td style="text-align:right; font-size:20px;">
                            <strong>Rp {{ number_format($payment->total_amount ?? 165000, 0, ',', '.') }}</strong>
                        </td>
                    </tr>
                </tbody>
            </table>

            <!-- QRIS -->
            <div class="payment-qr">
                <div class="qr-label"><i class="fas fa-qrcode me-2" style="color:#667eea;"></i> QRIS</div>
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=160x160&data=SEHATKILAT-{{ $consultation->code }}" alt="QRIS">
                <div class="qr-desc">Scan QR Code untuk melakukan pembayaran</div>
            </div>

            <!-- BANK -->
            <div class="bank-list">
                <div class="bank-item">
                    <i class="fas fa-university"></i>
                    <div class="bank-name">BCA</div>
                    <div class="bank-account">1234567890</div>
                    <div class="bank-owner">a.n SEHAT KILAT</div>
                </div>
                <div class="bank-item">
                    <i class="fas fa-university"></i>
                    <div class="bank-name">Mandiri</div>
                    <div class="bank-account">0987654321</div>
                    <div class="bank-owner">a.n SEHAT KILAT</div>
                </div>
            </div>

            <!-- UPLOAD BUKTI -->
            <div class="upload-section">
                <form action="{{ route('doctor-consultations.upload-proof', $consultation) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <label class="upload-label"><i class="fas fa-upload me-2" style="color:#667eea;"></i> Upload Bukti Pembayaran</label>
                    <input type="file" name="proof" class="form-control-file" accept="image/*" required>
                    <div class="file-hint">Format: JPG, JPEG, PNG (Max 2MB)</div>
                    <div class="d-flex gap-2 flex-wrap mt-3">
                        <a href="{{ route('dashboard') }}" class="btn-back-payment">
                            <i class="fas fa-arrow-left me-2"></i> Kembali
                        </a>
                        <button type="submit" class="btn-upload-submit" style="flex:1;">
                            <i class="fas fa-check-circle me-2"></i> Upload & Konfirmasi
                        </button>
                    </div>
                </form>
            </div>

        </div>

        <!-- FOOTER -->
        <div class="invoice-footer">
            <i class="fas fa-copyright me-1"></i> 2026 SEHAT KILAT • Resep berlaku 30 hari
        </div>

    </div>
</div>
@endsection