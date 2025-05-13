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
        Schema::create('credit_card_releases', function (Blueprint $table) {
            $table->id();

            $table->date('data_compra');
            $table->decimal('valor', 10);
            $table->smallInteger('quantidade_parcelas');
            $table->string('descricao');
            $table->decimal('valor_parcela', 10);
            $table->decimal('valor_pago_fatura', 10)->nullable();
            $table->date('data_pagamento_fatura')->nullable();

            $table->unsignedBigInteger('period_id');
            $table->unsignedBigInteger('credit_card_id');
            $table->unsignedBigInteger('user_id');

            $table->foreign('period_id')->references('id')->on('periods');
            $table->foreign('credit_card_id')->references('id')->on('credit_cards');
            $table->foreign('user_id')->references('id')->on('users');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('credit_card_releases');
    }
};
