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
        Schema::create('penyuluhan_hukums', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');;
            $table->string('no_hp');
            $table->string('nik_ktp');
            $table->text('bentuk_permasalahan');
            $table->string('input_pdf_ktp');
            $table->string('input_pdf_permasalahan');
            $table->enum('status',['diproses','disetujui','ditolak']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penyuluhan_hukums');
    }
};
