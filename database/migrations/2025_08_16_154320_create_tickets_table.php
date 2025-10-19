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
            $table->string('code')->unique();
            $table->enum('status', ['Vendido', 'Disponível']);
            $table->string('descricao')->nullable();
            $table->decimal('initial_price', 10, 2);
            $table->decimal('negotiated_price', 10, 2)->nullable();
            $table->foreignId('event_id')->constrained('events', 'event_id')->onDelete('cascade');
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
