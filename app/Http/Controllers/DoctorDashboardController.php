<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DoctorDashboardController extends Controller
{
    public function index()
    {
        $doctor = Auth::user();

        $stats = [
            'total_patients' => Consultation::where('doctor_id', $doctor->id)->distinct('patient_id')->count(),
            'total_consultations' => Consultation::where('doctor_id', $doctor->id)->count(),
            'pending' => Consultation::where('doctor_id', $doctor->id)->where('status', 'pending')->count(),
            'completed' => Consultation::where('doctor_id', $doctor->id)->where('status', 'completed')->count(),
            'today_schedule' => Consultation::where('doctor_id', $doctor->id)
                ->whereDate('consultation_date', today())
                ->count(),
            'total_revenue' => Consultation::where('doctor_id', $doctor->id)->sum('fee'),
        ];

        $consultations = Consultation::where('doctor_id', $doctor->id)
            ->with('patient')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('doctor.dashboard', compact('stats', 'consultations'));
    }
}