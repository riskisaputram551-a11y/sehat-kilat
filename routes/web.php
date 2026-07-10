<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AIConsultationController;
use App\Http\Controllers\DoctorConsultationController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\Admin\PatientController;
use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\ConsultationController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DoctorDashboardController;

// Halaman utama - landing page
Route::get('/', function () {
    return view('landing');
})->name('home');

// Halaman Layanan Dokter
Route::get('/doctors', function () {
    return view('doctors');
})->name('doctors');

// Auth routes
Auth::routes();

// Redirect /home ke /dashboard
Route::get('/home', function () {
    return redirect('/dashboard');
})->middleware('auth');

// ==================== ROUTE UNTUK PASIEN ====================
Route::middleware(['auth'])->group(function () {
    // Dashboard Pasien (Beranda)
    Route::get('/dashboard', function () {
        return view('dashboard-sederhana');
    })->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Resep Obat Digital
    Route::get('/prescriptions', function () {
        return view('patient.prescriptions');
    })->name('prescriptions');

    // Rekam Medis Online
    Route::get('/medical-records', function () {
        return view('patient.medical-records');
    })->name('medical-records');

    // Cari Obat
    Route::get('/search-medicine', function () {
        return view('patient.search-medicine');
    })->name('search.medicine');

    // AI Consultation
    Route::prefix('ai-consultations')->name('ai-consultations.')->group(function () {
        Route::get('/', [AIConsultationController::class, 'index'])->name('index');
        Route::get('/create', [AIConsultationController::class, 'create'])->name('create');
        Route::post('/', [AIConsultationController::class, 'store'])->name('store');
        Route::get('/{consultation}', [AIConsultationController::class, 'show'])->name('show');
        Route::get('/{consultation}/export-pdf', [AIConsultationController::class, 'exportPdf'])->name('export-pdf');
    });

    // Doctor Consultation
    Route::prefix('doctor-consultations')->name('doctor-consultations.')->group(function () {
        Route::get('/', [DoctorConsultationController::class, 'index'])->name('index');
        Route::get('/create', [DoctorConsultationController::class, 'create'])->name('create');
        Route::post('/', [DoctorConsultationController::class, 'store'])->name('store');
        Route::get('/{consultation}', [DoctorConsultationController::class, 'show'])->name('show');
        Route::get('/{consultation}/payment', [DoctorConsultationController::class, 'payment'])->name('payment');
        Route::post('/{consultation}/upload-proof', [DoctorConsultationController::class, 'uploadPaymentProof'])->name('upload-proof');
    });
});

// ==================== ROUTE UNTUK DOKTER ====================
Route::get('/doctor/dashboard', [DoctorDashboardController::class, 'index'])
    ->middleware('auth')
    ->name('doctor.dashboard');

// ==================== ROUTE UNTUK ADMIN ====================
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard Admin
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Manajemen Pasien
    Route::resource('patients', PatientController::class);

    // Manajemen Dokter
    Route::resource('doctors', DoctorController::class);

    // Kategori
    Route::resource('categories', CategoryController::class);

    // Transaksi
    Route::prefix('transactions')->name('transactions.')->group(function () {
        Route::get('/', [TransactionController::class, 'index'])->name('index');
        Route::get('/{id}', [TransactionController::class, 'show'])->name('show');
        Route::put('/{id}/status', [TransactionController::class, 'updateStatus'])->name('update-status');
    });

    // Laporan
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');
        Route::get('/export-pdf', [ReportController::class, 'exportPdf'])->name('export-pdf');
        Route::get('/export-excel', [ReportController::class, 'exportExcel'])->name('export-excel');
    });

    // Konsultasi (Manajemen Konsultasi)
    Route::prefix('consultations')->name('consultations.')->group(function () {
        Route::get('/', [ConsultationController::class, 'index'])->name('index');
        Route::patch('/{consultation}/confirm', [ConsultationController::class, 'confirm'])->name('confirm');
    });

    // Pengaturan
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', [SettingController::class, 'index'])->name('index');
        Route::put('/', [SettingController::class, 'update'])->name('update');
    });
});

// ==================== API ROUTES ====================
// API untuk statistik pasien
Route::get('/api/consultation-stats', function () {
    $user = Auth::user();
    if (!$user) {
        return response()->json(['total' => 0, 'pending' => 0, 'completed' => 0, 'total_spent' => 0]);
    }
    
    return response()->json([
        'total' => App\Models\Consultation::where('patient_id', $user->id)->count(),
        'pending' => App\Models\Consultation::where('patient_id', $user->id)->where('status', 'pending')->count(),
        'completed' => App\Models\Consultation::where('patient_id', $user->id)->where('status', 'completed')->count(),
        'total_spent' => App\Models\Consultation::where('patient_id', $user->id)->sum('fee'),
    ]);
})->middleware('auth');

// API untuk riwayat konsultasi pasien
Route::get('/api/recent-consultations', function () {
    $user = Auth::user();
    if (!$user) {
        return response()->json([]);
    }
    
    return response()->json(
        App\Models\Consultation::where('patient_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get()
            ->map(function($c) {
                return [
                    'id' => $c->id,
                    'type' => $c->consultation_type ?? 'ai',
                    'complaint' => $c->complaint,
                    'status' => $c->status,
                    'date' => $c->created_at->format('d/m/Y H:i'),
                ];
            })
    );
})->middleware('auth');

// API untuk admin dashboard
Route::get('/api/admin-stats', function () {
    $months = [];
    $totals = [];
    for ($i = 1; $i <= 12; $i++) {
        $months[] = date('F', mktime(0, 0, 0, $i, 1));
        $totals[] = App\Models\Consultation::whereMonth('created_at', $i)->whereYear('created_at', date('Y'))->count();
    }

    $recentConsultations = App\Models\Consultation::with(['patient', 'doctor'])
        ->latest()
        ->take(10)
        ->get()
        ->map(function($c) {
            return [
                'code' => $c->code,
                'patient' => $c->patient->name ?? '-',
                'doctor' => $c->doctor->name ?? '-',
                'date' => $c->created_at->format('d/m/Y'),
                'status' => $c->status,
            ];
        });

    return response()->json([
        'total_patients' => App\Models\User::where('role', 'pasien')->count(),
        'total_doctors' => App\Models\User::where('role', 'dokter')->count(),
        'total_consultations' => App\Models\Consultation::count(),
        'total_revenue' => App\Models\Payment::where('status', 'paid')->sum('total_amount'),
        'months' => $months,
        'totals' => $totals,
        'recent_consultations' => $recentConsultations,
    ]);
})->middleware('auth');