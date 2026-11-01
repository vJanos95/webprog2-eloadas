<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('diak')) {
            Schema::create('diak', function (Blueprint $table) {
                $table->integer('id')->nullable();
                $table->string('nev', 20)->nullable();
                $table->string('osztaly', 4)->nullable();
                $table->integer('fiu')->nullable();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('diak');
    }
};