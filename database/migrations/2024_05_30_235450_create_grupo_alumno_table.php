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
        Schema::create('grupo_alumno', function (Blueprint $table) {
            $table->id();
            $table->string('nc_alumno');
            $table->uuid('id_grupo');
            $table->boolean('status');
            $table->foreign('nc_alumno')->references('nc')->on('_alumnos');
            $table->foreign('id_grupo')->references('uuid')->on('grupo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grupo_alumno');
    }
};
