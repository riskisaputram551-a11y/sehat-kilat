@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow-sm">
        <div class="card-header bg-danger text-white">
            <h5 class="mb-0"><i class="fas fa-list me-2"></i> Manajemen Konsultasi</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered">
                    <thead class="table-danger">
                        <tr>
                            <th>Kode</th>
                            <th>Pasien</th>
                            <th>Dokter</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($consultations as $cons)
                        <tr>
                            <td>{{ $cons->code }}</td>
                            <td>{{ $cons->patient->name ?? '-' }}</td>
                            <td>{{ $cons->doctor->name ?? '-' }}</td>
                            <td>{{ $cons->consultation_date }}</td>
                            <td>
                                <span class="badge bg-{{ $cons->status == 'completed' ? 'success' : ($cons->status == 'pending' ? 'warning' : 'secondary') }}">
                                    {{ ucfirst($cons->status) }}
                                </span>
                            </td>
                            <td>
                                @if($cons->status != 'completed')
                                    <form action="{{ route('admin.consultations.confirm', $cons) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Konfirmasi konsultasi ini?')">
                                            <i class="fas fa-check me-1"></i> Konfirmasi
                                        </button>
                                    </form>
                                @else
                                    <span class="text-success">✓ Selesai</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $consultations->links() }}
        </div>
    </div>
</div>
@endsection