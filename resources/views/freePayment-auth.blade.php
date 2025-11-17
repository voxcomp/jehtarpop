@extends('layouts.app')

@section('title')
Make A Payment
@endsection

@section('content')
	<div class="row justify-content-center">
	<div class="col-md-8">
		<div class="row form-group">
			<div class="col-sm text-center">
				<h4 class="text-center">Payment Total: <strong>${{number_format($amount,2)}}</strong></h4>
			</div>
		</div>
		<div id="iframe_holder" class="center-block" style="width:100%;max-width:400px;height:600px;margin:0 auto;">
			<iframe id="add_payment" class="embed-responsive-item panel" name="add_payment" width="100%" height="600" frameborder="0" scrolling="no">
			</iframe>
		</div>
		<form id="send_hptoken" action="{{(env('ANET_TESTING')=='true')?'https://test.authorize.net/payment/payment':'https://accept.authorize.net/payment/payment'}}" method="post" target="add_payment" >
			<input type="hidden" name="token" value="{{$token}}" />
		</form>
		<form id="transactionSubmit" action="{{route('freePaymentComplete')}}" method="post">
			@csrf
			<input type="hidden" name="firstname" value="">
			<input type="hidden" name="lastname" value="">
			<input type="hidden" name="address" value="">
			<input type="hidden" name="city" value="">
			<input type="hidden" name="state" value="">
			<input type="hidden" name="zip" value="">
			<input type="hidden" name="email" value="">
			<input type="hidden" name="card" value="">
			<input type="hidden" name="cardtype" value="">
			<input type="hidden" name="reference" value="{{$reference}}">
			<input type="hidden" name="transactionid" value="">
			<input type="hidden" name="amount" value="">
		</form>
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
			console.log('communication handler enter');
			var params = parseQueryString(argument.qstr)
			switch(params['action']){
				case "resizeWindow"     : break;
				case "successfulSave"   : break;
				case "cancel"           :
					window.location.href="{{route('freePaymentForm')}}";
					 break;
				case "transactResponse" :
					sessionStorage.removeItem("HPTokenTime");
					var transResponse = JSON.parse(params['response']);
					$("#transactionSubmit input[name=firstname]").val(transResponse.billTo.firstName);
					$("#transactionSubmit input[name=lastname]").val(transResponse.billTo.lastName);
					$("#transactionSubmit input[name=address]").val(transResponse.billTo.address);
					$("#transactionSubmit input[name=city]").val(transResponse.billTo.city);
					$("#transactionSubmit input[name=state]").val(transResponse.billTo.state);
					$("#transactionSubmit input[name=zip]").val(transResponse.billTo.zip);
					$("#transactionSubmit input[name=email]").val(transResponse.billTo.email);
					$("#transactionSubmit input[name=card]").val(transResponse.accountNumber);
					$("#transactionSubmit input[name=cardtype]").val(transResponse.accountType);
					$("#transactionSubmit input[name=transactionid]").val(transResponse.transId);
					$("#transactionSubmit input[name=amount]").val(transResponse.totalAmount);
					$("#transactionSubmit").submit();
			}
		}
		//send the token
		$('#send_hptoken').submit();
	});
</script>
@endsection
