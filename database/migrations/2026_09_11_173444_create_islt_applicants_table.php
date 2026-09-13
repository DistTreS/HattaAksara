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
        Schema::create('islt_applicants', function (Blueprint $table) {
            $table->id();
            $table->string('registration_code', 50)->unique();
            $table->string('full_name', 255);
            $table->string('nisn', 30)->nullable();
            $table->string('birth_place', 100);
            $table->date('birth_date');
            $table->enum('gender', ['L', 'P']);
            $table->string('whatsapp_number', 50);
            $table->string('email', 255);
            $table->string('province', 100);
            $table->string('city', 100);
            $table->string('school_name', 255);
            $table->string('osis_position', 100);
            $table->text('organization_experience');
            $table->text('motivation_essay');
            $table->string('photo_path')->nullable();
            $table->string('recommendation_letter_path')->nullable();
            $table->string('selection_status', 50)->default('submitted'); // submitted, screening, interview, passed, rejected
            $table->timestamp('synced_to_sheets_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('islt_applicants');
    }
};
