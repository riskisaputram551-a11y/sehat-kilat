@extends('layouts.app')

@section('content')
<style>
    .ai-container {
        max-width: 850px;
        margin: 40px auto;
        padding: 0 20px;
    }
    .ai-card {
        background: #ffffff;
        border-radius: 24px;
        padding: 40px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
        border: 1px solid #f0f0f0;
    }
    .ai-header {
        text-align: center;
        margin-bottom: 30px;
    }
    .ai-header .icon {
        font-size: 50px;
        color: #667eea;
        background: #f0f4ff;
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 15px;
    }
    .ai-header h2 {
        font-weight: 700;
        color: #1a1a2e;
        margin-bottom: 5px;
    }
    .ai-header p {
        color: #888;
        font-size: 16px;
    }
    .info-box {
        background: #f8f9fe;
        border-radius: 12px;
        padding: 16px 20px;
        border-left: 4px solid #667eea;
        margin-bottom: 25px;
        font-size: 14px;
        color: #444;
    }
    .info-box strong {
        color: #667eea;
    }
    .form-label {
        font-weight: 600;
        color: #333;
        margin-bottom: 8px;
    }
    .form-control {
        border-radius: 12px;
        border: 1.5px solid #e8ecf1;
        padding: 14px 18px;
        font-size: 15px;
        transition: all 0.3s;
    }
    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
    }
    .form-text {
        font-size: 13px;
        color: #999;
        margin-top: 6px;
    }
    .btn-group-custom {
        display: flex;
        gap: 15px;
        justify-content: space-between;
        align-items: center;
        margin-top: 25px;
        flex-wrap: wrap;
    }
    .btn-back {
        background: transparent;
        border: 2px solid #e8ecf1;
        padding: 12px 30px;
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
    .btn-submit {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        padding: 12px 40px;
        border-radius: 30px;
        font-weight: 600;
        color: white;
        transition: all 0.3s;
        text-decoration: none;
    }
    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.35);
        color: white;
    }
    .example-section {
        margin-top: 35px;
        padding-top: 25px;
        border-top: 1.5px solid #f0f0f0;
    }
    .example-section h6 {
        font-weight: 700;
        color: #667eea;
        margin-bottom: 15px;
    }
    .category-title {
        font-size: 13px;
        font-weight: 700;
        color: #667eea;
        margin-top: 15px;
        margin-bottom: 8px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .tag-group {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }
    .tag {
        background: #f5f7ff;
        padding: 8px 18px;
        border-radius: 20px;
        font-size: 13px;
        color: #667eea;
        cursor: pointer;
        border: 1px solid #e8edff;
        transition: all 0.25s;
        user-select: none;
    }
    .tag:hover {
        background: #667eea;
        color: #fff;
        border-color: #667eea;
        transform: translateY(-2px);
    }
    @media (max-width: 576px) {
        .ai-card { padding: 20px; }
        .btn-group-custom { flex-direction: column; align-items: stretch; }
        .btn-back, .btn-submit { text-align: center; width: 100%; }
    }
</style>

<div class="ai-container">
    <div class="ai-card">
        <div class="ai-header">
            <div class="icon">
                <i class="fas fa-robot"></i>
            </div>
            <h2>Konsultasi AI</h2>
            <p>Gratis • Dijawab otomatis oleh sistem AI</p>
        </div>

        <div class="info-box">
            <i class="fas fa-info-circle me-2" style="color: #667eea;"></i>
            <strong>Informasi:</strong> Konsultasi AI adalah layanan gratis yang memberikan saran kesehatan otomatis berdasarkan keluhan Anda. Untuk konsultasi dengan dokter sungguhan, silakan gunakan fitur <strong>Konsultasi Dokter (Berbayar)</strong>.
        </div>

        <form action="{{ route('ai-consultations.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Keluhan / Pertanyaan <span class="text-danger">*</span></label>
                <textarea name="complaint" rows="5" class="form-control @error('complaint') is-invalid @enderror"
                          placeholder="Contoh: Saya demam selama 2 hari, suhu 38.5°C, disertai batuk dan sakit kepala. Apa yang harus saya lakukan?"
                          required>{{ old('complaint') }}</textarea>
                @error('complaint')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
                <div class="form-text">
                    <i class="fas fa-info-circle me-1"></i> Minimal 10 karakter. Semakin detail keluhan, semakin akurat saran yang diberikan.
                </div>
            </div>

            <div class="btn-group-custom">
                <a href="{{ route('dashboard') }}" class="btn-back">
                    <i class="fas fa-arrow-left me-2"></i> Kembali
                </a>
                <button type="submit" class="btn-submit">
                    <i class="fas fa-paper-plane me-2"></i> Kirim & Dapatkan Jawaban
                </button>
            </div>
        </form>

        <div class="example-section">
            <h6><i class="fas fa-lightbulb"></i> Contoh pertanyaan yang bisa ditanyakan:</h6>

            <div class="category-title">🌡️ Demam & Panas</div>
            <div class="tag-group">
                <span class="tag" onclick="fillComplaint(this)">Anak saya demam tinggi, bagaimana cara menanganinya?</span>
                <span class="tag" onclick="fillComplaint(this)">Saya demam 3 hari tidak turun, apa yang harus saya lakukan?</span>
                <span class="tag" onclick="fillComplaint(this)">Demam disertai ruam merah di kulit, apa penyebabnya?</span>
            </div>

            <div class="category-title">🤧 Batuk & Pilek</div>
            <div class="tag-group">
                <span class="tag" onclick="fillComplaint(this)">Saya batuk sudah seminggu, obat apa yang cocok?</span>
                <span class="tag" onclick="fillComplaint(this)">Batuk berdahak berwarna hijau, apakah berbahaya?</span>
                <span class="tag" onclick="fillComplaint(this)">Batuk disertai sesak napas, apa yang harus saya lakukan?</span>
            </div>

            <div class="category-title">🤕 Sakit Kepala & Pusing</div>
            <div class="tag-group">
                <span class="tag" onclick="fillComplaint(this)">Sakit kepala sebelah kiri sudah 2 hari, obat apa yang bagus?</span>
                <span class="tag" onclick="fillComplaint(this)">Pusing berputar-putar sampai mual, apa penyebabnya?</span>
                <span class="tag" onclick="fillComplaint(this)">Sakit kepala disertai muntah, apakah harus ke rumah sakit?</span>
            </div>

            <div class="category-title">🍲 Maag & Lambung</div>
            <div class="tag-group">
                <span class="tag" onclick="fillComplaint(this)">Saya maag kambuh, bagaimana cara mengatasinya?</span>
                <span class="tag" onclick="fillComplaint(this)">Perut terasa perih dan nyeri, makanan apa yang harus dihindari?</span>
                <span class="tag" onclick="fillComplaint(this)">Asam lambung naik terus, obat apa yang cocok?</span>
            </div>

            <div class="category-title">🩹 Alergi & Gatal</div>
            <div class="tag-group">
                <span class="tag" onclick="fillComplaint(this)">Badan gatal-gatal setelah makan seafood, apa yang harus saya lakukan?</span>
                <span class="tag" onclick="fillComplaint(this)">Muncul biduran di seluruh tubuh, obat apa yang bagus?</span>
                <span class="tag" onclick="fillComplaint(this)">Alergi debu, bagaimana cara mencegahnya?</span>
            </div>
        </div>
    </div>
</div>

<script>
function fillComplaint(element) {
    const textarea = document.querySelector('textarea[name="complaint"]');
    textarea.value = element.textContent;
    textarea.focus();
}
</script>
@endsection