<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChecklistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checklists', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('user_id')
                ->unsigned();

            $table->string('name', 100);
            $table->string('icon', 50)
                ->nullable();

            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });

        Schema::create('checklist_items', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('checklist_id')
                ->unsigned();

            $table->string('name');
            $table->integer('count')
                ->default(0)
                ->unsigned();
            $table->integer('target_count')
                ->default(0)
                ->unsigned();

            $table->timestamps();

            $table->foreign('checklist_id')
                ->references('id')
                ->on('checklists')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('checklist_items');
        Schema::dropIfExists('checklists');
    }
}
