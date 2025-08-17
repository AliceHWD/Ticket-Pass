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
        Schema::create('ingressos', function (Blueprint $table) {
            $table->id('id_ingresso');
            $table->string('titulo');
            $table->string('local_evento');
            $table->decimal('valor_inicial', 10, 2);
            $table->date('data_evento');
            $table->decimal('valor_negociado', 10, 2)->nullable();
            $table->string('tipo_evento');
            $table->string('descricao');
            $table->enum('status', ['vendido', 'à venda']);
            $table->string('imagem');
            $table->timestamps();
            $table->foreignId('id_vendedor')->constrained('vendedores', 'id_vendedor')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ingressos');
    }
};
