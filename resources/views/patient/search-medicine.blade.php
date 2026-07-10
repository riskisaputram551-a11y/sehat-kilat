@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h4 class="fw-bold mb-3"><i class="fas fa-search text-primary me-2"></i> Cari Obat</h4>

    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="input-group mb-3">
                        <input type="text" id="searchObat" class="form-control form-control-lg" placeholder="Cari obat... (contoh: batuk, demam, OBH, paracetamol)">
                        <button class="btn btn-primary" onclick="cariObat()"><i class="fas fa-search"></i></button>
                    </div>
                    <div id="hasilCari" class="mt-3"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
const daftarObat = {
    "batuk": [
        { nama: "OBH Combi", jenis: "Sirup", kegunaan: "Meredakan batuk berdahak" },
        { nama: "Ambroxol", jenis: "Tablet/Sirup", kegunaan: "Mengencerkan dahak" },
        { nama: "Acetylcysteine", jenis: "Tablet", kegunaan: "Mengencerkan dahak" },
        { nama: "Dextromethorphan", jenis: "Sirup/Tablet", kegunaan: "Meredakan batuk kering" },
        { nama: "Guaifenesin", jenis: "Tablet", kegunaan: "Mengencerkan dahak" },
        { nama: "Kombinasi OBH", jenis: "Sirup", kegunaan: "Meredakan batuk dan pilek" }
    ],
    "demam": [
        { nama: "Paracetamol", jenis: "Tablet/Sirup", kegunaan: "Menurunkan demam dan nyeri" },
        { nama: "Ibuprofen", jenis: "Tablet", kegunaan: "Menurunkan demam dan peradangan" },
        { nama: "Aspirin", jenis: "Tablet", kegunaan: "Menurunkan demam (dewasa)" },
        { nama: "Paracetamol Anak", jenis: "Sirup/Drops", kegunaan: "Menurunkan demam anak" }
    ],
    "maag": [
        { nama: "Antasida", jenis: "Tablet/Suspensi", kegunaan: "Menetralkan asam lambung" },
        { nama: "Omeprazole", jenis: "Kapsul", kegunaan: "Menghambat produksi asam lambung" },
        { nama: "Ranitidine", jenis: "Tablet", kegunaan: "Menghambat produksi asam lambung" },
        { nama: "Promag", jenis: "Tablet", kegunaan: "Meredakan maag dan perut kembung" }
    ],
    "alergi": [
        { nama: "CTM", jenis: "Tablet", kegunaan: "Antihistamin untuk alergi" },
        { nama: "Loratadine", jenis: "Tablet", kegunaan: "Antihistamin non-drowsy" },
        { nama: "Cetirizine", jenis: "Tablet", kegunaan: "Antihistamin untuk alergi" },
        { nama: "Salep Kalamin", jenis: "Salep", kegunaan: "Mengurangi gatal pada kulit" },
        { nama: "Fexofenadine", jenis: "Tablet", kegunaan: "Antihistamin alergi" }
    ],
    "sakit kepala": [
        { nama: "Paracetamol", jenis: "Tablet", kegunaan: "Meredakan sakit kepala" },
        { nama: "Ibuprofen", jenis: "Tablet", kegunaan: "Meredakan sakit kepala dan peradangan" },
        { nama: "Aspirin", jenis: "Tablet", kegunaan: "Meredakan sakit kepala (dewasa)" },
        { nama: "Mefenamic Acid", jenis: "Tablet", kegunaan: "Meredakan nyeri dan sakit kepala" }
    ],
    "flu": [
        { nama: "Decolgen", jenis: "Tablet", kegunaan: "Meredakan flu dan demam" },
        { nama: "Panadol Flu", jenis: "Tablet", kegunaan: "Meredakan gejala flu" },
        { nama: "Neo Rheumacyl", jenis: "Tablet", kegunaan: "Meredakan flu dan nyeri" },
        { nama: "Komix", jenis: "Sirup", kegunaan: "Meredakan flu dan batuk" }
    ],
    "gigi": [
        { nama: "Paracetamol", jenis: "Tablet", kegunaan: "Meredakan sakit gigi" },
        { nama: "Ibuprofen", jenis: "Tablet", kegunaan: "Meredakan sakit gigi dan radang" },
        { nama: "Mefenamic Acid", jenis: "Tablet", kegunaan: "Meredakan sakit gigi" },
        { nama: "Obat Kumur", jenis: "Cairan", kegunaan: "Meredakan radang gusi" }
    ]
};

function cariObat() {
    let keyword = document.getElementById('searchObat').value.toLowerCase().trim();
    let hasil = document.getElementById('hasilCari');
    
    if (!keyword) {
        hasil.innerHTML = `<div class="alert alert-warning">Silakan ketik nama obat atau penyakit.</div>`;
        return;
    }

    let found = [];
    for (let [penyakit, obatList] of Object.entries(daftarObat)) {
        if (penyakit.includes(keyword)) {
            found = found.concat(obatList.map(o => ({...o, penyakit: penyakit})));
        }
        obatList.forEach(o => {
            if (o.nama.toLowerCase().includes(keyword)) {
                found.push({...o, penyakit: penyakit});
            }
            if (o.kegunaan.toLowerCase().includes(keyword)) {
                found.push({...o, penyakit: penyakit});
            }
        });
    }

    if (found.length === 0) {
        hasil.innerHTML = `<div class="alert alert-info">Tidak ditemukan obat untuk "<strong>${keyword}</strong>".<br>Coba: batuk, demam, maag, alergi, sakit kepala, flu, gigi</div>`;
        return;
    }

    let html = `<div class="alert alert-success">Ditemukan ${found.length} obat untuk "${keyword}"</div><div class="list-group">`;
    found.forEach(o => {
        html += `
            <div class="list-group-item">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <strong>💊 ${o.nama}</strong>
                        <span class="badge bg-primary ms-2">${o.jenis}</span>
                        <span class="badge bg-secondary ms-1">${o.penyakit}</span>
                    </div>
                </div>
                <div class="mt-1 small text-muted">📌 ${o.kegunaan}</div>
            </div>
        `;
    });
    html += `</div>`;
    hasil.innerHTML = html;
}

// Enter key
document.getElementById('searchObat').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') cariObat();
});
</script>
@endsection