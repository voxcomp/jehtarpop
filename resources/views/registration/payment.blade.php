@extends('layouts.app')

@section('title')
{{ucfirst($path)}} Registration: Payment
@endsection

@section('helpdesk')
	@include('parts.helpdesk',['section'=>'billing','path'=>$path])
@endsection

@section('content')
	<?php $cost = 0; ?>
	@foreach($registration['registrants'] as $key=>$registrant)
		<?php $cost += $registrant['cost']; ?>
	@endforeach
	@if(isset($registration['name']) && $registration['name']!='Self Students')
		<?php $responsible = 'company'; ?>
	@else
		<?php $responsible = 'student'; ?>
	@endif
	<div class="row justify-content-center">
		<div class="col-sm">
			@if($registration['name']!='Self Students')
			{{--
				<div class="card">
					<div class="card-header"><big><i class="far fa-money-bill-alt"></i></big> Amount To Pay:</div>
		
		            <div class="card-body">
			            <div class="form-group">
							{{ html()->text('due', old('due', number_format($cost, 2, ".", "")))->id('due')->class('form-control')->attribute('onkeyup', 'copyDue(this.value)') }}
			            </div>
						<div class="row">
							<div class="col-sm">
						         <input id="ponum" type="text" class="form-control" name="ponum" value="{{ old('ponum',(isset($register['ponum']))?$register['ponum']:'') }}" required placeholder="PO Number" onkeyup="copyPO(this.value)">
						    </div>
						</div>
		            </div>
				</div>
				<p>&nbsp;</p>
				--}}
				<div class="card">
					<div class="card-header"><big><i class="fas fa-user-friends"></i></big> Party Responsible for Payment:</div>
		
		            <div class="card-body">
						<div class="row">
							<div class="col-sm">
								 {{ html()->radio('responsible', true, 'company')->attribute('onclick', "copyResponsible(this.value)") }} COMPANY
						    </div>
							<div class="col-sm">
								 {{ html()->radio('responsible', false, 'student')->attribute('onclick', "copyResponsible(this.value)") }} STUDENT
						    </div>
						</div>
		            </div>
				</div>
				<p>&nbsp;</p>
			@endif
			<div class="card">
				<div class="card-header"><big><i class="fas fa-gift"></i></big> Discount Code</div>
	
	            <div class="card-body">
		            <div class="coupon-container">
						<input id="coupon" type="text" class="form-control" name="coupon" value="{{old('coupon',(isset($register['ponum']))?$register['ponum']:'')}}">
		            </div>
		        </div>
			</div>
			<p>&nbsp;</p>
				{{--
			@if($path!='online')
			<div class="row">
				<div class="col-sm">
					{{ html()->form('POST', route('registration.payment.alt', $path))->class('paymentform')->id('checkPayment_form')->open() }}
					{{ html()->hidden('applied', '')->class('applied') }}
					{{ html()->hidden('ponum', '')->class('ponum') }}
					{{ html()->hidden('responsible', $responsible)->class('responsible') }}
					{{ html()->hidden('coupon', '')->class('coupon') }}
					{{ html()->hidden('method', 'check') }}
					<p class="text-center"><a onclick="SubmitConfirmDialog('{{getPaymentAgree()}}','Payment Agreement',$('#checkPayment_form'))" class="btn btn-warning btn-lg d-block w-100"><strong><big><i class="fas fa-money-check-alt text-primary"></i></big> Pay with Check</strong></a></p>
					{{ html()->form()->close() }}
				</div>
				@if($registration['name']!='Self Students' && $path!='online')
				<div class="col-sm">
					{{ html()->form('POST', route('registration.payment.alt', $path))->class('paymentform')->id('invoicePayment_form')->open() }}
					{{ html()->hidden('applied', '')->class('applied') }}
					{{ html()->hidden('ponum', '')->class('ponum') }}
					{{ html()->hidden('responsible', $responsible)->class('responsible') }}
					{{ html()->hidden('coupon', '')->class('coupon') }}
					{{ html()->hidden('method', 'invoice') }}
					<p class="text-center"><a onclick="SubmitConfirmDialog('{{getPaymentAgree()}}','Payment Agreement',$('#invoicePayment_form'))" class="btn btn-warning btn-lg d-block w-100"><strong><big><i class="fas fa-file-alt text-primary"></i></big> Pay by Invoice</strong></a></p>
					{{ html()->form()->close() }}
				</div>
				@endif
			</div>
			<p class="text-center"><strong>OR</strong><br><big><i class="far fa-credit-card text-primary"></i></big> <strong>Pay with Credit Card or eCheck (ACH) below</strong></p>
			@endif
			--}}
			<p class="text-center"><big><i class="far fa-credit-card text-primary"></i></big> <strong>Pay with Credit Card or eCheck (ACH) below</strong></p>
			{{ html()->form('POST', route('registration.payment.toCC', $path))->class('paymentform')->id('ccpaymentform')->open() }}
			{{ html()->hidden('amount', $cost) }}
			{{ html()->hidden('reference', '') }}
			{{ html()->hidden('applied', '')->class('applied') }}
			{{ html()->hidden('ponum', '')->class('ponum') }}
			{{ html()->hidden('responsible', $responsible)->class('responsible') }}
			{{ html()->hidden('coupon', '')->class('coupon') }}
			<div class="card">
				<div class="card-header">Billing Information</div>
	
	            <div class="card-body">
			        <div class="row">
						<div class="col-sm">
							<div class="form-group{{ $errors->has('firstname') ? ' has-error' : '' }}">
					            <input id="firstname" type="text" class="form-control" name="firstname" value="{{ old('firstname',(($registration['name']!='Self Students')?$registration['contactfname']:$registration['registrants'][0]['firstname'])) }}" required placeholder="First Name">
					            @if ($errors->has('firstname'))
					                <span class="help-block">
					                    <strong>{{ $errors->first('firstname') }}</strong>
					                </span>
					            @endif
							</div>
						</div>
						<div class="col-sm">
							<div class="form-group{{ $errors->has('lastname') ? ' has-error' : '' }}">
					            <input id="lastname" type="text" class="form-control" name="lastname" value="{{ old('lastname',(($registration['name']!='Self Students')?$registration['contactlname']:$registration['registrants'][0]['lastname'])) }}" required placeholder="Last Name">
					            @if ($errors->has('lastname'))
					                <span class="help-block">
					                    <strong>{{ $errors->first('lastname') }}</strong>
					                </span>
					            @endif
							</div>
						</div>
			        </div>
					<div class="row form-group{{ $errors->has('company') ? ' has-error' : '' }}">
				        <div class="col">
				            <input id="company" type="text" class="form-control" name="company" value="{{ old('company',(($registration['name']!='Self Students')?$registration['name']:'')) }}" placeholder="Company">
				            @if ($errors->has('company'))
				                <span class="help-block">
				                    <strong>{{ $errors->first('company') }}</strong>
				                </span>
				            @endif
				        </div>
					</div>
					<p><strong>Please note:</strong> The address entered must match the address on file for your credit card.</p>
					<div class="row form-group{{ $errors->has('address') ? ' has-error' : '' }}">
				        <div class="col">
				            <input id="address" type="text" class="form-control" name="address" value="{{ old('address',(($registration['name']!='Self Students')?$registration['address']:$registration['registrants'][0]['address'])) }}" required placeholder="Address">
				            @if ($errors->has('address'))
				                <span class="help-block">
				                    <strong>{{ $errors->first('address') }}</strong>
				                </span>
				            @endif
				        </div>
					</div>
					<div class="row form-group">
						<div class="col-sm-5 col-xs-12 col-spacing{{ $errors->has('city') ? ' has-error' : '' }}">
				            <input id="city" type="text" class="form-control" name="city" value="{{ old('city',(($registration['name']!='Self Students')?$registration['city']:$registration['registrants'][0]['city'])) }}" required placeholder="City">
				            @if ($errors->has('city'))
				                <span class="help-block">
				                    <strong>{{ $errors->first('city') }}</strong>
				                </span>
				            @endif
						</div>
						<div class="col-sm-3 col-xs-4 col-spacing{{ $errors->has('state') ? ' has-error' : '' }}">
				            <input id="state" type="text" class="form-control" name="state" value="{{ old('state',(($registration['name']!='Self Students')?$registration['state']:$registration['registrants'][0]['state'])) }}" required placeholder="ST">
				            @if ($errors->has('state'))
				                <span class="help-block">
				                    <strong>{{ $errors->first('state') }}</strong>
				                </span>
				            @endif
						</div>
						<div class="col-sm-4 col-xs-8{{ $errors->has('zip') ? ' has-error' : '' }}">
				            <input id="zip" type="text" class="form-control" name="zip" value="{{ old('zip',(($registration['name']!='Self Students')?$registration['zip']:$registration['registrants'][0]['zip'])) }}" required placeholder="Zip Code">
				            @if ($errors->has('zip'))
				                <span class="help-block">
				                    <strong>{{ $errors->first('zip') }}</strong>
				                </span>
				            @endif
						</div>
					</div>
					<div class="row form-group">
						<div class="col-sm col-xs-12 col-spacing{{ $errors->has('phone') ? ' has-error' : '' }}">
				            <input id="phone" type="text" class="form-control phone" name="phone" value="{{ old('phone',(($registration['name']!='Self Students')?$registration['cphone']:$registration['registrants'][0]['mobile'])) }}" required placeholder="Phone">
				            @if ($errors->has('phone'))
				                <span class="help-block">
				                    <strong>{{ $errors->first('phone') }}</strong>
				                </span>
				            @endif
						</div>
						<div class="col-sm col-xs-8{{ $errors->has('email') ? ' has-error' : '' }}">
				            <input id="email" type="email" class="form-control" name="email" value="{{ old('email',(($registration['name']!='Self Students')?$registration['cemail']:$registration['registrants'][0]['email'])) }}" required placeholder="Email">
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
							<div class="form-group{{ $errors->has('card_number') ? ' has-error' : '' }}">
								{{ html()->text('card_number')->class('form-control ccard')->placeholder('CARD NUMBER') }}
					            @if ($errors->has('card_number'))
					                <span class="help-block">
					                    <strong>{{ $errors->first('card_number') }}</strong>
					                </span>
					            @endif
							</div>
						</div>
			        </div>
			        <div class="row">
						<div class="col form-group{{ $errors->has('expiration_month') ? ' has-error' : '' }}">
							<label for="expiration_month">Expire Month</label>
							{{ html()->select('expiration_month', [1 => "January", 2 => "February", 3 => "March", 4 => "April", 5 => "May", 6 => "June", 7 => "July", 8 => "August", 9 => "September", 10 => "October", 11 => "November", 12 => "December"], 1)->class('form-control') }}
				            @if ($errors->has('expiration_month'))
				                <span class="help-block">
				                    <strong>{{ $errors->first('expiration_month') }}</strong>
				                </span>
				            @endif
						</div>
						<div class="col form-group{{ $errors->has('expiration_year') ? ' has-error' : '' }}">
							<label for="expiration_year">Expire Year</label>
							{{ html()->select('expiration_year', [2022 => "2022", 2023 => "2023", 2024 => "2024", 2025 => "2025", 2026 => "2026", 2027 => "2027", 2028 => "2028", 2029 => "2029", 2030 => "2030", 2031 => "2031", 2032 => "2032", 2033 => "2033", 2034 => "2034"], date('Y'))->class('form-control') }}
				            @if ($errors->has('expiration_year'))
				                <span class="help-block">
				                    <strong>{{ $errors->first('expiration_year') }}</strong>
				                </span>
				            @endif
						</div>
						<div class="col form-group{{ $errors->has('cvc') ? ' has-error' : '' }}">
							<label for="cvc">CVC (on back)</label>
							{{ html()->text('cvc')->class('form-control')->placeholder('CVC') }}
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
					@if(isset($path) && $path=="trade")
						<a href="#" onclick="SubmitConfirmDialog('{{getPaymentAgree()}}','Payment Agreement',$('#ccpaymentform'))" class="btn btn-primary">Continue To Payment</a>
						
					@else
			            <input type="submit" class="btn btn-primary" value="Continue To Payment">
					@endif
		        </div>
		    </div>
			{{ html()->form()->close() }}
		</div>
	</div>
