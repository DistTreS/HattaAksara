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
        Schema::create('e_journals', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->string('slug', 255)->unique();
            $table->string('author_or_curator', 255)->default('Yayasan Proklamator Bung Hatta');
            $table->integer('publication_year');
            $table->string('category', 100); // Kurikulum ISLT, Jurnal Koperasi, Modul Kebangsaan
            $table->text('description')->nullable();
            $table->string('cover_image')->nullable();
            $table->string('file_path');
            $table->unsignedInteger('file_size_kb')->default(0);
            $table->unsignedInteger('download_count')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('e_journals');
    }
};
