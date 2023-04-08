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
            $table->foreignId('supplier_id')->nullable();
            $table->string('supplier_name')->nullable();
            $table->text('description')->nullable();
            $table->text('address')->nullable();
            $table->string('supplier_responsible')->nullable();
            $table->string('telp')->nullable();
            $table->string('purchase_number');
            $table->string('purchase_name');
            $table->string('responsible');
            $table->string('state');
            $table->integer('total');
            $table->timestamp('end_date')->nullable();
            $table->string('end_by')->nullable();
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
