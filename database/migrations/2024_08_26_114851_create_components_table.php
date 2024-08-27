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
        Schema::create('components', function (Blueprint $table) {
            $table->id();
            $table->text('content');
            $table->string('name');
            $table->text('description')->nullable(); 
            $table->integer('order');
            $table->foreignId('column_id')->constrained('columns')->onDelete('cascade');
            $table->foreignId('component_type_id')->constrained('component_types')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('components');
    }
};
