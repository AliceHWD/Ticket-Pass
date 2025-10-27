<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropColumn('status');
        });
        
        Schema::table('tickets', function (Blueprint $table) {
            $table->enum('status', ['Vendido', 'Disponível', 'Reservado'])->after('code');
        });
    }

    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropColumn('status');
        });
        
        Schema::table('tickets', function (Blueprint $table) {
            $table->enum('status', ['Vendido', 'Disponível'])->after('code');
        });
    }
};