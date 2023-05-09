<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateExpenseCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expense_categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('name');
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });

        DB::table('expense_categories')->insert([
            ['name' => 'Food', 'user_id' => null],
            ['name' => 'Daily Necessities', 'user_id' => null],
            ['name' => 'Transportation', 'user_id' => null],
            ['name' => 'Clothing', 'user_id' => null],
            ['name' => 'Medical Expenses', 'user_id' => null],
            ['name' => 'Entertainment Expense', 'user_id' => null],
            ['name' => 'Other', 'user_id' => null],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('expense_categories');
    }
}
