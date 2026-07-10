<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SEHAT KILAT - Konsultasi Dokter Online</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    @stack('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ url('/') }}">
                <i class="fas fa-stethoscope me-2"></i>
                SEHAT KILAT
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @auth
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                                <i class="fas fa-home me-1"></i> Home
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('ai-consultations.*') ? 'active' : '' }}" href="{{ route('ai-consultations.index') }}">
                                <i class="fas fa-robot me-1"></i> Konsultasi AI
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('doctor-consultations.*') ? 'active' : '' }}" href="{{ route('doctor-consultations.create') }}">
                                <i class="fas fa-video me-1"></i> Konsultasi Dokter
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/prescriptions') }}">
                                <i class="fas fa-prescription-bottle me-1"></i> Resep Obat
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/medical-records') }}">
                                <i class="fas fa-notes-medical me-1"></i> Rekam Medis
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('search.medicine') }}">
                                <i class="fas fa-search me-1"></i> Cari Obat
                            </a>
                        </li>
                        <!-- NOTIFIKASI -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-bell me-1"></i>
                                @php
                                    $unread = App\Helpers\NotificationHelper::getUnreadCount();
                                @endphp
                                @if($unread > 0)
                                    <span class="badge bg-danger rounded-pill">{{ $unread }}</span>
                                @endif
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" style="min-width: 320px;">
                                @php
                                    $notifications = App\Helpers\NotificationHelper::getNotifications(10);
                                @endphp
                                @forelse($notifications as $notif)
                                    <li>
                                        <a class="dropdown-item" href="{{ $notif->link ?? '#' }}" style="white-space: normal;">
                                            <div class="fw-bold">{{ $notif->title }}</div>
                                            <small class="text-muted">{{ $notif->message }}</small>
                                            <div class="text-muted small">{{ $notif->created_at->diffForHumans() }}</div>
                                        </a>
                                    </li>
                                @empty
                                    <li><span class="dropdown-item text-muted">Tidak ada notifikasi</span></li>
                                @endforelse
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-center" href="#">Lihat Semua</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user me-1"></i>
                                {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('profile') }}">
                                    <i class="fas fa-id-card me-2"></i> Profil Saya
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="fas fa-key me-1"></i> Masuk
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">
                                <i class="fas fa-user-plus me-1"></i> Daftar
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        <div class="container">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <footer class="bg-dark text-white py-3 mt-5">
        <div class="container text-center">
            <span>
                <i class="fas fa-copyright me-1"></i> 
                2026 KEMENTERIAN KESEHATAN - SEHAT KILAT
            </span>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @stack('scripts')
</body>
</html>