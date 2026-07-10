<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SEHAT KILAT - Konsultasi Dokter Online</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 100px 0;
        }
        .feature-card {
            transition: transform 0.3s;
            border: none;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .feature-card:hover {
            transform: translateY(-10px);
        }
        .btn-custom {
            padding: 12px 30px;
            border-radius: 30px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary" href="#">
                <i class="fas fa-stethoscope me-2"></i>
                SEHAT KILAT
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#features">Layanan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/doctors') }}">Layanan Dokter</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-primary ms-2" href="{{ url('/login') }}">
                            <i class="fas fa-sign-in-alt me-1"></i> Masuk
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-outline-primary ms-2" href="{{ url('/register') }}">
                            <i class="fas fa-user-plus me-1"></i> Daftar
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section text-center">
        <div class="container">
            <h1 class="display-4 fw-bold mb-4">Mudah</h1>
            <p class="lead mb-4">Konsultasi dengan dokter profesional kapan saja dan di mana saja</p>
            <a href="{{ url('/register') }}" class="btn btn-light btn-lg btn-custom me-2">
                <i class="fas fa-user-plus me-2"></i>Daftar Sekarang
            </a>
            <a href="{{ url('/login') }}" class="btn btn-outline-light btn-lg btn-custom">
                <i class="fas fa-sign-in-alt me-2"></i>Masuk
            </a>
        </div>
    </section>

    <!-- Features -->
    <section id="features" class="py-5">
        <div class="container">
            <h2 class="text-center mb-5">Layanan Kami</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card feature-card text-center h-100">
                        <div class="card-body">
                            <i class="fas fa-video fa-3x text-primary mb-3"></i>
                            <h5 class="card-title">Konsultasi Online</h5>
                            <p class="card-text">Konsultasi dengan dokter via video call dari rumah Anda</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card text-center h-100">
                        <div class="card-body">
                            <i class="fas fa-prescription-bottle fa-3x text-primary mb-3"></i>
                            <h5 class="card-title">Resep Obat Digital</h5>
                            <p class="card-text">Dapatkan resep obat langsung dari dokter</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card text-center h-100">
                        <div class="card-body">
                            <i class="fas fa-notes-medical fa-3x text-primary mb-3"></i>
                            <h5 class="card-title">Rekam Medis Online</h5>
                            <p class="card-text">Riwayat kesehatan tersimpan rapi dan mudah diakses</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4">
        <div class="container text-center">
            <p class="mb-0">
                <i class="fas fa-copyright me-1"></i>
                2026 KEMENTERIAN KESEHATAN - SEHAT KILAT
            </p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>