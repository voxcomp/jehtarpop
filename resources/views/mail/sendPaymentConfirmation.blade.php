@extends('layouts.mail')

@section('content')
	<h4>Registration ID: {{$registration->id}}</h4>
	<h4>Date: {{$registration->created_at}}</h4>
	<h4>Payment Type: {{$registration->paytype}}</h4>
	<h4>Total: {{$registration->total}}</h4>
	<h4>Paid: {{$registration->paid}}</h4>
@stop