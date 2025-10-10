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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id('ticket_id');
            $table->string('title');
            $table->string('location');
            $table->decimal('initial_price', 10, 2);
            $table->date('event_date');
            $table->decimal('negotiated_price', 10, 2)->nullable();
            $table->enum('event_type', ['inteira', 'meia']);
            $table->enum('category', ['Festa', 'Show', 'Esportes', 'Palestra', 'Lazer', 'Cultura', 'Outro']);
            $table->string('description')->nullable();
            $table->string('cep');
            $table->integer('quantity');
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
        Schema::dropIfExists('tickets');
    }
};
