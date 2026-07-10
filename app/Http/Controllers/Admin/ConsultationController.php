<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Consultation;
use App\Helpers\NotificationHelper;
use Illuminate\Http\Request;

class ConsultationController extends Controller
{
    public function index()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
        $consultations = Consultation::with(['patient', 'doctor'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('admin.consultations.index', compact('consultations'));
    }

    public function confirm(Consultation $consultation)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
        $consultation->update(['status' => 'completed']);

        NotificationHelper::send(
            $consultation->patient_id,
            '✅ Konsultasi Berhasil Dikonfirmasi',
            'Konsultasi Anda dengan ' . ($consultation->doctor->name ?? 'Dokter') . ' telah selesai. Terima kasih telah menggunakan SEHAT KILAT!',
            'success',
            route('doctor-consultations.show', $consultation)
        );

        return redirect()->back()->with('success', 'Konsultasi berhasil dikonfirmasi!');
    }
}