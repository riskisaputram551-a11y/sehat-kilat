// database/migrations/2025_01_01_000001_add_fields_to_users_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone', 15)->nullable();
            $table->text('address')->nullable();
            $table->date('birth_date')->nullable();
            $table->enum('gender', ['L', 'P'])->nullable();
            $table->enum('role', ['admin', 'dokter', 'pasien'])->default('pasien');
            $table->string('specialist')->nullable(); // spesialis dokter
            $table->string('license_number')->nullable(); // nomor STR dokter
            $table->text('bio')->nullable(); // biografi dokter
            $table->string('photo')->nullable(); // foto profile
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone', 'address', 'birth_date', 'gender', 'role', 'specialist', 'license_number', 'bio', 'photo']);
        });
    }
};