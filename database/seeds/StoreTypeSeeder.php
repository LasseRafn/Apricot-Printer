<?php

use Illuminate\Database\Seeder;

class StoreTypeSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		\App\StoreType::create([ 'name' => 'shopify', 'is_active' => 1 ]);
		\App\StoreType::create([ 'name' => 'magento', 'is_active' => 0 ]); // todo: toggle when active
		\App\StoreType::create([ 'name' => 'opencart', 'is_active' => 0 ]); // todo: toggle when active
		\App\StoreType::create([ 'name' => 'woocommerce', 'is_active' => 0 ]); // todo: toggle when active
		\App\StoreType::create([ 'name' => 'prestashop', 'is_active' => 0 ]); // todo: toggle when active
		\App\StoreType::create([ 'name' => 'dandomain', 'is_active' => 0 ]); // todo: toggle when active
		\App\StoreType::create([ 'name' => 'wannafind', 'is_active' => 0 ]); // todo: toggle when active
	}
}
