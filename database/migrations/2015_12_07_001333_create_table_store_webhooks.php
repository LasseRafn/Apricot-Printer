<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableStoreWebhooks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_webhooks', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('store_id', false, true); // todo: relations
			$table->string('name', 20)->default('order');
			$table->timestamp('last_request_at');
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
        Schema::drop('store_webhooks');
    }
}
