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
        Schema::create('_alumnos', function (Blueprint $table) {
            $table->string('nc')->primary();
            $table->string('ap');
            $table->string('am');
            $table->string('nombres');
            $table->timestamps(); // Esto añade las columnas created_at y updated_at

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('_alumnos');
    }
};
