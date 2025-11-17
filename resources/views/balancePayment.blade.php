@extends('layouts.app')

@section('title')
Balance Payment
@endsection

@section('content')
	<p class="text-center">The balance must be paid in full before registering for another class or event.</p>
	<div class="row justify-content-center">
		<div class="col-sm-8">
			<p class="text-center"><big><i class="far fa-credit-card text-primary"></i></big> <strong>Pay with Credit Card or eCheck (ACH)</strong></p>
			{!! Form::open(array('route' => ['balancePayment',$student->id],'class'=>'paymentform')) !!}
			<div class="card">
				<div class="card-header">Billing Information</div>
	
	            <div class="card-body">
			        <div class="row">
						<div class="col-sm">
							<div class="form-group{{ $errors->has('firstname') ? ' has-error' : '' }}">
					            <input id="firstname" type="text" class="form-control" name="firstname" value="{{ old('firstname',$student->first) }}" required placeholder="First Name">
					            @if ($errors->has('firstname'))
					                <span class="help-block">
					                    <strong>{{ $errors->first('firstname') }}</strong>
					                </span>
					            @endif
							</div>
						</div>
						<div class="col-sm">
							<div class="form-group{{ $errors->has('lastname') ? ' has-error' : '' }}">
					            <input id="lastname" type="text" class="form-control" name="lastname" value="{{ old('lastname',$student->last) }}" required placeholder="Last Name">
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
				            <input id="address" type="text" class="form-control" name="address" value="{{ old('address',$student->address) }}" required placeholder="Address">
				            @if ($errors->has('address'))
				                <span class="help-block">
				                    <strong>{{ $errors->first('address') }}</strong>
				                </span>
				            @endif
				        </div>
					</div>
					<div class="row form-group">
						<div class="col-sm-5 col-xs-12 col-spacing{{ $errors->has('city') ? ' has-error' : '' }}">
				            <input id="city" type="text" class="form-control" name="city" value="{{ old('city',$student->city) }}" required placeholder="City">
				            @if ($errors->has('city'))
				                <span class="help-block">
				                    <strong>{{ $errors->first('city') }}</strong>
				                </span>
				            @endif
						</div>
						<div class="col-sm-3 col-xs-4 col-spacing{{ $errors->has('state') ? ' has-error' : '' }}">
				            <input id="state" type="text" class="form-control" name="state" value="{{ old('state',$student->state) }}" required placeholder="ST">
				            @if ($errors->has('state'))
				                <span class="help-block">
				                    <strong>{{ $errors->first('state') }}</strong>
				                </span>
				            @endif
						</div>
						<div class="col-sm-4 col-xs-8{{ $errors->has('zip') ? ' has-error' : '' }}">
				            <input id="zip" type="text" class="form-control" name="zip" value="{{ old('zip',$student->zip) }}" required placeholder="Zip Code">
				            @if ($errors->has('zip'))
				                <span class="help-block">
				                    <strong>{{ $errors->first('zip') }}</strong>
				                </span>
				            @endif
						</div>
					</div>
					<div class="row form-group">
						<div class="col-sm col-xs-12 col-spacing{{ $errors->has('phone') ? ' has-error' : '' }}">
				            <input id="phone" type="text" class="form-control" name="phone" value="{{ old('phone',$student->mobile) }}" required placeholder="Phone">
				            @if ($errors->has('phone'))
				                <span class="help-block">
				                    <strong>{{ $errors->first('phone') }}</strong>
				                </span>
				            @endif
						</div>
						<div class="col-sm col-xs-8{{ $errors->has('email') ? ' has-error' : '' }}">
				            <input id="email" type="email" class="form-control" name="email" value="{{ old('email',$student->email) }}" required placeholder="Email">
				            @if ($errors->has('email'))
				                <span class="help-block">
				                    <strong>{{ $errors->first('email') }}</strong>
				                </span>
				            @endif
						</div>
					</div>
	            </div>
			</div>
{{--
			<div class="card">
				<div class="card-header">Card Information</div>
	
	            <div class="card-body">
			        <div class="row">
						<div class="col-sm">
							<div class="form-group{{ $errors->has('card') ? ' has-error' : '' }}">
								{!! Form::hidden('amount',$student->balance) !!}
								{!! Form::text('card_number',null,['class'=>'form-control','placeholder'=>'CARD NUMBER']) !!}
					            @if ($errors->has('card_number'))
					                <span class="help-block">
					                    <strong>{{ $errors->first('card_number') }}</strong>
					                </span>
					            @endif
							</div>
						</div>
			        </div>
			        <div class="row">
						<div class="col form-group{{ $errors->has('expiremm') ? ' has-error' : '' }}">
							<label for="expiremm">Expire Month</label>
							{!! Form::select('expiration_month',[1=>"January", 2=>"February", 3=>"March", 4=>"April", 5=>"May", 6=>"June", 7=>"July", 8=>"August", 9=>"September", 10=>"October", 11=>"November", 12=>"December"],1,['class'=>'form-control']) !!}
				            @if ($errors->has('expiration_month'))
				                <span class="help-block">
				                    <strong>{{ $errors->first('expiration_month') }}</strong>
				                </span>
				            @endif
						</div>
						<div class="col form-group{{ $errors->has('expireyy') ? ' has-error' : '' }}">
							<label for="expiremm">Expire Year</label>
							{!! Form::select('expiration_year',["2023"=>"2023","2024"=>"2024","2025"=>"2025","2026"=>"2026","2027"=>"2027","2028"=>"2028","2029"=>"2029","2030"=>"2030","2031"=>"2031","2032"=>"2032","2033"=>"2033","2034"=>"2034"],date('Y'),['class'=>'form-control']) !!}
				            @if ($errors->has('expiration_year'))
				                <span class="help-block">
				                    <strong>{{ $errors->first('expiration_year') }}</strong>
				                </span>
				            @endif
						</div>
						<div class="col form-group{{ $errors->has('cvv') ? ' has-error' : '' }}">
							<label for="cvv">CVV (on back)</label>
							{!! Form::text('cvc',null,['class'=>'form-control','placeholder'=>'CVV']) !!}
				            @if ($errors->has('cvc'))
				                <span class="help-block">
				                    <strong>{{ $errors->first('cvc') }}</strong>
				                </span>
				            @endif
						</div>
			        </div>
	            </div>
			</div>
--}}			
			<p>&nbsp;</p>
		    <div class="row form-group">
		        <div class="col-sm text-center">
			        <h4 class="text-center">Payment Total: <strong>${{$student->balance}}</strong></h4>
		            <input type="submit" class="btn btn-primary" value="Continue to Payment">
		        </div>
		    </div>
			{!! Form::close() !!}
		</div>
	</div>
@endsection
