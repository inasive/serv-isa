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
        Schema::create('siniestros', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique();
            $table->string('marca')->nullable();
            $table->string('modelo')->nullable();
            $table->string('serie')->nullable();
            $table->string('placas')->nullable();
            $table->boolean('terminado')->default(0);
            $table->string('notificacion');
            $table->boolean('pagado')->default(0);
            $table->foreignId('aseguradora_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siniestros');
    }
};
