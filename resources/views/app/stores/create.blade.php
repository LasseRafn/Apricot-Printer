@extends('app.layout')

@section('content')
	@if($errors->count() > 0)
		@foreach ($errors->all() as $message)
			{{ $message }}
		@endforeach
	@endif
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
		<small>Example: <strong>store.myshopify.com</strong> or mystore.com.</small>
		{!! csrf_field() !!}
	</form>
@stop