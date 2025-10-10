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
        Schema::create('sellers', function (Blueprint $table) {
            $table->id('seller_id');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('rating')->nullable();
            $table->string('level')->nullable();
            $table->string('cep');
            $table->integer('house_number');
            $table->string('complement')->nullable();
            $table->timestamps();   
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sellers');
    }
};
