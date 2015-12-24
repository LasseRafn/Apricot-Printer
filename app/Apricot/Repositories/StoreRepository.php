<?php namespace App\Apricot\Repositories;

use App\Store;
use Illuminate\Http\Request;

class StoreRepository
{

	private $storeTypeRepo;

	function __construct(StoreTypeRepository $repo)
	{
		$this->storeTypeRepo = $repo;
	}

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
	 * @return Store|Validator
	 */
	public function create($domain, $type)
	{
		$domain     = $this->fixDomain($domain);
		$identifier = $this->convertDomainToIdentifier($domain);

		$type = $this->storeTypeRepo->getByName($type);

		return Store::create([
			'identifier' => $identifier,
			'domain'     => $domain,
			'type_id'    => $type->getId(),
			'account_id' => \Auth::user()->getAccountId(),
			'auth_state' => Store::STATE_PENDING
		]);
	}

	private function convertDomainToIdentifier($domain)
	{
		$identifier = preg_replace('/\./', '', $domain);
		$identifier = preg_replace('/\.myshopify\.com/i', '', $identifier);
		$identifier = substr($identifier, 0, 14);
		$identifier .= '-' . str_random(5);
		$identifier = strtolower($identifier);
		$identifier = ucfirst($identifier);

		return $identifier;
	}

	public function validate($domain, $type)
	{
		$domain     = $this->fixDomain($domain);
		$identifier = $this->convertDomainToIdentifier($domain);

		return \Validator::make([
			'identifier' => $identifier,
			'domain'     => $domain,
			'type'       => $type
		], [
			'identifier' => 'required|unique:stores,identifier',
			'domain'     => 'required|regex:/^(?:[-A-Za-z0-9]+\.)+[A-Za-z]{2,6}$/i',
			'type'       => 'required|exists:store_types,name'
		]);
	}

	private function fixDomain($domain)
	{
		$domain = trim(strtolower($domain));
		$domain = preg_replace('/([^a-å0-9_\.\:\/])/i', '', $domain);
		preg_match('/^(?:https?\:\/\/)?(?:[^@\n]+@)?(?:www\.)?([^:\/\n]+)/i', $domain, $matches);
		$domain = $matches[ count($matches) - 1 ];

		return $domain;
	}

}