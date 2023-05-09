<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->integer('peso');
            $table->integer('yen');
            $table->unsignedBigInteger('expense_category_id');
            $table->text('memo')->nullable();
            $table->date('date');
            $table->unsignedBigInteger('currency_id');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('expense_category_id')->references('id')->on('expense_categories');
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
        Schema::dropIfExists('expenses');
    }
}
