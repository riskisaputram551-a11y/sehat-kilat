@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center min-vh-100 align-items-center">
        <div class="col-md-5">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-primary text-white text-center py-4 rounded-top-4">
                    <i class="fas fa-stethoscope fa-3x mb-2"></i>
                    <h3 class="mb-0">SEHAT KILAT</h3>
                    <p class="mb-0">MASUK AKUN</p>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                            @error('email') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                            @error('password') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" name="remember" id="remember">
                            <label class="form-check-label" for="remember">Ingat Saya</label>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2">Masuk</button>
                    </form>

                    <div class="text-center mt-4">
                        Belum punya akun? <a href="{{ route('register') }}">Daftar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection