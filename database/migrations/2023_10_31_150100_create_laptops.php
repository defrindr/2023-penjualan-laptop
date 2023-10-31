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
        Schema::create('laptops', function (Blueprint $table) {
            $table->id();
            $table->string('manufacturer');
            $table->string('model_name');
            $table->string('category');
            $table->float('screen_size');
            $table->string('screen');
            $table->string('cpu');
            $table->integer('ram');
            $table->string('storage');
            $table->string('gpu');
            $table->string('operating_system');
            $table->string('operating_system_version')->default('');
            $table->string('weight');
            $table->unsignedBigInteger('price');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laptops');
    }
};
