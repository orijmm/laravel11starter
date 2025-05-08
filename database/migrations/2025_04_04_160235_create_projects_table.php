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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('img_alt', 100)->nullable();
            $table->string('category', 100)->nullable();
            $table->string('title', 100);
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('client_name', 100)->nullable();
            $table->date('date')->nullable();
            $table->text('url')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
