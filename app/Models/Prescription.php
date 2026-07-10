<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    use HasFactory;

    protected $fillable = ['consultation_id', 'medicine_name', 'dosage', 'frequency', 'duration', 'notes'];

    public function consultation()
    {
        return $this->belongsTo(Consultation::class);
    }
}