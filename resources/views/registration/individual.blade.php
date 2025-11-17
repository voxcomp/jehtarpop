@extends('layouts.app')

@section('title')
{{ucfirst($path)}} Registration: Individual
@endsection

@section('helpdesk')
	@include('parts.helpdesk',['section'=>'individual','path'=>$path])
@endsection

@section('content')
	@if($errors->count())
	    <div class="alert alert-danger">
	        There was an error submitting your information
	    </div>
	@endif
	{!! Form::open(array('route' => ['registration.individual.save',$path], 'id'=>'indpayment_form')) !!}
	{!! Form::hidden('indid','',['id'=>'indid']) !!}
	<div class="row  justify-content-center">
		<div class="col-sm">
			@if($path=='event')
				@include('registration.parts.registrant',['showradiobuttons'=>true, "showfinder"=>true])
				@include('registration.parts.event-choice')
			@elseif($path=='training')
				@include('registration.parts.registrant',['showradiobuttons'=>true, "showfinder"=>true])
				@include('registration.parts.training-choice')
			@elseif($path=='trade')
				@include('registration.parts.registrant',["showradiobuttons"=>true, "showfinder"=>true])
				@include('registration.parts.trade-choice')
			@elseif($path=='online')
				@include('registration.parts.registrant',["showradiobuttons"=>false, "showfinder"=>true])
				@include('registration.parts.online-choice')
			@elseif($path=='correspondence')
				@include('registration.parts.registrant',["showradiobuttons"=>true, "showfinder"=>true])
				@include('registration.parts.correspondence-choice')
			@endif
			
			<p>&nbsp;</p>
		    <div class="row">
		        <div class="col-sm text-center">
						<input type="submit" class="btn btn-primary" value="Continue To Payment">
		        </div>
		    </div>
		</div>
	</div>
	{!! Form::close() !!}
@endsection
