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
        Schema::create('column_component', function (Blueprint $table) {
            $table->foreignId('column_id')
                ->constrained('columns') // Especifica la tabla relacionada
                ->onUpdate('cascade')
                ->onDelete('cascade');
                
            $table->foreignId('component_id')
                ->constrained('components') // Especifica la tabla relacionada
                ->onUpdate('cascade')
                ->onDelete('cascade');
                
            $table->primary(['column_id', 'component_id']);
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('column_component');
    }
};
