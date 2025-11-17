@extends('layouts.app')

@section('title')
Balance Payment Confirmation
@endsection

@section('content')
	@if(isset($payment))
		<p class="text-center">Please print this page for your records.</p>
		<div class="row justify-content-center">
			<div class="col-sm-8">
				<div class="card">
					<div class="card-header text-center">
						<h4>Payment Details</h4>
					</div>
					<div class="card-body">
						<h4>Payment ID: {{$payment->transaction_id}}</h4>
						<h4>Date: {{date('m/d/Y g:i A T')}}</h4>
						<h4>Amount: ${{$payment->amount}}</h4>
	
						<p style="line-height:1em;">{{$payment->firstname}} {{$payment->lastname}}<br>
							{{$payment->address}}<br>
							{{$payment->city}} {{$payment->state}}, {{$payment->zip}}</p>
					</div>
				</div>
				<p>&nbsp;</p>
				<p class="text-center"><a href="http://www.gwgci.org" class="btn btn-primary">Back To Website</a></p>
			</div>
		</div>
	@else
		@if(isset($nobalance))
			<p class="text-center">Your account does not have an outstanding balance.</p>
		@endif
	@endif
@endsection
