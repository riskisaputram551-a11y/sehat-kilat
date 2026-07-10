<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use App\Models\User;
use App\Models\Category;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ConsultationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Index untuk pasien (lihat konsultasi saya)
    public function index()
    {
        $user = auth()->user();
        
        if ($user->role == 'admin') {
            $consultations = Consultation::with(['patient', 'doctor', 'category'])->latest()->paginate(10);
            return view('admin.consultations.index', compact('consultations'));
        } 
        elseif ($user->role == 'dokter') {
            $consultations = Consultation::with(['patient', 'category'])
                ->where('doctor_id', $user->id)
                ->latest()
                ->paginate(10);
            return view('doctor.consultations.index', compact('consultations'));
        } 
        else {
            $consultations = Consultation::with(['doctor', 'category', 'payment'])
                ->where('patient_id', $user->id)
                ->latest()
                ->paginate(10);
            return view('patient.consultations.index', compact('consultations'));
        }
    }

    // Form buat konsultasi
    public function create()
    {
        $doctors = User::where('role', 'dokter')->get();
        $categories = Category::where('is_active', true)->get();
        return view('patient.consultations.create', compact('doctors', 'categories'));
    }

    // Simpan konsultasi
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'doctor_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:categories,id',
            'consultation_date' => 'required|date|after:today',
            'consultation_time' => 'required',
            'complaint' => 'required|min:10',
            'type' => 'required|in:online,offline',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $consultation = Consultation::create([
            'patient_id' => auth()->id(),
            'doctor_id' => $request->doctor_id,
            'category_id' => $request->category_id,
            'consultation_date' => $request->consultation_date,
            'consultation_time' => $request->consultation_time,
            'complaint' => $request->complaint,
            'type' => $request->type,
            'status' => 'pending',
            'fee' => 150000, // biaya konsultasi
        ]);

        // Buat payment pending
        Payment::create([
            'consultation_id' => $consultation->id,
            'amount' => 150000,
            'status' => 'pending',
        ]);

        return redirect()->route('consultations.index')
            ->with('success', 'Konsultasi berhasil diajukan, silakan lakukan pembayaran.');
    }

    // Detail konsultasi
    public function show(Consultation $consultation)
    {
        $this->authorizeConsultation($consultation);
        
        $consultation->load(['patient', 'doctor', 'category', 'payment', 'medicalRecord']);
        
        if (auth()->user()->role == 'admin') {
            return view('admin.consultations.show', compact('consultation'));
        } elseif (auth()->user()->role == 'dokter') {
            return view('doctor.consultations.show', compact('consultation'));
        } else {
            return view('patient.consultations.show', compact('consultation'));
        }
    }

    // Update status konsultasi (untuk dokter/admin)
    public function updateStatus(Request $request, Consultation $consultation)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,in_progress,completed,cancelled',
            'doctor_note' => 'nullable|string',
        ]);

        $consultation->update([
            'status' => $request->status,
            'doctor_note' => $request->doctor_note,
        ]);

        return redirect()->back()->with('success', 'Status konsultasi berhasil diupdate.');
    }

    // Cancel konsultasi (untuk pasien)
    public function cancel(Consultation $consultation)
    {
        if ($consultation->patient_id != auth()->id() && auth()->user()->role != 'admin') {
            abort(403);
        }

        if ($consultation->status == 'pending') {
            $consultation->update(['status' => 'cancelled']);
            
            // Update payment status
            if ($consultation->payment) {
                $consultation->payment->update(['status' => 'refunded']);
            }
            
            return redirect()->back()->with('success', 'Konsultasi berhasil dibatalkan.');
        }

        return redirect()->back()->with('error', 'Konsultasi tidak dapat dibatalkan.');
    }

    private function authorizeConsultation(Consultation $consultation)
    {
        $user = auth()->user();
        if ($user->role == 'admin') return true;
        if ($user->role == 'dokter' && $consultation->doctor_id == $user->id) return true;
        if ($user->role == 'pasien' && $consultation->patient_id == $user->id) return true;
        abort(403);
    }
}