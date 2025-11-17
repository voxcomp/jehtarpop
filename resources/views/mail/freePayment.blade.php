@extends('layouts.mail')

@section('content')
	<h4>Payment ID: {{$payment->transaction_id}}</h4>
	<h4>Reference or Invoice: {{$payment->reference}}</h4>
	<h4>Date: {{date('m/d/Y g:i A T')}}</h4>
	<h4>Amount: ${{number_format($payment->amount,2)}}</h4>

	<p style="line-height:1em;">
		{{$payment->firstname}} {{$payment->lastname}}<br>
		{{$payment->address}}<br>
		{{$payment->city}} {{$payment->state}}, {{$payment->zip}}<br>
		E-mail: {{$payment->email}}
	</p>
@stop