@extends('layouts.app')

@section('title')
{{ucfirst($path)}} Registration: Billing
@endsection

@section('helpdesk')
	@include('parts.helpdesk',['section'=>'billing','section'=>$path,'id'=>$registration->id])
@endsection

@section('content')
	<div class="row justify-content-center">
		<div class="col-sm">
			{!! Form::open(array('route' => ['registration.billing.save',[$path,$registration->id]],'class'=>'paymentform', 'id'=>'ccpaymentform')) !!}
			<div class="card">
				<div class="card-header">Billing Information</div>
	
	            <div class="card-body">
					<p><strong>Please note:</strong> The address entered must match the address on file for your credit card.</p>
			        <div class="row">
						<div class="col-sm">
							<div class="form-group{{ $errors->has('firstname') ? ' has-error' : '' }}">
					            <input id="firstname" type="text" class="form-control" name="firstname" value="{{ old('firstname',$payment->firstname) }}" required placeholder="First Name">
					            @if ($errors->has('firstname'))
					                <span class="help-block">
					                    <strong>{{ $errors->first('firstname') }}</strong>
					                </span>
					            @endif
							</div>
						</div>
						<div class="col-sm">
							<div class="form-group{{ $errors->has('lastname') ? ' has-error' : '' }}">
					            <input id="lastname" type="text" class="form-control" name="lastname" value="{{ old('lastname',$payment->lastname) }}" required placeholder="Last Name">
					            @if ($errors->has('lastname'))
					                <span class="help-block">
					                    <strong>{{ $errors->first('lastname') }}</strong>
					                </span>
					            @endif
							</div>
						</div>
			        </div>
					<div class="row form-group{{ $errors->has('address') ? ' has-error' : '' }}">
				        <div class="col">
				            <input id="address" type="text" class="form-control" name="address" value="{{ old('address',$payment->address) }}" required placeholder="Address">
				            @if ($errors->has('address'))
				                <span class="help-block">
				                    <strong>{{ $errors->first('address') }}</strong>
				                </span>
				            @endif
				        </div>
					</div>
					<div class="row form-group">
						<div class="col-sm-5 col-xs-12 col-spacing{{ $errors->has('city') ? ' has-error' : '' }}">
				            <input id="city" type="text" class="form-control" name="city" value="{{ old('city',$payment->city) }}" required placeholder="City">
				            @if ($errors->has('city'))
				                <span class="help-block">
				                    <strong>{{ $errors->first('city') }}</strong>
				                </span>
				            @endif
						</div>
						<div class="col-sm-3 col-xs-4 col-spacing{{ $errors->has('state') ? ' has-error' : '' }}">
				            <input id="state" type="text" class="form-control" name="state" value="{{ old('state',$payment->state) }}" required placeholder="ST">
				            @if ($errors->has('state'))
				                <span class="help-block">
				                    <strong>{{ $errors->first('state') }}</strong>
				                </span>
				            @endif
						</div>
						<div class="col-sm-4 col-xs-8{{ $errors->has('zip') ? ' has-error' : '' }}">
				            <input id="zip" type="text" class="form-control" name="zip" value="{{ old('zip',$payment->zip) }}" required placeholder="Zip Code">
				            @if ($errors->has('zip'))
				                <span class="help-block">
				                    <strong>{{ $errors->first('zip') }}</strong>
				                </span>
				            @endif
						</div>
					</div>
	            </div>
			</div>
			<p>&nbsp;</p>
		    <div class="row form-group">
		        <div class="col-sm text-center">
		            <input type="submit" class="btn btn-primary" value="Continue To Payment">
		        </div>
		    </div>
			{!! Form::close() !!}
		</div>
	</div>
@endsection

@section('rightsidebar')
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
			<h4>Billing:</h4>
			<p>
				@if(isset($payment->fname))
					<strong>{{$payment->fname}} {{$payment->lname}}</strong><br>
				@else
					<strong>{{$payment->firstname}} {{$payment->lastname}}</strong><br>
				@endif
				{{$payment->address}}<br>{{$payment->city}}, {{$payment->state}} {{$payment->zip}}</p>
			<p>&nbsp;</p>
			@if($registration->name!='Self Students')
			<h4>Registrants:</h4>
			@endif
			@foreach($registration->registrants as $registrant)
			<p style="line-height:1em;">{{$registrant->firstname}} {{$registrant->lastname}}<br>
			@if($path=='event' || $path=='training')
				<small>{{$registrant->event}}  ({{$registrant->ticket}})<br>
			@elseif($path=='trade' || $path=='online' || $path=='correspondence')
				<small>{{$registrant->course}}<br>
			@endif
			Cost: ${{$registrant->fee}}</small></p>
			@endforeach
			<p>&nbsp;</p>
			<h5 class="text-dark">SubTotal: <strong>$<span class="subtotal">{{number_format($registration->total,2)}}</span></strong></h5>
			<h5 class="text-dark">Discount: <strong>$<span class="discount">{{number_format($registration->discount,2)}}</span></strong></h5>
			<h4 class="text-danger">Total Due: <strong>$<span class="total">{{number_format($registration->due,2)}}</span></strong></h4>
			<p>&nbsp;</p>
			<div class="text-center">
				<a href="{{route('registration.cancel.id',[$path,$registration->id])}}" class="btn btn-warning">Cancel Registration</a>
			</div>
		</div>
	</div>
@endsection

@section('footer')
@endsection

