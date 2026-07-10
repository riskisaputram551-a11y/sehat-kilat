@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card shadow-sm">
            <div class="card-header bg-danger text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-user-md me-2"></i> Manajemen Dokter</h5>
                <a href="{{ route('admin.doctors.create') }}" class="btn btn-light text-danger">
                    <i class="fas fa-plus me-2"></i>Tambah Dokter
                </a>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead class="table-danger">
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Spesialis</th>
                                <th>No STR</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($doctors as $key => $doctor)
                            <tr>
                                <td>{{ $doctors->firstItem() + $key }}</td>
                                <td>{{ $doctor->name }}</td>
                                <td>{{ $doctor->email }}</td>
                                <td>{{ $doctor->specialist ?? '-' }}</td>
                                <td>{{ $doctor->license_number ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('admin.doctors.show', $doctor->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.doctors.edit', $doctor->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.doctors.destroy', $doctor->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $doctors->links() }}
            </div>
        </div>
    </div>
</div>
@endsection