<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableStoreModules extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_modules', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('store_id', false, true)->index(); // todo: relations
			$table->integer('module_id', false, true)->index(); // todo: relations
            $table->timestamps();
			$table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('store_modules');
    }
}
