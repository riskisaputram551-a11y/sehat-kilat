@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0">
                    <i class="fas fa-credit-card me-2 text-primary"></i>
                    Detail Pembayaran
                </h5>
            </div>
            <div class="card-body">
                <!-- Invoice Card -->
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <h6 class="text-muted mb-3">INVOICE</h6>
                                <p class="mb-1"><strong>No. Invoice:</strong> {{ $payment->invoice_number }}</p>
                                <p class="mb-1"><strong>Tanggal:</strong> {{ $payment->created_at->format('d/m/Y H:i') }}</p>
                                <p class="mb-0"><strong>Status:</strong> 
                                    @if($payment->status == 'paid')
                                        <span class="badge bg-success">LUNAS</span>
                                    @elseif($payment->status == 'pending')
                                        <span class="badge bg-warning">MENUNGGU</span>
                                    @else
                                        <span class="badge bg-danger">GAGAL</span>
                                    @endif
                                </p>
                            </div>
                            <div class="col-6 text-end">
                                <img src="{{ asset('images/logo.png') }}" alt="Logo" height="50" onerror="this.style.display='none'">
                                <h5 class="text-primary mt-2">SEHAT KILAT</h5>
                                <small>Jl. Kesehatan No. 1, Jakarta</small>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-6">
                                <strong>Kepada:</strong><br>
                                {{ $payment->consultation->patient->name }}<br>
                                {{ $payment->consultation->patient->email }}<br>
                                {{ $payment->consultation->patient->phone ?? '-' }}
                            </div>
                            <div class="col-6 text-end">
                                <strong>Konsultasi dengan:</strong><br>
                                {{ $payment->consultation->doctor->name }}<br>
                                {{ $payment->consultation->doctor->specialist }}<br>
                                {{ $payment->consultation->consultation_date->format('d/m/Y') }}
                            </div>
                        </div>
                        <hr>
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>Deskripsi</th>
                                    <th class="text-end">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Biaya Konsultasi {{ $payment->consultation->category->name }}</td>
                                    <td class="text-end">Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td>Pajak (10%)</td>
                                    <td class="text-end">Rp {{ number_format($payment->tax, 0, ',', '.') }}</td>
                                </tr>
                                <tr class="table-active">
                                    <td><strong>TOTAL</strong></td>
                                    <td class="text-end"><strong>Rp {{ number_format($payment->total_amount, 0, ',', '.') }}</strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                @if($payment->status == 'pending')
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Pembayaran Belum Dilakukan!</strong> Silakan transfer ke rekening berikut:
                    </div>

                    <div class="card mb-4">
                        <div class="card-body text-center">
                            <h6>Rekening Tujuan</h6>
                            <div class="row">
                                <div class="col-4">
                                    <strong>Bank BCA</strong><br>
                                    1234567890<br>
                                    a.n SEHAT KILAT
                                </div>
                                <div class="col-4">
                                    <strong>Bank Mandiri</strong><br>
                                    0987654321<br>
                                    a.n SEHAT KILAT
                                </div>
                                <div class="col-4">
                                    <strong>QRIS</strong><br>
                                    Scan QR Code<br>
                                    <i class="fas fa-qrcode fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">Upload Bukti Pembayaran</h6>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('payments.upload-proof', $payment) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <input type="file" name="proof" class="form-control @error('proof') is-invalid @enderror" 
                                           accept="image/*" required>
                                    <small class="text-muted">Format: JPG, JPEG, PNG (Max 2MB)</small>
                                    @error('proof')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-upload me-2"></i>Upload Bukti Pembayaran
                                </button>
                            </form>
                        </div>
                    </div>
                @elseif($payment->status == 'paid')
                    <div class="alert alert-success text-center">
                        <i class="fas fa-check-circle fa-2x mb-2 d-block"></i>
                        <strong>Pembayaran Lunas!</strong><br>
                        Terima kasih. Konsultasi Anda telah dikonfirmasi.
                    </div>
                    <div class="text-center">
                        <a href="{{ route('consultations.show', $payment->consultation) }}" class="btn btn-primary">
                            <i class="fas fa-calendar-check me-2"></i>Lihat Jadwal Konsultasi
                        </a>
                        <button onclick="window.print()" class="btn btn-secondary">
                            <i class="fas fa-print me-2"></i>Cetak Invoice
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection