<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Symptom extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'code', 'description'];

    public function consultations()
    {
        return $this->belongsToMany(Consultation::class);
    }
}