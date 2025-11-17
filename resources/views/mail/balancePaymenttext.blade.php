@extends('layouts.mail')

@section('content')
	Payment ID: {{$payment->transaction_id}}
	Date: {{date('m/d/Y g:i A T')}}
	Amount: ${{$payment->amount}}

	Individual ID: {{$student->indid}}
	{{$payment->firstname}} {{$payment->lastname}}
	{{$payment->address}}
	{{$payment->city}} {{$payment->state}}, {{$payment->zip}}
	{{$student->email}}
	{{$student->mobile}}
@stop