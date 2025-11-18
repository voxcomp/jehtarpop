@extends('layouts.app',['front'=>true])

@section('title')
Program Registration
@endsection

@section('content')
	<div class="front-container">
		<div class="funnels">
			<div class="row">
				<div class="col-sm mb-3">
					<p><a href="{{route('registration.company','correspondence')}}" class="btn btn-warning d-block w-100">Correspondence Courses</a></p>
					@if(!getSetting('correspondenceregistration','status'))
					<div class="help-block mb-2">
						Registration currently closed.
					</div>
					@endif
					{!! getSetting('fp_correspondence','editor') !!}
				</div>
				<div class="col-sm mb-3">
					<p><a href="{{route('registration.company','online')}}" class="btn btn-warning d-block w-100">Online Courses</a></p>
					@if(!getSetting('onlineregistration','status'))
					<div class="help-block mb-2">
						Registration currently closed.
					</div>
					@endif
					{!! getSetting('fp_online','editor') !!}
				</div>
			</div>
			<div class="row">
				<div class="col-sm mb-3">
					<p><a href="{{route('registration.company','trade')}}" class="btn btn-warning d-block w-100">Trade Courses</a></p>
					@if(!getSetting('traderegistration','status'))
					<div class="help-block mb-2">
						Registration currently closed.
					</div>
					@endif
					{!! getSetting('fp_trade','editor') !!}
				</div>
				<div class="col-sm mb-3">
					<div class="mb-3">
						<p><a href="{{route('registration.company','training')}}" class="btn btn-warning d-block w-100">Training Courses</a></p>
						@if(!getSetting('trainingregistration','status'))
						<div class="help-block mb-2">
							Registration currently closed.
						</div>
						@endif
						{!! getSetting('fp_training','editor') !!}
					</div>
					@if($events)
					<div>
						<p><a href="{{route('registration.company','event')}}" class="btn btn-warning d-block w-100">Events</a></p>
						@if(!getSetting('eventregistration','status'))
						<div class="help-block mb-2">
							Registration currently closed.
						</div>
						@endif
						{!! getSetting('fp_event','editor') !!}
					</div>
					@endif
				</div>
			</div>
		</div>
		<div class="splash">
			<div class="content-container">
				<div class="content">
					<img src="{{ URL::to('/') }}/images/class-reg-splash-page.jpg">
				</div>
			</div>
		</div>
	</div>
@endsection
