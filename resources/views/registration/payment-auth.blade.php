@extends('layouts.app')

@section('title')
{{ucfirst($path)}} Registration: Payment
@endsection

@section('helpdesk')
	@include('parts.helpdesk',['section'=>'payment','path'=>$path,'id'=>$registration->id])
@endsection

@section('content')
	<div class="row justify-content-center">
		<div class="col-sm">
			<h3 class="text-center">
				<strong>DO NOT REFRESH THIS PAGE</strong><br>
				IF YOU ARE NOT REDIRECTED TO A CONFIRMATION PAGE
				OR YOU ARE UNSURE YOUR REGISTRATION WENT THROUGH,
				DO NOT RESUBMIT AND IMMEDIATELY CONTACT DIANE: <a href="mailto:DIANE@GWGCI.ORG">DIANE@GWGCI.ORG</a> OR <a href="mailto:ALLISON@GWGCI.ORG">ALLISON@GWGCI.ORG</a></h3>
			<div id="iframe_holder" class="center-block" style="width:90%;max-width:600px;height:600px;">
				<iframe id="add_payment" class="embed-responsive-item panel" name="add_payment" width="100%" height="600" frameborder="0" scrolling="no">
				</iframe>
			</div>
			<form id="send_hptoken" action="{{(env('ANET_TESTING')=='true')?'https://test.authorize.net/payment/payment':'https://accept.authorize.net/payment/payment'}}" method="post" target="add_payment" >
				<input type="hidden" name="token" value="{{$token}}" />
			</form>
			<form id="transactionSubmit" action="{{route('registration.payment.complete',[$path,$registration->id])}}" method="post">
				{{-- <input type="hidden" name="firstname" value="">
				<input type="hidden" name="lastname" value="">
				<input type="hidden" name="address" value="">
				<input type="hidden" name="city" value="">
				<input type="hidden" name="state" value="">
				<input type="hidden" name="zip" value="">
				<input type="hidden" name="email" value=""> --}}
				<input type="hidden" name="paid" value="">
				<input type="hidden" name="card" value="">
				<input type="hidden" name="cardtype" value="">
				<input type="hidden" name="transactionid" value="">
			</form>
			<div class="payment-error" style="display:none;">
				<h2 class="text-danger text-center">ERROR!<br>There was an error with your payment.  Please contact Diane or Allison before submitting another registration.</h2>
			</div>
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
			<h4><small>(<a href="{{route('registration.billing',[$path,$registration->id])}}"><i class="fas fa-pencil-alt"></i> edit</a>)</small> Billing:</h4>
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
<script>
	$(document).ready(function(){
		window.CommunicationHandler = {};
	
		function parseQueryString(str) {
			var vars = [];
			var arr = str.split('&');
			var pair;
			for (var i = 0; i < arr.length; i++) {
				pair = arr[i].split('=');
				vars[pair[0]] = unescape(pair[1]);
			}
			return vars;
		}
	
		window.CommunicationHandler.onReceiveCommunication = function (argument) {
			//console.log('communication handler enter');
			var params = parseQueryString(argument.qstr)
			//console.log(params['action']);
			switch(params['action']){
				case "resizeWindow"     : break;
				case "successfulSave"   : break;
				case "cancel"           :
					window.location.href="{{route('registration.cancel',$path)}}";
					 break;
				case "transactResponse" :
					sessionStorage.removeItem("HPTokenTime");
					var transResponse = JSON.parse(params['response']);
					$.ajaxSetup({
						headers: {
							'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						}
					});
					$.ajax({
						url: '/ajax/admin/response/{{$registration->id}}',
						type: 'POST',
						data: {response:transResponse},
						dataType: 'HTML',
						success: function(data) {
							//console.log(data);
						},
						error: function(jqXHR, textStatus, errorThrown) {
						}
					});
					// console.log(transResponse);
					if(transResponse.responseCode==1) {
						// $("#transactionSubmit input[name=firstname]").val(transResponse.billTo.firstName);
						// $("#transactionSubmit input[name=lastname]").val(transResponse.billTo.lastName);
						// $("#transactionSubmit input[name=address]").val(transResponse.billTo.address);
						// $("#transactionSubmit input[name=city]").val(transResponse.billTo.city);
						// $("#transactionSubmit input[name=state]").val(transResponse.billTo.state);
						// $("#transactionSubmit input[name=zip]").val(transResponse.billTo.zip);
						// $("#transactionSubmit input[name=email]").val(transResponse.billTo.email);
						$("#transactionSubmit input[name=card]").val(transResponse.accountNumber);
						$("#transactionSubmit input[name=cardtype]").val(transResponse.accountType);
						$("#transactionSubmit input[name=paid]").val(transResponse.totalAmount);
						$("#transactionSubmit input[name=transactionid]").val(transResponse.transId);
						$("#transactionSubmit").submit();
					} else {
						$(".payment-error").show();
					}
					//window.location.href = '/checkout/complete';
			}
		}
		//send the token
		$('#send_hptoken').submit();
	});
</script>
@endsection

