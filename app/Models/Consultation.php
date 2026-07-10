<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Consultation extends Model
{
    protected $fillable = [
        'patient_id', 'doctor_id', 'category_id', 'code', 'status',
        'consultation_date', 'consultation_time', 'complaint', 'doctor_note',
        'attachment', 'type', 'fee', 'consultation_type', 'ai_response'
    ];

    protected $casts = [
        'consultation_date' => 'date',
        'consultation_time' => 'datetime',
    ];

    // Relasi ke pasien
    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    // Relasi ke dokter
    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    // Relasi ke kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi ke pembayaran
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    // Relasi ke rekam medis
    public function medicalRecord()
    {
        return $this->hasOne(MedicalRecord::class);
    }

    // Cek apakah konsultasi AI
    public function isAiConsultation()
    {
        return $this->consultation_type === 'ai';
    }

    // Cek apakah konsultasi Dokter
    public function isDoctorConsultation()
    {
        return $this->consultation_type === 'doctor';
    }

    // Auto generate kode konsultasi
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($consultation) {
            $consultation->code = 'CONS-' . strtoupper(Str::random(8));
        });
    }
}