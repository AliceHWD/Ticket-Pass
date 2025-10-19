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
        Schema::create('events', function (Blueprint $table) {
            $table->id('event_id');
            $table->string('title');
            $table->string('location')->nullable();
            $table->date('start_event_date');
            $table->time('start_event_time');
            $table->date('end_event_date');
            $table->time('end_event_time');
            $table->enum('category', ['Festa', 'Show', 'Esportes', 'Palestra', 'Lazer', 'Cultura', 'Outro']);
            $table->string('description')->nullable();
            $table->string('cep');
            $table->integer('location_number');
            $table->timestamps();
            $table->foreignId('seller_id')->constrained('sellers', 'seller_id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
