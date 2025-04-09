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
        Schema::create('period_releases', function (Blueprint $table) {
            $table->id();

            $table->decimal('valor_total', 10);
            $table->string('observacao')->nullable();
            $table->date('data_debito_credito');
            $table->enum('situacao', ['creditado', 'debitado', 'nao_debitado']);

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('period_id');
            $table->unsignedBigInteger('type_release_id');

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('period_id')->references('id')->on('periods');
            $table->foreign('type_release_id')->references('id')->on('type_releases');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('period_releases');
    }
};
