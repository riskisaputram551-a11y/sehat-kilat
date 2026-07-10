<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Consultation;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ConsultationsExport;

class ReportController extends Controller
{
    public function index()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
        $totalPatients = User::where('role', 'pasien')->count();
        $totalDoctors = User::where('role', 'dokter')->count();
        $totalConsultations = Consultation::count();
        $totalRevenue = Payment::where('status', 'paid')->sum('total_amount');
        
        $monthlyData = Consultation::select(
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
            $found = $monthlyData->where('month', $i)->first();
            $totals[] = $found ? $found->total : 0;
        }

        $consultations = Consultation::with(['patient', 'doctor'])
            ->latest()
            ->take(20)
            ->get();

        return view('admin.reports.index', compact(
            'totalPatients',
            'totalDoctors',
            'totalConsultations',
            'totalRevenue',
            'months',
            'totals',
            'consultations'
        ));
    }

    public function exportPdf()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
        $consultations = Consultation::with(['patient', 'doctor'])
            ->latest()
            ->get();

        $totalPatients = User::where('role', 'pasien')->count();
        $totalDoctors = User::where('role', 'dokter')->count();
        $totalConsultations = Consultation::count();
        $totalRevenue = Payment::where('status', 'paid')->sum('total_amount');

        $pdf = Pdf::loadView('admin.reports.pdf', compact(
            'consultations',
            'totalPatients',
            'totalDoctors',
            'totalConsultations',
            'totalRevenue'
        ));

        return $pdf->download('laporan-konsultasi-' . date('Y-m-d') . '.pdf');
    }

    public function exportExcel()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
        return Excel::download(new ConsultationsExport, 'laporan-konsultasi-' . date('Y-m-d') . '.xlsx');
    }
}