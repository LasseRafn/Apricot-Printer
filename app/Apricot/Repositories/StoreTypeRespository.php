<?php namespace App\Apricot\Repositories;

use App\StoreType;

class StoreTypeRespository
{

	public function getAll()
	{
		return StoreType::select('id', 'name')->where('is_active', 1)->get();
	}
	
}