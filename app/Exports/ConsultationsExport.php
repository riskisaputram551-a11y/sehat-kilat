<?php

namespace App\Exports;

use App\Models\Consultation;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ConsultationsExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Consultation::with(['patient', 'doctor'])->latest()->get();
    }

    public function headings(): array
    {
        return [
            'Kode',
            'Pasien',
            'Dokter',
            'Keluhan',
            'Tanggal Konsultasi',
            'Status',
            'Biaya',
            'Tanggal Dibuat'
        ];
    }

    public function map($consultation): array
    {
        return [
            $consultation->code,
            $consultation->patient->name ?? '-',
            $consultation->doctor->name ?? '-',
            substr($consultation->complaint, 0, 50) . '...',
            $consultation->consultation_date,
            $consultation->status,
            'Rp ' . number_format($consultation->fee, 0, ',', '.'),
            $consultation->created_at->format('d/m/Y H:i'),
        ];
    }
}