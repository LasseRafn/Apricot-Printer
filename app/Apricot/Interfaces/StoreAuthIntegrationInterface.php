<?php namespace App\Apricot\Interfaces;

interface StoreAuthIntegrationInterface
{
	/**
	 * @return string
	 */
	function prepareAuth();

	/**
	 * @param string $domain
	 *
	 * @return string
	 */
	function generateAuthUrl($domain = '');

	/**
	 * @return boolean
	 */
	function getAuthorizeResponse();

	/**
	 * @return string
	 */
	function postAuthToken();

	/**
	 * @return string
	 */
	function getShop();
}