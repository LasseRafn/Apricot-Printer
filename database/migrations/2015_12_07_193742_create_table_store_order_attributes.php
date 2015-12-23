<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableStoreOrderAttributes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_order_attributes', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('store_id', false, true)->index(); // todo: relation
			$table->string('identifier', 30)->index();
			$table->text('value');
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
        Schema::drop('store_order_attributes');
    }
}
