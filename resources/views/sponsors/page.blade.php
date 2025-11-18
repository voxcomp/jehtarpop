@extends('layouts.app')

@section('title')
Make A Sponsorship Donation
@endsection

@section('content')
	<div class="row justify-content-center">
		<div class="col-lg-12">
			<p>These are exciting times at Gould Construction Institute, ABC MA’s training affiliate! We have opened a brand new facility in Billerica, MA with all new training options and programs to serve the construction industry. In conjunction with this, we have launched a fundraising campaign to help defray building costs, and we are offering some great opportunities for you to be recognized for your support of GCI. Thank you for supporting Gould Construction Institute!</p>
			{!! Form::open(array('route' => ['sponsor.submitDonation'],'class'=>'billingform','files'=>'true')) !!}
			<div class="mb-3">
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

			<div class="">
				<div class="card-body">
					<h2 class="text-center text-danger"><strong>Please Pick Your Sponsorship Level</strong></h2>
					<p class="text-center"><a href="https://www.gwgci.org/sponsorship-levels/" target="_blank">CLICK HERE TO LEARN MORE ABOUT EACH LEVEL</a></p>

					<div class="mb-3">
						<h3 class="mb-1"><strong>Brick Wall Sponsorship:</strong></h3>
							<div class="ms-*">
								@foreach($items->where('parent','Brick Wall Sponsorship') as $item)
									<div>{!!Form::radio('sponsoritem',$item->id)!!} {{$item->name}}: ${{$item->price}} ({{$item->qty-$item->sold}} available)</div>
								@endforeach
							</div>
					</div>
					<div class="mb-3">
						<h3 class="mb-1"><strong>Front Lobby Sponsorship:</strong><br><small>Donor Wall of Honor – "Educating our Future Construction Workforce"</small></h3>
							<div class="ms-*">
								@foreach($items->where('parent','Front Lobby Sponsorship') as $item)
									<div>{!!Form::radio('sponsoritem',$item->id)!!} {{$item->name}}: ${{$item->price}} ({{$item->qty-$item->sold}} available)</div>
								@endforeach
							</div>
					</div>
					<div class="mb-3">
						<h3 class="mb-1"><strong>Classroom Sponsorship:</strong></h3>
							<div class="ms-*">
								@foreach($items->where('parent','Classroom Sponsorship') as $item)
									<div>{!!Form::radio('sponsoritem',$item->id)!!} {{$item->name}}: ${{$item->price}} ({{$item->qty-$item->sold}} available)</div>
								@endforeach
							</div>
					</div>
					<div class="mb-3">
						<h3 class="mb-1"><strong>A/V Equipment Sponsorship:</strong></h3>
							<div class="ms-*">
								@foreach($items->where('parent','A/V Equipment Sponsorship') as $item)
									<div>{!!Form::radio('sponsoritem',$item->id)!!} {{$item->name}}: ${{$item->price}} ({{$item->qty-$item->sold}} available)</div>
								@endforeach
							</div>
					</div>
					<div class="mb-3">
						<h3 class="mb-1"><strong>Trophy Case Sponsorship:</strong></h3>
							<div class="ms-*">
								@foreach($items->where('parent','Trophy Case Sponsorship') as $item)
									<div>{!!Form::radio('sponsoritem',$item->id)!!} {{$item->name}}: ${{$item->price}} ({{$item->qty-$item->sold}} available)</div>
								@endforeach
							</div>
					</div>
				</div>
			</div>
			<div style="background:#E9E8E8" class="p-3">
				<p>For Sponsorship recognition on our website, please upload your logo or the image you would like displayed on the GCI "Road to Billerica" Fundraising Campaign page. This is not required if you do not wish your sponsorship to be presented on the page.</p>
				<div class="{{ $errors->has('logo') ? ' has-error' : '' }}">
					{!! Form::label('logo', __('Upload a logo or image').":", ['class'=>'form-label']) !!}
					{!!Form::file('logo',["id"=>"image","class"=>""])!!}
					@if ($errors->has('logo'))
						<span class="help-block">
							<strong>{{ $errors->first('logo') }}</strong>
						</span>
					@endif
				</div>
				<p>Images must be 2MB or smaller, and in PNG or JPG format.</p>
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
