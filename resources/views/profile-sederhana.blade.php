@extends('layouts.app')

@section('content')
<style>
    .profile-container {
        max-width: 850px;
        margin: 40px auto;
        padding: 0 20px;
    }
    .profile-card {
        background: #ffffff;
        border-radius: 24px;
        padding: 40px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
        border: 1px solid #f0f0f0;
    }
    .profile-header {
        text-align: center;
        margin-bottom: 30px;
    }
    .profile-avatar {
        width: 90px;
        height: 90px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 40px;
        color: white;
        margin-bottom: 15px;
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
    }
    .profile-header h2 {
        font-weight: 700;
        color: #1a1a2e;
        margin-bottom: 5px;
    }
    .profile-header .email {
        color: #888;
        font-size: 15px;
    }
    .badge-premium {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 5px 18px;
        border-radius: 20px;
        font-size: 13px;
        display: inline-block;
        margin-top: 8px;
    }
    .info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
        margin-bottom: 25px;
    }
    .info-item {
        background: #f8f9fe;
        border-radius: 12px;
        padding: 12px 18px;
    }
    .info-item .label {
        font-size: 12px;
        font-weight: 600;
        color: #999;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .info-item .value {
        font-size: 16px;
        font-weight: 600;
        color: #333;
        margin-top: 3px;
    }
    .info-item .value .badge-role {
        background: #667eea;
        color: white;
        padding: 2px 14px;
        border-radius: 12px;
        font-size: 13px;
    }
    .stat-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 15px;
        margin-top: 20px;
        margin-bottom: 25px;
    }
    .stat-item {
        background: #f8f9fe;
        border-radius: 12px;
        padding: 15px;
        text-align: center;
    }
    .stat-item .num {
        font-size: 24px;
        font-weight: 700;
        color: #667eea;
    }
    .stat-item .lbl {
        font-size: 13px;
        color: #888;
        margin-top: 2px;
    }
    .edit-btn {
        background: transparent;
        border: 2px solid #667eea;
        color: #667eea;
        padding: 10px 30px;
        border-radius: 30px;
        font-weight: 600;
        transition: all 0.3s;
    }
    .edit-btn:hover {
        background: #667eea;
        color: white;
    }
    .save-btn {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        padding: 10px 35px;
        border-radius: 30px;
        font-weight: 600;
        color: white;
        transition: all 0.3s;
    }
    .save-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.35);
        color: white;
    }
    .btn-back {
        background: transparent;
        border: 2px solid #e8ecf1;
        padding: 10px 30px;
        border-radius: 30px;
        font-weight: 600;
        color: #555;
        transition: all 0.3s;
        text-decoration: none;
    }
    .btn-back:hover {
        border-color: #667eea;
        color: #667eea;
    }
    .form-control-edit {
        border-radius: 12px;
        border: 1.5px solid #e8ecf1;
        padding: 12px 16px;
        font-size: 15px;
        transition: all 0.3s;
        width: 100%;
    }
    .form-control-edit:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
    }
    .edit-section {
        display: none;
        margin-top: 20px;
        border-top: 1.5px solid #f0f0f0;
        padding-top: 20px;
    }
    .edit-section.active {
        display: block;
    }
    .form-label-edit {
        font-weight: 600;
        color: #333;
        margin-bottom: 5px;
        font-size: 14px;
    }
    @media (max-width: 576px) {
        .profile-card { padding: 20px; }
        .info-grid { grid-template-columns: 1fr; }
        .stat-grid { grid-template-columns: 1fr 1fr; }
        .btn-group-custom { flex-direction: column; align-items: stretch; }
    }
</style>

