@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow-sm">
        <div class="card-header bg-danger text-white">
            <h5 class="mb-0"><i class="fas fa-credit-card me-2"></i> Riwayat Transaksi</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered">
                    <thead class="table-danger">
                        <tr>
                            <th>Invoice</th>
                            <th>Pasien</th>
                            <th>Dokter</th>
                            <th>Tanggal</th>
                            <th>Jam</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transactions as $trx)
                        <tr>
                            <td>{{ $trx->invoice_number }}</td>
                            <td>{{ $trx->consultation->patient->name ?? '-' }}</td>
                            <td>{{ $trx->consultation->doctor->name ?? '-' }}</td>
                            <td>{{ $trx->created_at->format('d/m/Y') }}</td>
                            <td>{{ $trx->created_at->format('H:i') }}</td>
                            <td>Rp {{ number_format($trx->total_amount, 0, ',', '.') }}</td>
                            <td>
                                <span class="badge bg-{{ $trx->status == 'paid' ? 'success' : ($trx->status == 'pending' ? 'warning' : 'danger') }}">
                                    {{ ucfirst($trx->status) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.transactions.show', $trx->id) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $transactions->links() }}
        </div>
    </div>
</div>
@endsection