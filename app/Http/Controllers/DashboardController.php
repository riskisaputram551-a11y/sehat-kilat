<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Consultation;
use App\Models\Category;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        if ($user->role == 'admin') {
            $stats = [
                'total_patients' => User::where('role', 'pasien')->count(),
                'total_doctors' => User::where('role', 'dokter')->count(),
                'total_consultations' => Consultation::count(),
                'total_revenue' => Payment::where('status', 'paid')->sum('total_amount'),
                'pending_consultations' => Consultation::where('status', 'pending')->count(),
                'completed_consultations' => Consultation::where('status', 'completed')->count(),
            ];
            
            // Data untuk grafik (konsultasi per bulan)
            $chartData = Consultation::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as total')
            )
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();
            
            $months = [];
            $totals = [];
            for ($i = 1; $i <= 12; $i++) {
                $months[] = date('F', mktime(0, 0, 0, $i, 1));
                $found = $chartData->where('month', $i)->first();
                $totals[] = $found ? $found->total : 0;
            }
            
            return view('admin.dashboard', compact('stats', 'months', 'totals'));
        } 
        elseif ($user->role == 'dokter') {
            $stats = [
                'total_patients' => Consultation::where('doctor_id', $user->id)->distinct('patient_id')->count('patient_id'),
                'total_consultations' => Consultation::where('doctor_id', $user->id)->count(),
                'pending_consultations' => Consultation::where('doctor_id', $user->id)->where('status', 'pending')->count(),
                'completed_consultations' => Consultation::where('doctor_id', $user->id)->where('status', 'completed')->count(),
                'today_schedule' => Consultation::where('doctor_id', $user->id)->whereDate('consultation_date', today())->count(),
            ];
            
            $recentConsultations = Consultation::where('doctor_id', $user->id)
                ->with(['patient', 'category'])
                ->latest()
                ->take(5)
                ->get();
                
            return view('doctor.dashboard', compact('stats', 'recentConsultations'));
        } 
        else {
            $stats = [
                'total_consultations' => Consultation::where('patient_id', $user->id)->count(),
                'pending_consultations' => Consultation::where('patient_id', $user->id)->where('status', 'pending')->count(),
                'completed_consultations' => Consultation::where('patient_id', $user->id)->where('status', 'completed')->count(),
                'total_spent' => Payment::whereHas('consultation', function($q) use ($user) {
                    $q->where('patient_id', $user->id);
                })->where('status', 'paid')->sum('total_amount'),
            ];
            
            $recentConsultations = Consultation::where('patient_id', $user->id)
                ->with(['doctor', 'category'])
                ->latest()
                ->take(5)
                ->get();
                
            return view('patient.dashboard', compact('stats', 'recentConsultations'));
        }
    }
}