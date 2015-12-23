<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableStoreOrders extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('store_orders', function (Blueprint $table)
		{
			$table->increments('id');
			$table->integer('store_id', false, true)->index(); // todo: relations
			$table->integer('status_id', false, true)->index(); // todo: relations
			$table->string('external_identifier', 60)->index();
			$table->string('customer_identifier', 60)->index();
			$table->integer('external_increment_id', false, true)->index();
			$table->bigInteger('sub_total', false, true);
			$table->bigInteger('tax_total', false, true);
			$table->bigInteger('total', false, true);
			$table->string('customer_email', 120);
			$table->string('customer_shipping_first_name', 40);
			$table->string('customer_shipping_last_name', 40);
			$table->string('customer_shipping_company', 36);
			$table->string('customer_shipping_address1', 50);
			$table->string('customer_shipping_address2', 10);
			$table->string('customer_shipping_city', 18);
			$table->string('customer_shipping_zip', 8);
			$table->string('customer_shipping_province', 20);
			$table->string('customer_shipping_country', 12);
			$table->string('customer_shipping_phone', 10);
			$table->string('customer_shipping_country_code', 3);
			$table->string('customer_shipping_province_code', 3);
			$table->string('map_latitude', 20);
			$table->string('map_longitude', 20);
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
		Schema::drop('store_orders');
	}
}
