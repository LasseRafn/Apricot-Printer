<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCoupons extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('coupons', function (Blueprint $table)
		{
			$table->increments('id');
			$table->string('code', 16)->index();
			$table->string('description', 40)->index();
			$table->integer('max_uses')->default('-1');
			$table->timestamp('valid_from')->nullable();
			$table->timestamp('valid_to')->nullable();
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
		Schema::drop('coupons');
	}
}
