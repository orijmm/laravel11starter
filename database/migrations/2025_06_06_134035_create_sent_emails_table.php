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
        Schema::create('sent_emails', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);         // Nombre del remitente
            $table->string('email');        // Email del remitente
            $table->string('subject', 100)->nullable(); // Asunto del mensaje
            $table->text('message');        // Cuerpo del mensaje
            $table->string('type', 50)->nullable(); // Si hay selección de destino
            $table->string('ip_address')->nullable(); // IP del remitente
            $table->boolean('was_sent')->default(true); // Por si falla el envío
            $table->timestamps();           // created_at = cuándo fue enviado
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sent_emails');
    }
};
