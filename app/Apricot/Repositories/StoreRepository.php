<?php namespace App\Apricot\Repositories;

use App\Store;

class StoreRepository
{
	/**
	 * @return \Illuminate\Database\Eloquent\Collection|static[]
	 */
	public function getAllByAccount()
	{
		return Store::where('account_id', \Auth::user()->getAccountId())
			->get();
	}

	/**
	 * @param int $id
	 *
	 * @return Store
	 */
	public function findById($id = 0)
	{
		return Store::where('id', $id)
			->where('account_id', \Auth::user()->getAccountId())
			->first();
	}

	/**
	 * @param string $identifier
	 *
	 * @return Store
	 */
	public function findByIdOrIdentifier($identifier = '')
	{
		$identifier = strtolower($identifier);

		return Store::where(function ($query) use ($identifier)
		{
			$query->where('id', $identifier)
				  ->orWhereRaw("LOWER(identifier) = '{$identifier}'");
		})->where('account_id', \Auth::user()->getAccountId())
			->first();
	}

	/**
	 * @param $domain
	 * @param $type
	 *
	 * @return Store
	 */
	public function create($domain, $type)
	{
		$domain = trim(strtolower($domain));
		$domain = preg_replace('/([^a-å0-9_\.])/i', '', $domain);

		preg_match('/^(?:https?\:\/\/)?(?:[^@\n]+@)?(?:www\.)?([^:\/\n]+)/i', $domain, $matches);
		$identifier = $matches[ count($matches) - 1 ];
		$identifier = preg_replace('/\./', '', $identifier);
		$identifier = preg_replace('/\.myshopify\.com/i', '', $identifier);
		$identifier = substr($identifier, 0, 14);
		$identifier .= '-' . str_random(5);
		$identifier = strtolower($identifier);
		$identifier = ucfirst($identifier);

		// todo: validate (unique identifier, domain and such) + add UNIQUE index in MySQL

		return Store::create([
			'identifier' => $identifier,
			'domain'     => $domain,
			'type_id'    => $type,
			'account_id' => \Auth::user()->getAccountId(),
			'auth_state' => Store::STATE_PENDING
		]);
	}

}