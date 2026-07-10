<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'phone', 'address', 'birth_date',
        'gender', 'role', 'specialist', 'license_number', 'bio', 'photo'
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'birth_date' => 'date',
    ];

    // Relasi sebagai dokter
    public function consultationsAsDoctor()
    {
        return $this->hasMany(Consultation::class, 'doctor_id');
    }

    // Relasi sebagai pasien
    public function consultationsAsPatient()
    {
        return $this->hasMany(Consultation::class, 'patient_id');
    }

    // Relasi jadwal dokter
    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'doctor_id');
    }

    // Cek role
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isDoctor()
    {
        return $this->role === 'dokter';
    }

    public function isPatient()
    {
        return $this->role === 'pasien';
    }
}