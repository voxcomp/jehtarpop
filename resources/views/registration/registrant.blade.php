@extends('layouts.app')

@section('title')
{{ucfirst($path)}} Registration: Add Registrant
@endsection

@section('helpdesk')
	@include('parts.helpdesk',['section'=>'registrant','path'=>$path])
@endsection

@section('content')
	@if($errors->count())
	    <div class="alert alert-danger">
	        There was an error submitting your information
	    </div>
	@endif
	
	@if(isset($students) && !empty($students))
		{{ html()->form('POST', route('registration.registrant.save', $path))->id('existing_registrant_form')->open() }}
		<div class="row  justify-content-center">
			<div class="col-sm">
				<div class="card">
					<div class="card-header">Existing Employee</div>
		
		            <div class="card-body">
			            <p>Select an existing employee from the list</p>
			            {{ html()->select('employee', ["" => "Select..."] + $students, old('employee'))->class('form-control')->id('employee')->attribute('onchange', 'getStudentInformation(this.value)') }}
			            <div class="student-error alert alert-danger nohide" style="margin-top:15px;display:none;"></div>
		            </div>
		        </div>
			</div>
		</div>
		<p>&nbsp;</p>
		{{ html()->form()->close() }}
	@endif
	
	{{ html()->form('POST', route('registration.registrant.save', $path))->id('registrant_form')->open() }}
	{{ html()->hidden('indid', '')->id('indid') }}
	<div class="row  justify-content-center">
		<div class="col-sm">
			@if(!$first)
			<div class="message">If you have entered all participating students, <strong><a href="{{route('registration.payment',[$path])}}">Continue To Payment</a></strong></div>
			<p>&nbsp;</p>
			@endif
			@if($path=='event')
				@include('registration.parts.registrant',['showradiobuttons'=>true, "showfinder"=>true])
				@include('registration.parts.event-choice')
			@elseif($path=='training')
				@include('registration.parts.registrant',['showradiobuttons'=>true, "showfinder"=>true])
				@include('registration.parts.training-choice')
			@elseif($path=='trade')
				@include('registration.parts.registrant',['showradiobuttons'=>true, "showfinder"=>true])
				@include('registration.parts.trade-choice')
			@elseif($path=='online')
				@include('registration.parts.registrant',['showradiobuttons'=>false, "showfinder"=>true])
				@include('registration.parts.online-choice')
			@elseif($path=='correspondence')
				@include('registration.parts.registrant',['showradiobuttons'=>true, "showfinder"=>true])
				@include('registration.parts.correspondence-choice')
			@endif
			
			<p>&nbsp;</p>
		    <div class="row">
		        <div class="col-sm">
		            <input type="submit" class="btn btn-primary" value="Save & Continue to Payment">
		            &nbsp;&nbsp;&nbsp;<a href="#" id="addanother" class="btn btn-danger">Add Another Registrant</a>
		        </div>
		    </div>
		</div>
	</div>
	{{ html()->form()->close() }}
@endsection

@section('rightsidebar')
	<div class="card">
		<div class="card-header text-center">
			<h4>Details</h4>
		</div>
		<div class="card-body">
			<h4><a href="{{route('registration.company',[$path])}}"><i class="fas fa-edit"></i></a> Company:</h4>
			<p><strong>{{$registration['name']}}</strong><br>{{$registration['address']}}<br>{{$registration['city']}}, {{$registration['state']}} {{$registration['zip']}}</p>
			<p>{{$registration['phone']}}</p>
			<p>&nbsp;</p>
		@if(!$first)
			<h4>Registrants:</h4>
			<?php $cost = 0; ?>
			@foreach($registration['registrants'] as $key=>$registrant)
			<p style="line-height:1em;"><a href="{{route('registration.registrant.remove',[$path,$key])}}" title="Remove Registrant"><i class="fas fa-user-slash"></i></a> {{$registrant['firstname']}} {{$registrant['lastname']}}<br><small>{{$registrant['class']}}<br>Cost: ${{$registrant['cost']}}</small></p>
			<?php $cost += $registrant['cost']; ?>
			@endforeach
			<p>&nbsp;</p>
			<h5>Total Cost: <strong>${{number_format($cost,2)}}</strong></h5>
	        <div class="text-center">
	            <a href="{{route('registration.payment',[$path])}}" class="btn btn-danger">Continue To Payment</a>
	        </div>
		    <p>&nbsp;</p>
		@endif
	        <div class="text-center">
	            <a href="{{route('registration.cancel',[$path])}}" class="btn btn-warning">Cancel Registration</a>
	        </div>
		</div>
	</div>
@endsection

@section('footer')
<script>
	@if($path=='event' || $path=='training')
		@if(!empty(old('event-name',(isset($registrant['event-name']))?$registrant['event-name']:'')))
			$(".event-name").val({{old('event-name',(isset($registrant['event-name']))?$registrant['event-name']:'')}}).trigger('change');
		@endif
		@if(!empty($eventid))
			$(".event-name").val({{$eventid}}).trigger('change');
		@endif
	@endif
	$(document).ready(function() {
		$("#addanother").on("click",function(e) {
			e.preventDefault();
			$("#registrant_form").append('<input type="hidden" name="step" value="add" />');
 			document.getElementById('registrant_form').submit();
		});
	});
</script>
@endsection
