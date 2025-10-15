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
        Schema::create('iurans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_iuran');
            $table->decimal('jumlah', 12,2);
            $table->enum('periode', ['mingguan','bulanan','tahunan'])->default('bulanan');
            $table->string('keterangan')->nullable();
            $table->integer('limit_bayar')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('iurans');
    }
};
