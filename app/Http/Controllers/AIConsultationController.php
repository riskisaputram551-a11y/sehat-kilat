<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class AIConsultationController extends Controller
{
    public function index()
    {
        $consultations = Consultation::where('patient_id', Auth::id())
            ->where('consultation_type', 'ai')
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('patient.ai-consultations', compact('consultations'));
    }

    public function create()
    {
        return view('patient.ai-consultation-form');
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'complaint' => 'required|min:10|max:1000',
        ]);

        // Ambil keluhan
        $complaint = $request->complaint;
        
        // Generate AI Response
        $aiResponse = $this->getAIResponse($complaint);

        // Simpan ke database
        $consultation = Consultation::create([
            'patient_id' => Auth::id(),
            'doctor_id' => null,
            'category_id' => 1,
            'complaint' => $complaint,
            'ai_response' => $aiResponse,
            'consultation_type' => 'ai',
            'status' => 'completed',
            'consultation_date' => now(),
            'consultation_time' => now(),
            'fee' => 0,
        ]);

        return redirect()->route('ai-consultations.show', $consultation)
            ->with('success', 'Konsultasi AI berhasil!');
    }

    public function show(Consultation $consultation)
    {
        if ($consultation->patient_id != Auth::id()) {
            abort(403);
        }
        return view('patient.ai-consultation-show', compact('consultation'));
    }

    public function exportPdf($id)
    {
        $consultation = Consultation::with(['patient', 'doctor'])->findOrFail($id);
        
        // Parse resep dari AI response
        $resep = $consultation->ai_response ?? '';
        $obatList = [];
        
        if (strpos($resep, 'Obat yang bisa dikonsumsi:') !== false) {
            $parts = explode('Obat yang bisa dikonsumsi:', $resep);
            if (isset($parts[1])) {
                $obatPart = explode('⚠️', $parts[1])[0];
                $lines = explode('-', $obatPart);
                foreach ($lines as $line) {
                    $line = trim($line);
                    if (!empty($line) && strlen($line) > 3) {
                        $obatList[] = $line;
                    }
                }
            }
        }
        
        if (empty($obatList) && !empty($resep)) {
            $obatList = [trim($resep)];
        }

        $pdf = Pdf::loadView('patient.prescription-pdf', compact('consultation', 'obatList'));
        return $pdf->download('resep-obat-' . $consultation->code . '.pdf');
    }

    private function getAIResponse($complaint)
    {
        $complaintLower = strtolower($complaint);
        
        // Respon berdasarkan keyword
        if (strpos($complaintLower, 'demam') !== false || strpos($complaintLower, 'panas') !== false) {
            return "🌡️ **Berdasarkan keluhan demam Anda:**\n\n" .
                   "📌 **Saran yang bisa dilakukan:**\n" .
                   "1. Istirahat yang cukup (minimal 8 jam)\n" .
                   "2. Minum air putih 2-3 liter per hari agar tidak dehidrasi\n" .
                   "3. Konsumsi paracetamol jika suhu >38°C (dewasa 500mg, anak sesuai berat badan)\n" .
                   "4. Kompres air hangat di dahi, leher, dan lipatan ketiak\n" .
                   "5. Kenakan pakaian tipis dan menyerap keringat\n\n" .
                   "⚠️ **Segera ke dokter jika:**\n" .
                   "- Demam lebih dari 3 hari tidak turun\n" .
                   "- Disertai kejang-kejang\n" .
                   "- Anak terlihat lemas dan tidak mau minum\n" .
                   "- Muncul ruam kemerahan di kulit\n\n" .
                   "Salam sehat dari SEHAT KILAT AI! 🏥";
        }
        
        if (strpos($complaintLower, 'batuk') !== false) {
            return "🤧 **Berdasarkan keluhan batuk Anda:**\n\n" .
                   "📌 **Saran yang bisa dilakukan:**\n" .
                   "- Minum air hangat yang dicampur madu dan jeruk nipis (untuk dewasa)\n" .
                   "- Hindari makanan dingin, gorengan, dan debu\n" .
                   "- Istirahat cukup dan konsumsi vitamin C\n" .
                   "- Gunakan masker agar tidak menular ke orang lain\n\n" .
                   "💊 **Obat yang bisa dikonsumsi:**\n" .
                   "- Obat batuk herbal (OBH Combi)\n" .
                   "- Jika batuk berdahak: Ambroxol atau Acetylcysteine\n" .
                   "- Jika batuk kering: Dextromethorphan\n\n" .
                   "⚠️ **Periksa ke dokter jika:**\n" .
                   "- Batuk lebih dari 7 hari\n" .
                   "- Disertai sesak napas atau napas berbunyi 'ngik-ngik'\n" .
                   "- Dahak berwarna hijau/kuning atau berdarah\n" .
                   "- Disertai demam tinggi\n\n" .
                   "Semoga lekas sembuh! 🌟";
        }
        
        if (strpos($complaintLower, 'sakit kepala') !== false || strpos($complaintLower, 'pusing') !== false) {
            return "🤕 **Berdasarkan keluhan sakit kepala:**\n\n" .
                   "🔍 **Kemungkinan penyebab:**\n" .
                   "- Kurang istirahat atau begadang\n" .
                   "- Dehidrasi (kurang minum)\n" .
                   "- Stres atau tegang otot leher\n" .
                   "- Tekanan darah tinggi atau rendah\n" .
                   "- Terlalu lama menatap layar (mata lelah)\n\n" .
                   "💊 **Saran dan pengobatan:**\n" .
                   "- Istirahat di ruangan gelap dan tenang\n" .
                   "- Minum air putih 2-3 gelas\n" .
                   "- Kompres dingin di dahi selama 10-15 menit\n" .
                   "- Pijat pelan area leher dan bahu\n" .
                   "- Konsumsi paracetamol atau ibuprofen jika perlu\n\n" .
                   "⚠️ **Segera ke IGD jika sakit kepala disertai:**\n" .
                   "- Muntah menyemprot\n" .
                   "- Kejang atau kehilangan kesadaran\n" .
                   "- Gangguan penglihatan (pandangan kabur/ganda)\n" .
                   "- Lemah pada satu sisi tubuh\n\n" .
                   "Jaga kesehatan ya! 💪";
        }
        
        if (strpos($complaintLower, 'maag') !== false || strpos($complaintLower, 'lambung') !== false || strpos($complaintLower, 'asam lambung') !== false) {
            return "🍲 **Berdasarkan keluhan maag/gastritis:**\n\n" .
                   "📌 **Saran pola makan:**\n" .
                   "- Makan teratur 3x sehari (jangan telat makan!)\n" .
                   "- Makan porsi kecil tapi sering (5-6x sehari)\n" .
                   "- Kunyah makanan secara perlahan\n" .
                   "- Jangan langsung tidur setelah makan (tunggu 2-3 jam)\n\n" .
                   "🚫 **Hindari makanan ini:**\n" .
                   "- Makanan pedas, asam, dan berlemak\n" .
                   "- Kopi, teh, soda, dan alkohol\n" .
                   "- Makanan yang digoreng\n" .
                   "- Cokelat dan mint\n\n" .
                   "💊 **Obat yang bisa dibeli bebas:**\n" .
                   "- Antasida (jika nyeri atau perih)\n" .
                   "- Omeprazole 20mg (diminum sebelum makan)\n\n" .
                   "⚠️ **Periksakan ke dokter jika:**\n" .
                   "- Nyeri tak kunjung reda setelah minum obat\n" .
                   "- BAB berwarna hitam seperti aspal\n" .
                   "- Muntah darah\n" .
                   "- Berat badan turun drastis\n\n" .
                   "Jaga pola makan ya! 🍽️";
        }

        if (strpos($complaintLower, 'alergi') !== false || strpos($complaintLower, 'gatal') !== false || strpos($complaintLower, 'biduran') !== false) {
            return "🩹 **Berdasarkan keluhan alergi/gatal-gatal:**\n\n" .
                   "📌 **Saran yang bisa dilakukan:**\n" .
                   "- Identifikasi dan hindari pemicu alergi (makanan/debu/udara dingin)\n" .
                   "- Mandi air dingin (jangan pakai air panas!)\n" .
                   "- Gunakan sabun yang lembut dan tanpa pewangi\n" .
                   "- Oleskan losion atau pelembab setelah mandi\n" .
                   "- JANGAN menggaruk area yang gatal (bisa infeksi!)\n" .
                   "- Potong kuku pendek untuk mengurangi risiko luka\n\n" .
                   "💊 **Obat yang bisa dikonsumsi:**\n" .
                   "- Antihistamin: CTM, Loratadine, atau Cetirizine\n" .
                   "- Salep kalamin untuk gatal di kulit\n" .
                   "- Kompres dingin untuk mengurangi rasa gatal\n\n" .
                   "⚠️ **Segera ke IGD jika:**\n" .
                   "- Sesak napas atau napas berbunyi 'ngik'\n" .
                   "- Bibir, kelopak mata, atau lidah bengkak\n" .
                   "- Tenggorokan terasa sesak\n" .
                   "- Pusing atau pingsan\n\n" .
                   "Semoga cepat sembuh! 🌸";
        }
        
        // Default response untuk keluhan lain
        return "🤖 **Terima kasih telah berkonsultasi dengan SEHAT KILAT AI**\n\n" .
               "📋 **Berdasarkan keluhan Anda:**\n" .
               "\"$complaint\"\n\n" .
               "💡 **Saran umum untuk menjaga kesehatan:**\n" .
               "✅ Istirahat yang cukup (7-8 jam per hari)\n" .
               "✅ Perbanyak minum air putih (minimal 2 liter/hari)\n" .
               "✅ Konsumsi makanan bergizi seimbang (sayur, buah, protein)\n" .
               "✅ Olahraga teratur minimal 30 menit/hari\n" .
               "✅ Kelola stres dengan baik (meditasi, hobi, relaksasi)\n" .
               "✅ Jaga kebersihan diri dan lingkungan\n" .
               "✅ Rutin cek kesehatan minimal 1 tahun sekali\n\n" .
               "🩺 **Jika keluhan berlanjut lebih dari 3 hari atau semakin parah**, silakan konsultasi dengan dokter profesional melalui fitur **Konsultasi Dokter (Berbayar)** untuk mendapatkan penanganan yang tepat.\n\n" .
               "---\n" .
               "Salam sehat, SEHAT KILAT AI\n" .
               "✨ *Kesehatan adalah investasi terbaik* ✨";
    }
}