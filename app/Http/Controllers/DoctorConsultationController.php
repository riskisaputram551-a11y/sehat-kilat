<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use App\Models\User;
use App\Models\Category;
use App\Models\Payment;
use App\Helpers\NotificationHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DoctorConsultationController extends Controller
{
    public function index()
    {
        $consultations = Consultation::where('patient_id', Auth::id())
            ->where('consultation_type', 'doctor')
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('patient.doctor-consultations', compact('consultations'));
    }

    public function create()
    {
        $doctors = User::where('role', 'dokter')->get();
        $categories = Category::all();
        return view('patient.doctor-consultation-form', compact('doctors', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:categories,id',
            'consultation_date' => 'required|date|after:today',
            'consultation_time' => 'required',
            'complaint' => 'required|min:10',
        ]);

        $consultation = Consultation::create([
            'patient_id' => Auth::id(),
            'doctor_id' => $request->doctor_id,
            'category_id' => $request->category_id,
            'complaint' => $request->complaint,
            'consultation_type' => 'doctor',
            'status' => 'pending',
            'consultation_date' => $request->consultation_date,
            'consultation_time' => $request->consultation_time,
            'fee' => 150000,
            'code' => 'CONS-DOC-' . strtoupper(uniqid()),
        ]);

        Payment::create([
            'consultation_id' => $consultation->id,
            'amount' => 150000,
            'tax' => 15000,
            'total_amount' => 165000,
            'status' => 'pending',
            'invoice_number' => 'INV-' . date('Ymd') . '-' . strtoupper(uniqid()),
        ]);

        // NOTIFIKASI
        NotificationHelper::send(
            Auth::id(),
            'Konsultasi Dokter Berhasil Diajukan',
            'Konsultasi Anda dengan ' . ($consultation->doctor->name ?? 'Dokter') . ' berhasil diajukan. Silakan lakukan pembayaran.',
            'success',
            route('doctor-consultations.payment', $consultation)
        );

        return redirect()->route('doctor-consultations.payment', $consultation)
            ->with('success', 'Konsultasi dokter berhasil diajukan! Silakan lakukan pembayaran.');
    }

    public function show(Consultation $consultation)
    {
        if ($consultation->patient_id != Auth::id()) {
            abort(403);
        }
        return view('patient.doctor-consultation-show', compact('consultation'));
    }

    public function payment(Consultation $consultation)
    {
        if ($consultation->patient_id != Auth::id()) {
            abort(403);
        }
        $payment = $consultation->payment;
        return view('patient.doctor-payment', compact('consultation', 'payment'));
    }

    public function uploadPaymentProof(Request $request, Consultation $consultation)
    {
        $request->validate([
            'proof' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('proof')) {
            $path = $request->file('proof')->store('payment_proofs', 'public');
            
            $consultation->payment->update([
                'proof' => $path,
                'status' => 'paid',
                'payment_date' => now(),
                'method' => 'transfer',
            ]);

            $consultation->update(['status' => 'approved']);

            // NOTIFIKASI
            NotificationHelper::send(
                $consultation->patient_id,
                'Bukti Pembayaran Terupload',
                'Bukti pembayaran untuk konsultasi ' . $consultation->code . ' berhasil diupload. Menunggu konfirmasi admin.',
                'info',
                route('doctor-consultations.show', $consultation)
            );
        }

        return redirect()->route('doctor-consultations.show', $consultation)
            ->with('success', 'Bukti pembayaran berhasil diupload! Menunggu konfirmasi dokter.');
    }
}