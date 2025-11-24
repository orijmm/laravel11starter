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
        Schema::create('promotion_targets', function (Blueprint $table) {
            $table->id();

            $table->foreignId('promotion_id')
                ->constrained('promotions')
                ->onDelete('cascade');

            // product | variant | category | brand | etc.
            $table->string('target_type', 50);

            // ID real del target (product_id, category_id, etc.)
            $table->unsignedBigInteger('target_id');

            $table->timestamps();

            // Índices para búsquedas más rápidas
            $table->index(['target_type', 'target_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('promotion_targets');
    }
};
