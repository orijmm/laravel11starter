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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('icon_color_class', 100)->nullable();
            $table->string('icon', 100)->nullable();
            $table->string('title', 100);
            $table->text('description')->nullable();
            $table->text('content')->nullable();
            $table->text('link')->nullable();
            $table->foreignId('page_id')->nullable();
            $table->string('link_color_class', 100)->nullable();
            $table->softDeletes();
            $table->timestamps();
            
            $table->foreignId('component_type_id')
            ->constrained('component_types')
            ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
