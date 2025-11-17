@extends('layouts.mail')

@section('content')
	<h4>Payment ID: {{$payment->transaction_id}}</h4>
	<h4>Date: {{date('m/d/Y g:i A T')}}</h4>
	<h4>Amount: ${{$payment->amount}}</h4>

	<p style="line-height:1em;">Individual ID: {{$student->indid}}<br>
		{{$payment->firstname}} {{$payment->lastname}}<br>
		{{$payment->address}}<br>
		{{$payment->city}} {{$payment->state}}, {{$payment->zip}}<br>
		{{$student->email}}<br>
		{{$student->mobile}}</p>
@stop