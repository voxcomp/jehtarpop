@extends('layouts.mail')

@section('content')
	<h4>Registration ID: {{$registration->id}}</h4>
	<h4>Date: {{$registration->created_at}}</h4>

	@foreach($response as $key=>$item)
		@if(is_array($item))
			<p><strong>{{$key}}</strong></p>
			<div style="padding-left:25px;">
			@foreach($item as $subkey=>$subitem)
				@if(!is_array($subitem))
					<p><strong>{{$subkey}}</strong>: {{$subitem}}</p>
				@endif
			@endforeach
			</div>
		@else
			<p><strong>{{$key}}</strong>: {{$item}}</p>
		@endif
	@endforeach
@stop