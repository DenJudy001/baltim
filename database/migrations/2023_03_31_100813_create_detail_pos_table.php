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
        Schema::create('detail_pos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pos_id')->constrained('pos')->onDelete('cascade');
            $table->foreignId('fnb_id')->nullable();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('type');
            $table->string('image')->nullable();
            $table->integer('qty');
            $table->integer('price');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_pos');
    }
};
