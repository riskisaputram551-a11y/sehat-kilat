@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow-sm">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0"><i class="fas fa-file-invoice me-2"></i> Detail Transaksi</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <tr><th style="width:150px;">Invoice</th><td>{{ $transaction->invoice_number }}</td></tr>
                        <tr><th>Pasien</th><td>{{ $transaction->consultation->patient->name ?? '-' }}</td></tr>
                        <tr><th>Dokter</th><td>{{ $transaction->consultation->doctor->name ?? '-' }}</td></tr>
                        <tr><th>Tanggal Transaksi</th><td>{{ $transaction->created_at->format('d F Y H:i') }}</td></tr>
                        <tr><th>Metode</th><td>{{ $transaction->method ?? 'Transfer' }}</td></tr>
                        <tr><th>Status</th>
                            <td>
                                <span class="badge bg-{{ $transaction->status == 'paid' ? 'success' : ($transaction->status == 'pending' ? 'warning' : 'danger') }}">
                                    {{ ucfirst($transaction->status) }}
                                </span>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <tr><th style="width:150px;">Biaya</th><td>Rp {{ number_format($transaction->amount, 0, ',', '.') }}</td></tr>
                        <tr><th>Pajak (10%)</th><td>Rp {{ number_format($transaction->tax, 0, ',', '.') }}</td></tr>
                        <tr class="table-active"><th>Total</th><th>Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</th></tr>
                    </table>

                    @if($transaction->proof)
                        <div class="mt-3">
                            <strong>Bukti Pembayaran:</strong>
                            <img src="{{ asset('storage/' . $transaction->proof) }}" class="img-fluid" style="max-height:200px;">
                        </div>
                    @endif

                    @if($transaction->status == 'pending')
                        <form action="{{ route('admin.transactions.update-status', $transaction->id) }}" method="POST" class="mt-3">
                            @csrf
                            @method('PUT')
                            <button type="submit" name="status" value="paid" class="btn btn-success">
                                <i class="fas fa-check me-2"></i> Konfirmasi Pembayaran
                            </button>
                            <button type="submit" name="status" value="failed" class="btn btn-danger">
                                <i class="fas fa-times me-2"></i> Tolak
                            </button>
                        </form>
                    @endif
                </div>
            </div>
            <div class="mt-3">
                <a href="{{ route('admin.transactions.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>
</div>
@endsection