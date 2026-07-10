<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AIConsultation extends Model
{
    protected $table = 'consultations';
    
    protected $fillable = [
        'patient_id', 'complaint', 'ai_response', 'consultation_type', 'status'
    ];
}