<?php namespace App\Apricot\Libraries;

use App\Apricot\Interfaces\StoreAuthIntegrationInterface;

class IntegrationMethods
{
	/**
	 * @param string $method
	 *
	 * @return StoreIntegrationInterface
	 */
	public function getMethodClass($method = 'shopify')
	{
		$method  = strtolower($method);
		$methods = config('integrations.methods', [ ]);

		if ( !isset($methods[ $method ]) )
		{
			return false;
		}

		return new $methods[ $method ];
	}

	public function getAuthToken(StoreAuthIntegrationInterface $integration)
	{
		$integration->getAuthorizeResponse();

		return $integration->postAuthToken();
	}
}