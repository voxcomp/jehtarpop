@extends('layouts.mail')

@section('content')
	<h4>Date: {{date('m/d/Y g:i A T')}}</h4>
	<h4>Amount: ${{$donation->amount}}</h4>
	<h4>Payment Type: {{$donation->paytype}}</h4>
	<h4>Last 4 of Account: {{$donation->cardno}}</h4>

	<p style="line-height:1em;">
		{{$donation->fname}} {{$donation->lname}}<br>
		@if(!empty($donation->company))
			{{$donation->company}}<br>
		@endif
		@if(!empty($donation->title))
			Title: {{$donation->title}}<br>
		@endif
		{{$donation->address}}<br>
		{{$donation->city}} {{$donation->state}}, {{$donation->zip}}<br>
		{{$donation->email}}<br>
		@if(!empty($donation->phone))
			{{$donation->phone}}<br>
		@endif
	</p>
	@if($sponsoritem)
	<p>
		<strong>Sponsorship Item:</strong> {{$sponsoritem->parent}} - {{$sponsoritem->name}}
	</p>
	@endif
	@if(!empty($donation->logo))
		<p>Logo has been attached and can also be viewed at: <a href="{{env('APP_URL')}}{{$donation->logo}}">{{env('APP_URL')}}{{$donation->logo}}</a></p>
	@endif
@stop