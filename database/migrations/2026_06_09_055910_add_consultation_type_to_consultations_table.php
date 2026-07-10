<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('consultations', function (Blueprint $table) {
            $table->enum('consultation_type', ['ai', 'doctor'])->default('doctor')->after('type');
            $table->text('ai_response')->nullable()->after('complaint');
        });
    }

    public function down(): void
    {
        Schema::table('consultations', function (Blueprint $table) {
            $table->dropColumn(['consultation_type', 'ai_response']);
        });
    }
};