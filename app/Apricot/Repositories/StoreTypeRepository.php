<?php namespace App\Apricot\Repositories;

use App\StoreType;

class StoreTypeRepository
{

	/**
	 * @return mixed
	 */
	public function getAll()
	{
		return StoreType::select('id', 'name')
						->where('is_active', 1)
						->get();
	}

	/**
	 * @param string $name
	 *
	 * @return StoreType
	 */
	public function getByName($name = '')
	{
		return StoreType::where('name', $name)
						->where('is_active', 1)
						->first();
	}
	
}