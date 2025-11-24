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
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            // Tipo de promoción ("percent", "fixed", "2x1", "free_shipping", etc.)
            $table->string('type', 50)->nullable();
            // Valor del descuento (30 = 30%, 5000 = $5000)
            $table->decimal('value', 12, 2)->nullable();
            $table->timestamp('start_at')->nullable();
            $table->timestamp('end_at')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::table('promotions', function (Blueprint $table) {
            $table->index(['is_active', 'start_at', 'end_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotions');
    }
};
