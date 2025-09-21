<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('nisn', 20)->unique();
            $table->string('name', 100);
            $table->string('class', 50);
            $table->string('gender', 20); // 🔹 lebih fleksibel, bisa isi "Laki-laki" / "Perempuan"
            $table->string('parent_contact', 50)->nullable();
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('teacher_id')->nullable();
            $table->timestamps();

            // 🔹 Relasi ke tabel teachers
            $table->foreign('teacher_id')
                ->references('id')
                ->on('teachers')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
