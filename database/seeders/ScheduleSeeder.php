// database/seeders/ScheduleSeeder.php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Schedule;
use App\Models\User;

class ScheduleSeeder extends Seeder
{
    public function run(): void
    {
        $doctors = User::where('role', 'dokter')->get();
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

        foreach ($doctors as $doctor) {
            foreach ($days as $index => $day) {
                Schedule::create([
                    'doctor_id' => $doctor->id,
                    'day' => $day,
                    'start_time' => '09:00:00',
                    'end_time' => '17:00:00',
                    'slot_duration' => 30,
                    'max_patients' => 10,
                    'is_active' => $index < 5, // aktif senin-jumat
                ]);
            }
        }
    }
}