<div class="profile-container">
    <div class="profile-card">

        <!-- HEADER -->
        <div class="profile-header">
            <div class="profile-avatar">
                <i class="fas fa-user"></i>
            </div>
            <h2 id="display-name">{{ $user->name }}</h2>
            <div class="email" id="display-email">{{ $user->email }}</div>
            <span class="badge-premium">⭐ Premium Member</span>
        </div>

        <!-- INFO GRID -->
        <div class="info-grid" id="info-display">
            <div class="info-item">
                <div class="label">Nama Lengkap</div>
                <div class="value" id="display-name-value">{{ $user->name }}</div>
            </div>
            <div class="info-item">
                <div class="label">Email</div>
                <div class="value" id="display-email-value">{{ $user->email }}</div>
            </div>
            <div class="info-item">
                <div class="label">No Handphone</div>
                <div class="value" id="display-phone-value">{{ $user->phone ?? '-' }}</div>
            </div>
            <div class="info-item">
                <div class="label">Role</div>
                <div class="value"><span class="badge-role">{{ $user->role ?? 'Pasien' }}</span></div>
            </div>
            <div class="info-item">
                <div class="label">Member Sejak</div>
                <div class="value">{{ $user->created_at->format('d F Y') }}</div>
            </div>
            <div class="info-item">
                <div class="label">Status</div>
                <div class="value"><span style="color:#28a745;">✅ Aktif</span></div>
            </div>
        </div>

        <!-- STATISTIK -->
        <h6 style="font-weight:700; color:#333; margin-bottom:15px;"><i class="fas fa-chart-bar me-2" style="color:#667eea;"></i> Statistik Saya</h6>
        <div class="stat-grid">
            <div class="stat-item">
                <div class="num">{{ App\Models\Consultation::where('patient_id', $user->id)->count() }}</div>
                <div class="lbl">Total</div>
            </div>
            <div class="stat-item">
                <div class="num" style="color:#43e97b;">{{ App\Models\Consultation::where('patient_id', $user->id)->where('status','completed')->count() }}</div>
                <div class="lbl">Selesai</div>
            </div>
            <div class="stat-item">
                <div class="num" style="color:#f093fb;">{{ App\Models\Consultation::where('patient_id', $user->id)->where('status','pending')->count() }}</div>
                <div class="lbl">Menunggu</div>
            </div>
            <div class="stat-item">
                <div class="num" style="color:#fa709a; font-size:18px;">Rp {{ number_format(App\Models\Consultation::where('patient_id', $user->id)->sum('fee'), 0, ',', '.') }}</div>
                <div class="lbl">Biaya</div>
            </div>
        </div>

        <!-- BUTTON GROUP -->
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <a href="{{ route('dashboard') }}" class="btn-back">
                <i class="fas fa-arrow-left me-2"></i> Beranda
            </a>
            <button class="edit-btn" id="toggleEditBtn">
                <i class="fas fa-edit me-2"></i> Edit Profil
            </button>
        </div>

        <!-- FORM EDIT (HIDDEN) -->
        <div class="edit-section" id="editForm">
            <h6 class="mb-3" style="font-weight:700; color:#667eea;"><i class="fas fa-pen me-2"></i> Edit Profil</h6>

            <form action="{{ route('profile.update') }}" method="POST" id="profileForm">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label-edit">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control-edit" value="{{ old('name', $user->name) }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label-edit">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control-edit" value="{{ old('email', $user->email) }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label-edit">No Handphone</label>
                        <input type="text" name="phone" class="form-control-edit" value="{{ old('phone', $user->phone) }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label-edit">Password (kosongkan jika tidak diubah)</label>
                        <input type="password" name="password" class="form-control-edit" placeholder="Masukkan password baru">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label-edit">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="form-control-edit" placeholder="Konfirmasi password baru">
                    </div>
                </div>

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="d-flex gap-2 mt-2">
                    <button type="button" class="btn-back" id="cancelEditBtn" style="border-color:#dc3545; color:#dc3545;">
                        <i class="fas fa-times me-2"></i> Batal
                    </button>
                    <button type="submit" class="save-btn">
                        <i class="fas fa-save me-2"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const toggleBtn = document.getElementById('toggleEditBtn');
    const editForm = document.getElementById('editForm');
    const cancelBtn = document.getElementById('cancelEditBtn');

    toggleBtn.addEventListener('click', function() {
        editForm.classList.toggle('active');
        if (editForm.classList.contains('active')) {
            toggleBtn.innerHTML = '<i class="fas fa-times me-2"></i> Tutup Edit';
            toggleBtn.style.borderColor = '#dc3545';
            toggleBtn.style.color = '#dc3545';
        } else {
            toggleBtn.innerHTML = '<i class="fas fa-edit me-2"></i> Edit Profil';
            toggleBtn.style.borderColor = '#667eea';
            toggleBtn.style.color = '#667eea';
        }
    });

    cancelBtn.addEventListener('click', function() {
        editForm.classList.remove('active');
        toggleBtn.innerHTML = '<i class="fas fa-edit me-2"></i> Edit Profil';
        toggleBtn.style.borderColor = '#667eea';
        toggleBtn.style.color = '#667eea';
    });
});
</script>
@endsection