// database/seeders/UserSeeder.php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin Utama',
            'email' => 'admin@konsultasi.com',
            'password' => Hash::make('password'),
            'phone' => '081234567890',
            'role' => 'admin',
            'gender' => 'L',
        ]);

        // Dokter 1
        User::create([
            'name' => 'dr. Ahmad Wijaya, Sp.PD',
            'email' => 'dokter1@konsultasi.com',
            'password' => Hash::make('password'),
            'phone' => '081234567891',
            'role' => 'dokter',
            'specialist' => 'Penyakit Dalam',
            'license_number' => 'STR123456',
            'bio' => 'Dokter spesialis penyakit dalam dengan pengalaman 10 tahun',
            'gender' => 'L',
        ]);

        // Dokter 2
        User::create([
            'name' => 'dr. Siti Nurhaliza, Sp.A',
            'email' => 'dokter2@konsultasi.com',
            'password' => Hash::make('password'),
            'phone' => '081234567892',
            'role' => 'dokter',
            'specialist' => 'Anak',
            'license_number' => 'STR123457',
            'bio' => 'Dokter spesialis anak yang ramah dan berpengalaman',
            'gender' => 'P',
        ]);

        // Dokter 3
        User::create([
            'name' => 'dr. Budi Santoso, Sp.JP',
            'email' => 'dokter3@konsultasi.com',
            'password' => Hash::make('password'),
            'phone' => '081234567893',
            'role' => 'dokter',
            'specialist' => 'Jantung',
            'license_number' => 'STR123458',
            'bio' => 'Dokter spesialis jantung yang sudah berpengalaman',
            'gender' => 'L',
        ]);

        // Pasien 1
        User::create([
            'name' => 'Andi Prasetyo',
            'email' => 'pasien1@konsultasi.com',
            'password' => Hash::make('password'),
            'phone' => '081234567894',
            'address' => 'Jl. Mawar No. 1, Jakarta',
            'birth_date' => '1995-05-15',
            'role' => 'pasien',
            'gender' => 'L',
        ]);

        // Pasien 2
        User::create([
            'name' => 'Budi Santoso',
            'email' => 'pasien2@konsultasi.com',
            'password' => Hash::make('password'),
            'phone' => '081234567895',
            'address' => 'Jl. Melati No. 2, Bandung',
            'birth_date' => '1998-10-20',
            'role' => 'pasien',
            'gender' => 'L',
        ]);
    }
}