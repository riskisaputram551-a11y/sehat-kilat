// database/migrations/xxx_create_medical_records_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medical_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('consultation_id')->constrained()->onDelete('cascade');
            $table->text('diagnosis'); // diagnosis
            $table->text('prescription'); // resep obat
            $table->text('notes')->nullable(); // catatan tambahan
            $table->string('blood_pressure')->nullable(); // tekanan darah
            $table->decimal('weight', 5, 2)->nullable(); // berat badan
            $table->decimal('height', 5, 2)->nullable(); // tinggi badan
            $table->decimal('temperature', 4, 2)->nullable(); // suhu tubuh
            $table->string('next_control')->nullable(); // kontrol berikutnya
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medical_records');
    }
};