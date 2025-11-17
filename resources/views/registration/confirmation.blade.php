@extends('layouts.app')

@section('title')
{{ucfirst($path)}} Registration: Confirmation
@endsection

@section('content')
	<div class="row justify-content-center">
		<div class="col-sm-8">
			<div class="card">
				<div class="card-header text-center">
					<h4>Registration Information</h4>
				</div>
				<div class="card-body">
					{!!getSetting($path.'confirmation','editor')!!}
				
					<hr>
					<h3>Registration Details</h3>
					<hr>
					<h4>Registration ID: {{$registration->id}}</h4>
					<h4>Registration Date: {{date('m/d/Y g:i A T')}}</h4>
@if($registration->name!='Self Students')
					@if($registration->name!="Self Students")
						<h4>Company:</h4>
						<p><strong>{{$registration->name}}</strong><br>{{$registration->address}}<br>{{$registration->city}}, {{$registration->state}} {{$registration->zip}}</p>
						<p>Phone: {{$registration->phone}}</p>
						@if(!empty($registration->contactfname))
							<p>Contact: {{$registration->contactfname}} {{$registration->contactlname}} ({{$registration->cemail}}, {{$registration->cphone}})</p>
						@endif
					@endif
					<p>&nbsp;</p>
					<h4>Registrants:</h4>
@endif
					@foreach($registration->registrants as $registrant)
						<div style="line-height:1em;">{{$registrant->firstname}} {{$registrant->lastname}}</div>
					@if($registration->name=='Self Students')
						<p style="line-height:1em;">{{$registrant->address}}<br>
						{{$registrant->city}} {{$registrant->state}}, {{$registrant->zip}}<br>
						Mobile: {{$registrant->mobile}}</p>
					@endif
						<p style="line-height:1em;">
						@if($path=='event' || $path=='training')
							<small>{{$registrant->event}}  ({{$registrant->ticket}})<br>
						@elseif($path=='trade' || $path=='online' || $path=='correspondence')
							<small>{{$registrant->course}}<br>
						@endif
						Cost: ${{$registrant->fee}}</small></p>
					@endforeach
					<p>&nbsp;</p>
					<h5>Subtotal: <strong>${{number_format($registration->total+$registration->discount,2)}}</strong></h5>
					<h5>Discount: <strong>${{number_format($registration->discount,2)}}</strong></h5>
					<h5>Total: <strong>${{number_format($registration->total,2)}}</strong></h5>
					@if($registration->paytype!='credit')
						<h5>Payment Type: <strong>{{$registration->paytype}}</strong></h5>
						<h5>Amount Due: <strong>${{number_format($registration->due,2)}}</strong></h5>
					@else
						<h5>Paid: <strong>${{number_format($registration->paid,2)}}</strong></h5>
					@endif
					@if($registration->balance!=$registration->total && $registration->balance>0)
					<h5>Balance: <strong>${{number_format($registration->balance,2)}}</strong></h5>
					@endif
					<h5>Responsible Party: <strong>{{$registration->responsible}}</strong></h5>
				</div>
			</div>
			<p>&nbsp;</p>
			@if($registration->paytype == 'check')
				<p>Please print this confirmation and mail a check for <strong>${{number_format($registration->due,2)}}</strong> to:<br><br>
					<strong>Gould Construction Institute<br>
					100 Unicorn Park Drive, Suite 2<br>
					Woburn, MA 01801</strong></p>
				<p>&nbsp;</p>
			@elseif($registration->paytype == 'invoice')
				<p>You will receive an invoice for <strong>${{number_format($registration->due,2)}}</strong></p>
			@endif
			<p>&nbsp;</p>
			<p class="text-center"><a href="http://www.gwgci.org" class="btn btn-primary">Back To Website</a></p>
		</div>
	</div>
@endsection
