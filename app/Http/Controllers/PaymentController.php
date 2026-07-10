<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Consultation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        if ($user->role == 'admin') {
            $payments = Payment::with('consultation.patient')->latest()->paginate(10);
            return view('admin.payments.index', compact('payments'));
        } else {
            $payments = Payment::whereHas('consultation', function($q) use ($user) {
                $q->where('patient_id', $user->id);
            })->with('consultation.doctor')->latest()->paginate(10);
            return view('patient.payments.index', compact('payments'));
        }
    }

    public function show(Payment $payment)
    {
        $this->authorizePayment($payment);
        return view('patient.payments.show', compact('payment'));
    }

    public function uploadProof(Request $request, Payment $payment)
    {
        $request->validate([
            'proof' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('proof')) {
            $path = $request->file('proof')->store('payment_proofs', 'public');
            $payment->update([
                'proof' => $path,
                'status' => 'paid',
                'payment_date' => now(),
                'method' => 'transfer',
            ]);

            // Update consultation status
            $payment->consultation->update(['status' => 'approved']);
        }

        return redirect()->back()->with('success', 'Bukti pembayaran berhasil diupload.');
    }

    public function updateStatus(Request $request, Payment $payment)
    {
        $request->validate([
            'status' => 'required|in:pending,paid,failed',
        ]);

        $payment->update(['status' => $request->status]);
        
        if ($request->status == 'paid') {
            $payment->consultation->update(['status' => 'approved']);
        }

        return redirect()->back()->with('success', 'Status pembayaran berhasil diupdate.');
    }

    private function authorizePayment(Payment $payment)
    {
        $user = auth()->user();
        if ($user->role == 'admin') return true;
        if ($user->role == 'pasien' && $payment->consultation->patient_id == $user->id) return true;
        abort(403);
    }

    // Generate invoice (bonus)
    public function invoice(Payment $payment)
    {
        $this->authorizePayment($payment);
        return view('patient.payments.invoice', compact('payment'));
    }
}