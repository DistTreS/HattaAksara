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
        Schema::create('alumni_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('islt_batch', 100); // e.g., 'Angkatan I (2024)'
            $table->string('province', 100);
            $table->string('city', 100);
            $table->string('school_origin', 255);
            $table->string('current_institution', 255)->nullable();
            $table->string('phone_number', 50)->nullable();
            $table->boolean('is_phone_public')->default(false);
            $table->text('bio')->nullable();
            $table->string('avatar_path')->nullable();
            $table->string('proof_document_path')->nullable(); // Bukti alumni (sertifikat)
            $table->string('linkedin_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alumni_profiles');
    }
};
