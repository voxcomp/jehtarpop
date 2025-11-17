@extends('layouts.app')

@section('title')
	Donation Payment
@endsection

@section('content')
	<div class="row justify-content-center">
		<div class="col-lg-8">
			<h5 class="text-center"> IF YOU ARE NOT REDIRECTED TO A CONFIRMATION PAGE
				OR YOU ARE UNSURE YOUR PAYMENT WENT THROUGH,
				DO NOT RESUBMIT AND IMMEDIATELY CONTACT DIANE: <a href="mailto:DIANE@GWGCI.ORG">DIANE@GWGCI.ORG</a> OR <a href="mailto:ALLISON@GWGCI.ORG">ALLISON@GWGCI.ORG</a></h5>
			<p>&nbsp;</p>
			<h3 class="text-center"><strong>Donation Amount: ${{number_format($donation->amount,2)}}</strong></h3>
			<div id="iframe_holder" class="center-block" style="width:90%;max-width:400px;height:600px;">
				<iframe id="add_payment" class="embed-responsive-item panel" name="add_payment" width="100%" height="600" frameborder="0" scrolling="no">
				</iframe>
			</div>
			<form id="send_hptoken" action="{{(env('ANET_TESTING')=='true')?'https://test.authorize.net/payment/payment':'https://accept.authorize.net/payment/payment'}}" method="post" target="add_payment" >
				<input type="hidden" name="token" value="{{$token}}" />
			</form>
			<form id="transactionSubmit" action="{{route('donations.submitPayment',[$donation->id])}}" method="post">
				<input type="hidden" name="paid" value="">
				<input type="hidden" name="card" value="">
				<input type="hidden" name="cardtype" value="">
			</form>
			<div class="payment-error" style="display:none;">
				<h3 class="text-danger text-center">ERROR!<br>There was an error with your payment.  Please contact Diane or Allison before submitting another payment.</h3>
			</div>
		</div>
	</div>
@endsection

@section('rightsidebar')
	@include('donations.progress-part')
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
				case "successfulSave"   : console.log('save'); break;
				case "cancel"           :
					window.location.href="{{route('donations.page')}}";
					 break;
				case "transactResponse" :
					sessionStorage.removeItem("HPTokenTime");
					var transResponse = JSON.parse(params['response']);
					if(transResponse.responseCode==1) {
						$("#transactionSubmit input[name=card]").val(transResponse.accountNumber);
						$("#transactionSubmit input[name=cardtype]").val(transResponse.accountType);
						$("#transactionSubmit input[name=paid]").val(transResponse.totalAmount);
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

