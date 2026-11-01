<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('targy')) {
            Schema::create('targy', function (Blueprint $table) {
                $table->integer('id')->nullable();
                $table->string('nev', 25)->nullable();
                $table->string('kategoria', 11)->nullable();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('targy');
    }
};