@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow-sm">
        <div class="card-header bg-danger text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-tags me-2"></i> Manajemen Kategori</h5>
            <a href="{{ route('admin.categories.create') }}" class="btn btn-light text-danger">
                <i class="fas fa-plus me-2"></i> Tambah Kategori
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
                            <th>Icon</th>
                            <th>Nama</th>
                            <th>Deskripsi</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $key => $cat)
                        <tr>
                            <td>{{ $categories->firstItem() + $key }}</td>
                            <td><i class="fas {{ $cat->icon ?? 'fa-stethoscope' }} fa-2x text-primary"></i></td>
                            <td>{{ $cat->name }}</td>
                            <td>{{ Str::limit($cat->description, 30) }}</td>
                            <td>
                                <span class="badge bg-{{ $cat->is_active ? 'success' : 'danger' }}">
                                    {{ $cat->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.categories.edit', $cat->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.categories.destroy', $cat->id) }}" method="POST" class="d-inline">
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
            {{ $categories->links() }}
        </div>
    </div>
</div>
@endsection