<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('jegy')) {
            Schema::create('jegy', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('diakid')->nullable();
                $table->string('datum', 10)->nullable();
                $table->integer('ertek')->nullable();
                $table->string('tipus', 17)->nullable();
                $table->integer('targyid')->nullable();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('jegy');
    }
};