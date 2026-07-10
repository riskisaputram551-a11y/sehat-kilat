// database/migrations/xxx_create_consultations_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('consultations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('doctor_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('code')->unique(); // kode konsultasi unik
            $table->enum('status', ['pending', 'approved', 'in_progress', 'completed', 'cancelled'])->default('pending');
            $table->date('consultation_date');
            $table->time('consultation_time');
            $table->text('complaint'); // keluhan pasien
            $table->text('doctor_note')->nullable(); // catatan dokter
            $table->string('attachment')->nullable(); // lampiran
            $table->enum('type', ['online', 'offline'])->default('online');
            $table->decimal('fee', 10, 2)->default(0); // biaya konsultasi
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consultations');
    }
};