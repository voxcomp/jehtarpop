@extends('layouts.mail')

@section('content')
	@if(isset($messagestr) && !empty($messagestr))
	<p>{{$messagestr}}</p>
	
	@endif

	{!!getSetting($path.'confirmation','editor')!!}

	<hr>
	<h3>Registration Details</h3>
	<hr>

	<h4>Registration ID: {{$registration->id}}</h4>
	<h4>Registration Date: {{date('m/d/Y g:i A T',strtotime($registration->created_at))}}</h4>
	@if($registration->name!='Self Students' && !$individual)
		<h4>Company:</h4>
		<p><strong>{{$registration->name}}</strong><br>{{$registration->address}}<br>{{$registration->city}}, {{$registration->state}} {{$registration->zip}}</p>
		<p>Company Phone: {{$registration->phone}}</p>
		@if(!empty($registration->contactfname))
			<p>Contact: {{$registration->contactfname}} {{$registration->contactlname}} ({{$registration->cemail}}  {{$registration->cphone}})</p>
		@endif
		<p>&nbsp;</p>
		<h4>Registrants:</h4>
	@else
		@if($registration->name!='Self Students')
		<p><strong>Company:</strong> {{$registration->name}}</p>
		@endif
	@endif
	@if(!$individual)
		@foreach($registration->registrants as $registrant)
			<p style="line-height:1em;">{{$registrant->firstname}} {{$registrant->lastname}}<br>
				<small>{{$registrant->address}}<br>
				{{$registrant->city}} {{$registrant->state}}, {{$registrant->zip}}<br><br>
				@if($registrant->dob>0)
				Date of Birth: {{date('m/d/Y',$registrant->dob)}}<br><br>
				@endif
				Mobile: {{$registrant->mobile}}<br>
				Mobile Carrier: {{$registrant->mobilecarrier}}<br>
				E-mail: {{$registrant->email}}</small></p>
			<p><small>DAS Registered Apprentice: {{($registrant->das)?'yes':'no'}}</small><p>
			<p><small>Building Mass Careers Apprentice Program: {{($registrant->map)?'yes':'no'}}</small><p>
			@if($path=='trade' || $path=='online' || $path=='correspondence')
				<p><small>{{$registrant->course}}<br>Cost: ${{$registrant->fee}}</small></p>
			@elseif($path=='event' || $path=='training')
				<p><small>{{$registrant->event}} ({{$registrant->ticket}})<br>Cost: ${{$registrant->fee}}</small></p>
			@endif
		@endforeach
	@else
		<p style="line-height:1em;">{{$registrant->firstname}} {{$registrant->lastname}}<br>
			<small>{{$registrant->address}}<br>
			{{$registrant->city}} {{$registrant->state}}, {{$registrant->zip}}<br><br>
			@if($registrant->dob>0)
			Date of Birth: {{date('m/d/Y',$registrant->dob)}}<br><br>
			@endif
			Mobile: {{$registrant->mobile}}<br>
			Mobile Carrier: {{$registrant->mobilecarrier}}<br>
			E-mail: {{$registrant->email}}</small></p>
		<p><small>DAS Registered Apprentice: {{($registrant->das)?'yes':'no'}}</small><p>
		<p><small>Building Mass Careers Apprentice Program: {{($registrant->map)?'yes':'no'}}</small><p>
		@if($path=='trade' || $path=='online' || $path=='correspondence')
			<p><small>{{$registrant->course}}<br>Cost: ${{$registrant->fee}}</small></p>
		@elseif($path=='event' || $path=='training')
			<p><small>{{$registrant->event}} ({{$registrant->ticket}})<br>Cost: ${{$registrant->fee}}</small></p>
		@endif
	@endif
	<p>&nbsp;</p>
	<p>Payment method: {{$registration->paytype}}</p>
	<p>{{(!is_null($registration->ponum) && !empty($registration->ponum))?"PO Number: ".$registration->ponum:''}}</p>
	<h5>Subtotal: <strong>${{number_format($registration->total+$registration->discount,2)}}</strong></h5>
	<h5>Discount: <strong>${{number_format($registration->discount,2)}}</strong></h5>
	<h5>Total: <strong>${{number_format($registration->total,2)}}</strong></h5>
	<h5>Amount Due: <strong>${{number_format($registration->due,2)}}</strong></h5>
	@if($registration->paid>0)
	<h5>Amount Paid: <strong>${{number_format($registration->paid,2)}}</strong></h5>
	@endif
	@if($registration->balance!=$registration->total && $registration->balance>0)
	<h5>Balance: <strong>${{number_format($registration->balance,2)}}</strong></h5>
	@endif
	@if($registration->name!='Self Students' && !$individual)
		<h5>Responsible Party: <strong>{{$registration->responsible}}</strong></h5>
	@endif
@stop