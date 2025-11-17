@extends('layouts.mail')

@section('content')
	Payment ID: {{$payment->transaction_id}}
	Reference or Invoice: {{$payment->reference}}
	Date: {{date('m/d/Y g:i A T')}}
	Amount: ${{$payment->amount}}

	{{$payment->firstname}} {{$payment->lastname}}
	{{$payment->address}}
	{{$payment->city}} {{$payment->state}}, {{$payment->zip}}
@stop