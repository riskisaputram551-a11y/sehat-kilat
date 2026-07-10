<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Konsultasi Umum',
                'icon' => 'fa-stethoscope',
                'description' => 'Layanan konsultasi umum untuk berbagai keluhan kesehatan'
            ],
            [
                'name' => 'Konsultasi Anak',
                'icon' => 'fa-child',
                'description' => 'Layanan konsultasi kesehatan khusus untuk anak-anak'
            ],
            [
                'name' => 'Konsultasi Jantung',
                'icon' => 'fa-heartbeat',
                'description' => 'Layanan konsultasi untuk masalah kesehatan jantung'
            ],
            [
                'name' => 'Konsultasi Kulit',
                'icon' => 'fa-allergies',
                'description' => 'Layanan konsultasi untuk masalah kulit dan kelamin'
            ],
            [
                'name' => 'Konsultasi Mata',
                'icon' => 'fa-eye',
                'description' => 'Layanan konsultasi untuk masalah kesehatan mata'
            ],
            [
                'name' => 'Konsultasi Gigi',
                'icon' => 'fa-tooth',
                'description' => 'Layanan konsultasi untuk masalah kesehatan gigi'
            ],
            [
                'name' => 'Konsultasi Saraf',
                'icon' => 'fa-brain',
                'description' => 'Layanan konsultasi untuk masalah saraf dan neurologi'
            ],
            [
                'name' => 'Konsultasi THT',
                'icon' => 'fa-ear-deaf',
                'description' => 'Layanan konsultasi Telinga Hidung Tenggorokan'
            ],
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'description' => $category['description'],
                'icon' => $category['icon'],
                'is_active' => true,
            ]);
        }
    }
}