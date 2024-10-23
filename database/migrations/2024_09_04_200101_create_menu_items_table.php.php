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
        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();
            $table->string('label');
            $table->text('url')->nullable();
            $table->text('description')->nullable(); 
            $table->integer('order');
            $table->unsignedBigInteger('parent_id')->nullable();//para submenus
            $table->foreignId('menu_id')->constrained('menus')->onDelete('cascade');
            $table->foreignId('page_id')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_items');
    }
};
