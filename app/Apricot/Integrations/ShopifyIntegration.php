<?php namespace App\Apricot\Integrations;

use Log;
use App\Apricot\Interfaces\StoreIntegrationInterface;
use App\Apricot\Interfaces\StoreAuthIntegrationInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;

class ShopifyIntegration implements StoreIntegrationInterface, StoreAuthIntegrationInterface
{

	/**
	 * @var array
	 */
	private $scopes;

	/**
	 * @var string
	 */
	private $redirectUrl;

	/**
	 * @var string
	 */
	private $authTokenUrl;

	/**
	 * @var string
	 */
	private $apiKey;

	/**
	 * @var string
	 */
	private $apiSecret;

	/**
	 * @var string
	 */
	private $authCode;

	/**
	 * @var string
	 */
	private $shop;

	/**
	 * @var string
	 */
	private $identifier;

	function __construct()
	{
		$this->scopes = [
			'read_products',
			'read_customers',
			'read_orders',
			'write_orders'
		];

		$this->redirectUrl  = config('integrations.options.shopify.redirect_url');
		$this->authTokenUrl = 'https://{shop}.myshopify.com/admin/oauth/access_token';
		$this->apiKey       = config('integrations.options.shopify.api_key');
		$this->apiSecret    = config('integrations.options.shopify.api_secret');
	}

	/**
	 * @return string
	 */
	function prepareAuth()
	{
		$this->setIdentifier();

		return $this->identifier;
	}

	/**
	 * @param string $domain
	 *
	 * @return string
	 */
	function generateAuthUrl($domain = '')
	{
		$this->shop = $domain;

		return "https://{$this->shop}/admin/oauth/authorize?client_id={$this->apiKey}&scope=" . implode(',', $this->scopes) . "&redirect_uri={$this->redirectUrl}&state={$this->identifier}";
	}

	/**
	 * @return string
	 */
	function setIdentifier()
	{
		$identifier = str_random(32);

		\Session::put('integration_identifier', $identifier);
		$this->identifier = $identifier;

		return $this->identifier;
	}

	/**
	 * @return array
	 */
	function getOrders()
	{
		// TODO: Implement getOrders() method.
	}

	/**
	 * @return array
	 */
	function getCustomers()
	{
		// TODO: Implement getCustomers() method.
	}

	/**
	 * @return array
	 */
	function getProducts()
	{
		// TODO: Implement getProducts() method.
	}

	/**
	 * @return array
	 */
	function getWebhooks()
	{
		// TODO: Implement getWebhooks() method.
	}

	/**
	 * @return boolean
	 */
	function getAuthorizeResponse()
	{
		if ( !\Request::has('state') || \Request::get('state') != \Session::get('integration_identifier', '') )
		{
			return false;
		}

		$this->authCode = \Request::get('code');
		$this->shop     = preg_replace('/(\.myshopify\.com)$/', '', \Request::get('shop'));

		return \Request::only([ 'state', 'hmac', 'shop', 'code', 'signature', 'timestamp' ]);
	}


	/**
	 * @return boolean
	 */
	function postWebhook()
	{
		// TODO: Implement postWebhook() method.
	}

	/**
	 * @return string
	 */
	function postAuthToken()
	{
		try
		{
			$client   = new Client();
			$response = $client->request('POST', "https://{$this->shop}.myshopify.com/admin/oauth/access_token", [
				'form_params'   => [
					'client_id'     => $this->apiKey,
					'client_secret' => $this->apiSecret,
					'code'          => $this->authCode
				],
				'Accept'        => 'application/json',
				'Content-Type ' => 'application/json'
			]);
		} catch( BadResponseException $error )
		{
			Log::error("Integration with Shopify (using credentials: {$this->apiKey}, {$this->apiSecret}, {$this->authCode} - on shop: {$this->shop}) failed: " . $error->getResponse()->getReasonPhrase() . '. ' . $error->getMessage());

			// todo: do something..
			return false;
		}

		$response = json_decode($response->getBody());

		if ( !isset($response->access_token) )
		{
			// todo: do something..
			return false;
		}

		return $response->access_token;
	}

	/**
	 * @return string
	 */
	function getShop()
	{
		return $this->shop;
	}
}