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
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->integer('number');
            $table->foreignId('series_id')->nullable();
            $table->foreignId('supplier_id')->nullable();
            $table->string('supplier_name');
            $table->text('description')->nullable();
            $table->text('address');
            $table->string('supplier_responsible');
            $table->string('telp');
            $table->string('purchase_number');
            $table->string('purchase_name');
            $table->string('responsible');
            $table->string('state');
            $table->integer('total');
            $table->timestamp('end_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
