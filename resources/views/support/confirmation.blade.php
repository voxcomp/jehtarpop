@extends('layouts.app')

@section('title')
Create Support Ticket
@endsection

@section('helpdesk')
	<div class="my-5 col-sm-3 h-100 help-desk">
		<div class="p-4" style="background:#C5D5E4;">
			<div class="text-center">
				<img src="{{ URL::to('/') }}/images/support.png" class="img-fluid pb-2" style="max-width:120px;">
			</div>
			<h2>Create a Support Ticket</h2>
			<p>If you are experiencing an issue with the registration form or any part of the registration process, we are here to help. Please complete the form and provide as much detail as possible to assist our support team in troubleshooting.</p>
			<p>Common issues might include:</p>
			<ul class="text-left">
				<li>Trouble submitting the registration form</li>
				<li>Error messages or page not loading</li>
				<li>Payment errors</li>
				<li>Missing confirmation email</li>
			</ul>
			<p>Your information is secure and will only be used to resolve your issue.</p>
		</div>
	</div>
@endsection

@section('content')
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-sm text-center">
				<h3>Your support ticket has been submitted.</h3>
				<p>Please allow us some time to investigate.</p>
			</div>
		</div>
	</div>
@endsection

@if(isset($registration) || isset($register))
@section('rightsidebar')
	@if(isset($registration))
		<div class="card">
			<div class="card-header text-center">
				<h4>Details</h4>
			</div>
			<div class="card-body">
				@if($registration->name!='Self Students')
				<h4>Company:</h4>
				<p><strong>{{$registration->name}}</strong><br>{{$registration->address}}<br>{{$registration->city}}, {{$registration->state}} {{$registration->zip}}</p>
				<p>{{$registration->phone}}</p>
				<p>&nbsp;</p>
				<h4>Party Responsible for Payment:</h4>
				<p>{{$registration->responsible}}
				@endif
				@if(!empty($payment))
					<h4>Billing:</h4>
					<p>
						@if(isset($payment->fname))
							<strong>{{$payment->fname}} {{$payment->lname}}</strong><br>
						@else
							<strong>{{$payment->firstname}} {{$payment->lastname}}</strong><br>
						@endif
						{{$payment->address}}<br>{{$payment->city}}, {{$payment->state}} {{$payment->zip}}</p>
					<p>&nbsp;</p>
				@endif
				@if($registration->name!='Self Students')
				<h4>Registrants:</h4>
				@endif
				@foreach($registration->registrants as $registrant)
				<p style="line-height:1em;">{{$registrant->firstname}} {{$registrant->lastname}}<br>
				@if(empty($registrant->course))
					<small>{{$registrant->event}}  ({{$registrant->ticket}})<br>
				@else
					<small>{{$registrant->course}}<br>
				@endif
				Cost: ${{$registrant->fee}}</small></p>
				@endforeach
				<p>&nbsp;</p>
				<h5 class="text-dark">SubTotal: <strong>$<span class="subtotal">{{number_format($registration->total,2)}}</span></strong></h5>
				<h5 class="text-dark">Discount: <strong>$<span class="discount">{{number_format($registration->discount,2)}}</span></strong></h5>
				<h4 class="text-danger">Total Due: <strong>$<span class="total">{{number_format($registration->due,2)}}</span></strong></h4>
			</div>
		</div>
	@endif
	@if(isset($register))
		<div class="card">
			<div class="card-header text-center">
				<h4>Details</h4>
			</div>
			<div class="card-body">
				<h4>Company:</h4>
				<p><strong>{{$register['name']}}</strong><br>{{$register['address']}}<br>{{$register['city']}}, {{$register['state']}} {{$register['zip']}}</p>
				<p>{{$register['phone']}}</p>
				<p>&nbsp;</p>
				<h4>Registrants:</h4>
				<?php $cost = 0; ?>
				@foreach($register['registrants'] as $key=>$registrant)
				<p style="line-height:1em;">{{$registrant['firstname']}} {{$registrant['lastname']}}<br><small>{{$registrant['class']}}<br>Cost: ${{$registrant['cost']}}</small></p>
				<?php $cost += $registrant['cost']; ?>
				@endforeach
				<p>&nbsp;</p>
				<h5>Total Cost: <strong>${{number_format($cost,2)}}</strong></h5>
			</div>
		</div>
	@endif
@endsection
@endif