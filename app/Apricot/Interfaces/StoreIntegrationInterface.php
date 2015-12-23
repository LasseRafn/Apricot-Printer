<?php namespace App\Apricot\Interfaces;

interface StoreIntegrationInterface
{
	/**
	 * @return array
	 */
	function getOrders();

	/**
	 * @return array
	 */
	function getCustomers();
	/**
	 * @return array
	 */
	function getProducts();

	/**
	 * @return array
	 */
	function getWebhooks();

	/**
	 * @return boolean
	 */
	function postWebhook();
}