<?php namespace App\Http\Controllers\Apricot;

use App\Apricot\Repositories\StoreRepository;
use App\Apricot\Repositories\StoreTypeRespository;
use App\Jobs\GetStoreAuthToken;
use App\Store;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class StoreController extends Controller
{

	private $storeRepo;
	private $typeRepo;

	function __construct(StoreRepository $storeRepository, StoreTypeRespository $storeTypeRespository)
	{
		$this->storeRepo = $storeRepository;
		$this->typeRepo  = $storeTypeRespository;
		$this->middleware('auth');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		dd($this->storeRepo->getAllByAccount());
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		return view('app.stores.create', [
			'storeTypes' => $this->typeRepo->getAll()
		]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$storeType = $request->get('store-type');
		$storeUrl  = strtolower($request->get('store-url'));

		$storeId = $this->storeRepo->create($storeUrl, $storeType)->getId();

		return redirect("/authorize/start/$storeType/$storeUrl/$storeId");
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function show($identifierOrId)
	{
		$store = $this->storeRepo->findByIdOrIdentifier($identifierOrId);

		if ( !$store )
		{
			return redirect('/app/stores')->withErrors([ 'errors.stores.none-found' ]);
		}

		dd($store);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  int                      $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		$store = $this->storeRepo->findById($id);

		if ( !$store )
		{
			return redirect('/app/stores')->withErrors([ 'errors.stores.none-found' ]);
		}

		$store->delete();

		return redirect('/app/stores');
	}
}
