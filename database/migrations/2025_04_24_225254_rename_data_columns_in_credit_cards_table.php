<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('credit_cards', function (Blueprint $table) {
            $table->renameColumn('data_vencimento_fatura', 'dia_vencimento_fatura');
            $table->renameColumn('data_fechamento_fatura', 'dia_fechamento_fatura');
        });
    }

    public function down(): void
    {
        Schema::table('credit_cards', function (Blueprint $table) {
            $table->renameColumn('dia_vencimento_fatura', 'data_vencimento_fatura');
            $table->renameColumn('dia_fechamento_fatura', 'data_fechamento_fatura');
        });
    }
};
