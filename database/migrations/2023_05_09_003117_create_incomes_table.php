<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncomesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incomes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->integer('peso');
            $table->integer('yen');
            $table->unsignedBigInteger('income_category_id');
            $table->text('memo')->nullable();
            $table->date('date');
            $table->unsignedBigInteger('currency_id');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('income_category_id')->references('id')->on('income_categories');
            $table->foreign('currency_id')->references('id')->on('currencies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('incomes');
    }
}
