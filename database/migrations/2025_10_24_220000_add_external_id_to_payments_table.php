<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->string('external_id')->nullable()->after('amount');
            $table->enum('payment_method', ['credit_card', 'debit_card', 'pix', 'boleto'])->change();
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn('external_id');
            $table->enum('payment_method', ['credit_card', 'debit_card', 'pix'])->change();
        });
    }
};