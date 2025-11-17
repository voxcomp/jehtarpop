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
			<div class="col-sm">
				{!! Form::open(array('route' => ['support.create'], 'id'=>'support_form', 'autocomplete'=>'off')) !!}
					<input autocomplete="false" name="hidden" type="text" style="display:none;">
					@if(!isset($registration) && !isset($register) && !\Auth::check())
						<div class="row">
							<div class="col-sm-4 mb-2{{ $errors->has('name') ? ' has-error' : '' }}">
								{!! Form::label('contactname', 'Name', ['class'=>'form-label']) !!}
								{!! Form::text('contactname', old('contactname'), ['id'=>'contactname', 'class'=>'form-control', 'required']) !!}
								@if ($errors->has('contactname'))
									<span class="help-block">
										<strong>{{ $errors->first('contactname') }}</strong>
									</span>
								@endif
							</div>
							<div class="col-sm-4 mb-2{{ $errors->has('contactemail') ? ' has-error' : '' }}">
								{!! Form::label('contactemail', 'Email', ['class'=>'form-label']) !!}
								{!! Form::text('contactemail', old('contactemail'), ['id'=>'contactemail', 'class'=>'form-control', 'required']) !!}
								@if ($errors->has('contactemail'))
									<span class="help-block">
										<strong>{{ $errors->first('contactemail') }}</strong>
									</span>
								@endif
							</div>
							<div class="col-sm-4 mb-2{{ $errors->has('contactphone') ? ' has-error' : '' }}">
								{!! Form::label('contactphone', 'Phone', ['class'=>'form-label']) !!}
								{!! Form::text('contactphone', old('contactphone'), ['id'=>'contactphone', 'class'=>'form-control']) !!}
								@if ($errors->has('contactphone'))
									<span class="help-block">
										<strong>{{ $errors->first('contactphone') }}</strong>
									</span>
								@endif
							</div>
						</div>
						@if(isset($path))
							{!! Form::hidden('path',\Crypt::encrypt($path)) !!}
						@endif
					@elseif(!\Auth::check() && isset($registration))
						{!! Form::hidden('registration',\Crypt::encrypt($registration->id)) !!}
					@elseif(!\Auth::check() && isset($register) && isset($path))
						{!! Form::hidden('path',\Crypt::encrypt($path)) !!}
					@endif
					<div class="mb-2{{ $errors->has('title') ? ' has-error' : '' }}">
						{!! Form::label('title', 'Please give your issue a title:', ['class'=>'form-label']) !!}
						{!! Form::text('title', old('title'), ['id'=>'title', 'class'=>'form-control','required','autocomplete'=>'nope']) !!}
						@if ($errors->has('title'))
							<span class="help-block">
								<strong>{{ $errors->first('title') }}</strong>
							</span>
						@endif
					</div>
					<div class="mb-2{{ $errors->has('description') ? ' has-error' : '' }}">
						{!! Form::label('description', 'Please describe the issue that was encountered in as much detail as possible:', ['class'=>'form-label']) !!}
						{!! Form::textarea('description', old('description'), ['id'=>'description', 'class'=>'form-control','required','autocomplete'=>'nope']) !!}
						<div class="help-block">
							Please describe the steps to reproduce the problem, what information you are using, and if you are trying to register as a company or an individual and what class you are choosing.
						</div>
						@if ($errors->has('description'))
							<span class="help-block">
								<strong>{{ $errors->first('description') }}</strong>
							</span>
						@endif
					</div>
					@if(\Auth::check())
					<div class="mb-2">
						{!! Form::label('email', 'Email Addresses', ['class'=>'form-label']) !!}
						{!! Form::text('email', old('email'), ['id'=>'email','class'=>'form-control']) !!}
						<div class="help-block">
							Notified on status change and new notes.  Comma separate multiple addresses.
						</div>
					</div>
					@endif
					<div class="text-right">
						{!! Form::submit('Submit',['class'=>'btn btn-primary']) !!}
					</div>
				{!! Form::close() !!}
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