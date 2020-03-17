<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('food_groups', function (Blueprint $table) {
            $table->id();

            $table->string('name', 255)
                ->comment('Name of the food group.');
            $table->string('icon', 50);
        });

        Schema::create('foods', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('user_id')
                ->unsigned();
            $table->bigInteger('food_group_id')
                ->unsigned();

            $table->string('name', 255)
                ->comment('Name of the food/brand/item.');
            $table->integer('count')
                ->comment('Number of items in stock.')
                ->unsigned();
            $table->float('weight')
                ->comment('Weight in gram per item.');
            $table->date('expired_after')
                ->comment('Date after which the food should not be eaten anymore.');

            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users');
            $table->foreign('food_group_id')
                ->references('id')
                ->on('food_groups');
        });

        Schema::create('food_plans', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('food_group_id');
            $table->bigInteger('user_id');
            $table->bigInteger('optimal_stock')
                ->comment('How much gram does the user want to have in stock, from this food group, at any given time.')
                ->nullable()
                ->unsigned();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('food_plans');
        Schema::dropIfExists('foods');
        Schema::dropIfExists('food_groups');
    }
}
