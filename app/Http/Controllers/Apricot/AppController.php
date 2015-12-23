<?php namespace App\Http\Controllers\Apricot;

use App\Http\Controllers\Controller;

class AppController extends Controller
{

	function __construct()
	{
		$this->middleware('auth');
	}

	public function getIndex()
	{

	}
	
}