@endsection

@section('rightsidebar')
	<div class="card">
		<div class="card-header text-center">
			<h4>Details</h4>
		</div>
		<div class="card-body">
			@if($registration['name']!='Self Students')
			<h4><a href="{{route('registration.company',$path)}}"><i class="fas fa-edit"></i></a> Company:</h4>
			<p><strong>{{$registration['name']}}</strong><br>{{$registration['address']}}<br>{{$registration['city']}}, {{$registration['state']}} {{$registration['zip']}}</p>
			<p>{{$registration['phone']}}</p>
			<p>&nbsp;</p>
			<h4>Registrants:</h4>
			@endif
			@foreach($registration['registrants'] as $key=>$registrant)
			<p style="line-height:1em;">@if($registration['name']!='Self Students')<a href="{{route('registration.registrant.remove',[$path,$key])}}"><i class="fas fa-user-slash"></i></a>@endif {{$registrant['firstname']}} {{$registrant['lastname']}}<br><small>{{$registrant['class']}}<br>Cost: ${{$registrant['cost']}}</small></p>
			@endforeach
			<p>&nbsp;</p>
			<h5 class="text-dark">SubTotal: <strong>$<span class="subtotal">{{number_format($cost,2)}}</span></strong></h5>
			<h5 class="text-dark">Discount: <strong>$<span class="discount">0.00</span></strong></h5>
			<h4 class="text-danger">Total: <strong>$<span class="total">{{number_format($cost,2)}}</span></strong></h4>
		    <p>&nbsp;</p>
	        <div class="text-center">
	            <a href="{{route('registration.cancel',$path)}}" class="btn btn-warning">Cancel Registration</a>
	        </div>
		</div>
	</div>
@endsection

@section('footer')
<script>
	var couponTimer;
	$(window).on("load", function() {
		var couponElement = document.getElementById('coupon');
		if (!couponElement) return;  // Safety check

		couponElement.addEventListener('keyup', function(event) {
			clearTimeout(couponTimer);
			if (couponElement.value.length) {
				couponTimer = setTimeout(function() {
					checkCoupon(couponElement.value, 'coupon', '{{$path}}');
				}, 450);
			} else {
				$("#coupon").parent().removeClass("has-error").find(".alert").remove();
			}
		});
	});
</script>@endsection

