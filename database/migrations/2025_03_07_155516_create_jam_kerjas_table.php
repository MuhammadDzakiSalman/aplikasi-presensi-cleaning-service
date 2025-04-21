<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jam_kerjas', function (Blueprint $table) {
            $table->id();
            $table->time('jam_masuk');
            $table->time('jam_keluar');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jam_kerjas');
    }
};
