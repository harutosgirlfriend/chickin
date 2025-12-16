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
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique();
            $table->enum('tipe_diskon', ['persentase', 'nilai_tetap']);
            $table->decimal('nilai_diskon', 10, 2);
            $table->decimal('min_belanja', 10, 2)->default(0);
            $table->integer('maks_pemakaian')->default(1);
            $table->integer('jumlah_dipakai')->default(0);
            $table->dateTime('mulai_berlaku');
            $table->dateTime('kadaluarsa_pada')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
