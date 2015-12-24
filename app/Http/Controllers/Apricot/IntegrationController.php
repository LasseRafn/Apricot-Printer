<?php namespace App\Http\Controllers\Apricot;

use App\Apricot\Libraries\IntegrationMethods;
use App\Http\Controllers\Controller;
use App\Jobs\GetStoreAuthToken;

class IntegrationController extends Controller
{
	/**
	 * @var \App\Jobs\IntegrationMethods
	 */
	private $integrationMethods;
	
	function __construct(IntegrationMethods $integrationMethods)
	{
		$this->integrationMethods = $integrationMethods;
		$this->middleware('auth');
	}

	function getStart($method = 'shopify', $shop = '', $id = 0)
	{
		$api = $this->integrationMethods->getMethodClass($method);
		$api->prepareAuth();

		\Session::put('integration_id', $id);

		return \Redirect::away($api->generateAuthUrl($shop));
	}

	function getFinalize($method = 'shopify', $url = '')
	{
		$id = \Session::get('integration_id', 0);
		$job = (new GetStoreAuthToken($method, $url, $id))->onQueue('store_auth');
		$this->dispatch($job);

		return \Redirect::action('Apricot\StoreController@show', [ 'id' => $id ]);
	}
}