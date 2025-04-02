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
        Schema::create('car_releases', function (Blueprint $table) {
            $table->id();

            $table->date('data_despesa');
            $table->decimal('valor', 10);
            $table->string('descricao');

            $table->unsignedBigInteger('period_release_id');
            $table->unsignedBigInteger('car_id');
            $table->unsignedBigInteger('user_id');

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('period_release_id')->references('id')->on('period_releases');
            $table->foreign('car_id')->references('id')->on('cars');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('car_releases');
    }
};
