<?php
return [
	'methods' => [
		'shopify' => App\Apricot\Integrations\ShopifyIntegration::class,
		//todo 'magento' => App\Apricot\Integrations\MagentoIntegration::class,
		//todo 'opencart' => App\Apricot\Integrations\OpencartIntegration::class,
		//todo 'woocommerce' => App\Apricot\Integrations\WoocommerceIntegration::class,
		//todo 'prestashop' => App\Apricot\Integrations\PrestashopIntegration::class,
		//todo 'dandomain' => App\Apricot\Integrations\DandomainIntegration::class,
		//todo 'wannafind' => App\Apricot\Integrations\WannafindIntegration::class,
	],
	'options' => [
		'shopify' => [
			'api_key'      => env('SHOPIFY_API_KEY', ''),
			'api_secret'   => env('SHOPIFY_API_SECRET', ''),
			'redirect_url' => env('REDIRECT_URI', '') . 'shopify/'
		]
	]
];