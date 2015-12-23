@extends('app.layout')

@section('content')
	<form method="post" action="{{ action('Apricot\StoreController@store') }}">
		@if($storeTypes->count() > 1)
			<select name="store-type">
				@foreach($storeTypes as $storeType)
					<option value="{{ $storeType->getMethodString() }}">{{ $storeType->getName() }}</option>
				@endforeach
			</select>
		@else
			{{ $storeTypes->first()->getName() }}
			<input type="hidden" name="store-type" value="{{ $storeTypes->first()->getMethodString() }}" />
		@endif

		<input type="text" name="store-url" placeholder="Store URL" />
		<small>Example: store.myshopify.com</small>
		{!! csrf_field() !!}
	</form>
@stop