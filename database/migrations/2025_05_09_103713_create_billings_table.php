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
        Schema::create('billings', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['material', 'worker']);
            $table->unsignedBigInteger('reference_id'); // worker_id or material_id
            $table->decimal('sqft', 10, 2)->nullable();
            $table->integer('qty')->nullable();
            $table->decimal('rate', 10, 2)->nullable();
            $table->decimal('total', 12, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('billings');
    }
};
