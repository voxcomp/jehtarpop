@extends('layouts.app')

@section('title')
Make A Donation
@endsection

@section('content')
	<div class="row justify-content-center">
		<div class="col-lg-12">
			<p>These are exciting times at Gould Construction Institute, ABC MA’s training affiliate! We have opened a brand new facility in Billerica, MA with all new training options and programs to serve the construction industry. In conjunction with this, we have launched a fundraising campaign to help defray building costs.  Please send a donation in using the form below in support of GCI. Thank you for supporting Gould Construction Institute!</p>
			{!! Form::open(array('route' => ['donations.submitDonation'],'class'=>'billingform')) !!}
			<div class="card mb-3">
				<div class="card-header">Billing Information</div>
	
				<div class="card-body">
					<div class="row">
						<div class="col-sm">
							<div class="form-group{{ $errors->has('firstname') ? ' has-error' : '' }}">
								<input id="firstname" type="text" class="form-control" name="firstname" value="{{ old('firstname') }}" required placeholder="First Name">
								@if ($errors->has('firstname'))
									<span class="help-block">
										<strong>{{ $errors->first('firstname') }}</strong>
									</span>
								@endif
							</div>
						</div>
						<div class="col-sm">
							<div class="form-group{{ $errors->has('lastname') ? ' has-error' : '' }}">
								<input id="lastname" type="text" class="form-control" name="lastname" value="{{ old('lastname') }}" required placeholder="Last Name">
								@if ($errors->has('lastname'))
									<span class="help-block">
										<strong>{{ $errors->first('lastname') }}</strong>
									</span>
								@endif
							</div>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-sm-8 {{ $errors->has('company') ? ' has-error' : '' }}">
							<input id="company" type="text" class="form-control" name="company" value="{{ old('company') }}" placeholder="Company">
							@if ($errors->has('company'))
								<span class="help-block">
									<strong>{{ $errors->first('company') }}</strong>
								</span>
							@endif
						</div>
						<div class="col-sm-4 {{ $errors->has('title') ? ' has-error' : '' }}">
							<input id="title" type="text" class="form-control" name="title" value="{{ old('title') }}" placeholder="Title">
							@if ($errors->has('title'))
								<span class="help-block">
									<strong>{{ $errors->first('title') }}</strong>
								</span>
							@endif
						</div>
					</div>
					<div class="row form-group">
						<div class="col-sm-6 {{ $errors->has('email') ? ' has-error' : '' }}">
							<input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required placeholder="Email Address">
							@if ($errors->has('email'))
								<span class="help-block">
									<strong>{{ $errors->first('email') }}</strong>
								</span>
							@endif
						</div>
						<div class="col-sm-6 {{ $errors->has('phone') ? ' has-error' : '' }}">
							<input id="phone" type="phone" class="form-control phone" name="phone" value="{{ old('phone') }}" placeholder="Phone">
							@if ($errors->has('phone'))
								<span class="help-block">
									<strong>{{ $errors->first('phone') }}</strong>
								</span>
							@endif
						</div>
					</div>
					<p><strong>Please note:</strong> The address entered must match the address on file for your credit card.</p>
					<div class="row form-group{{ $errors->has('address') ? ' has-error' : '' }}">
						<div class="col">
							<input id="address" type="text" class="form-control" name="address" value="{{ old('address') }}" required placeholder="Address">
							@if ($errors->has('address'))
								<span class="help-block">
									<strong>{{ $errors->first('address') }}</strong>
								</span>
							@endif
						</div>
					</div>
					<div class="row form-group">
						<div class="col-sm-5 col-xs-12 col-spacing{{ $errors->has('city') ? ' has-error' : '' }}">
							<input id="city" type="text" class="form-control" name="city" value="{{ old('city') }}" required placeholder="City">
							@if ($errors->has('city'))
								<span class="help-block">
									<strong>{{ $errors->first('city') }}</strong>
								</span>
							@endif
						</div>
						<div class="col-sm-3 col-xs-4 col-spacing{{ $errors->has('state') ? ' has-error' : '' }}">
							<input id="state" type="text" class="form-control" name="state" value="{{ old('state') }}" required placeholder="ST">
							@if ($errors->has('state'))
								<span class="help-block">
									<strong>{{ $errors->first('state') }}</strong>
								</span>
							@endif
						</div>
						<div class="col-sm-4 col-xs-8{{ $errors->has('zip') ? ' has-error' : '' }}">
							<input id="zip" type="text" class="form-control" name="zip" value="{{ old('zip') }}" required placeholder="Zip Code">
							@if ($errors->has('zip'))
								<span class="help-block">
									<strong>{{ $errors->first('zip') }}</strong>
								</span>
							@endif
						</div>
					</div>
				</div>
			</div>

			<div class="card">
				<div class="card-header">Donation</div>
	
				<div class="card-body">
					<div class="row">
						<div class="col-sm">
							<div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
								<label for="amount">Amount to Pay</label>
								{!! Form::text('amount',null,['class'=>'form-control money','placeholder'=>'AMOUNT TO PAY']) !!}
								@if ($errors->has('amount'))
									<span class="help-block">
										<strong>{{ $errors->first('amount') }}</strong>
									</span>
								@endif
							</div>
						</div>
					</div>
				</div>
			</div>
			<p>&nbsp;</p>
			@if(\Auth::check() && \Auth::user()->usertype=="admin")
				<div class="row form-group">
					<div class="col-sm">
						{!! Form::checkbox('inkind',101) !!} <strong>Offline donation</strong> (no payment screen)
					</div>
				</div>
			@endif
			<div class="row form-group">
				<div class="col-sm text-center">
					<input type="submit" class="btn btn-primary" value="Continue">
				</div>
			</div>
			{!! Form::close() !!}
		</div>
	</div>
@endsection

@section('rightsidebar')
	@include('donations.progress-part')
@endsection
