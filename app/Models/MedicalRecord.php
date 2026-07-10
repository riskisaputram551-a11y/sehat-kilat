<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
{
    protected $fillable = [
        'consultation_id', 'diagnosis', 'prescription', 'notes',
        'blood_pressure', 'weight', 'height', 'temperature', 'next_control'
    ];

    public function consultation()
    {
        return $this->belongsTo(Consultation::class);
    }
}