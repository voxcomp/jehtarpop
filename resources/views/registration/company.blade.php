@extends('layouts.app')

@section('title')
	{{ucfirst($path)}} Registration: Company
@endsection

@section('helpdesk')
	@include('parts.helpdesk',['section'=>'company','path'=>$path])
@endsection

@section('content')
	{!! Form::open(array('route' => ['registration.company.save',$path], 'id'=>'company_form')) !!}
	@if(isset($register))
	    {{ method_field('PATCH') }}
	@endif
	<div class="row  justify-content-center">
		@if(isset($register))
			<div class="col-sm">
		@else
			<div class="col-sm">
		@endif
			@if(!isset($register))
				<div class="message">If you are not affiliated with a company, please <a href="{{route('registration.individual',$path)}}">click here to register as an individual</a>.</div>
			@endif
			<div class="card">
				<div class="card-header">Company Information</div>
	
	            <div class="card-body">
			        <div class="row">
						<div class="col-sm-5">
							<div class="form-group">
								<label for="company">Choose Your Company Name</label>
								{!! Form::select('company',(['0'=>'Please choose...']+$customers->pluck('name','id')->all()),null,['id'=>'company','class'=>'form-control','onchange'=>'getCompanyInformation(this.value)']) !!}
							</div>
						</div>
						<div class="col-sm-7">
							<p>If your company name is not listed in the drop down list, please enter your company information.</p>
							<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
					            <input id="name" type="text" class="form-control" name="name" value="{{ old('name',(isset($register['name']))?$register['name']:'') }}" onkeyup="getCompanyName(this.value)" placeholder="Company Name" required >
					            <div class="companies">
					            </div>
					            @if ($errors->has('name'))
					                <span class="help-block">
					                    <strong>{{ $errors->first('name') }}</strong>
					                </span>
					            @endif
							</div>
							<div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
					            <input id="phone" type="text" class="form-control phone" name="phone" value="{{ old('phone',(isset($register['phone']))?$register['phone']:'') }}" required placeholder="Phone">
					            @if ($errors->has('phone'))
					                <span class="help-block">
					                    <strong>{{ $errors->first('phone') }}</strong>
					                </span>
					            @endif
							</div>
							<div class="row form-group{{ $errors->has('address') ? ' has-error' : '' }}">
						        <div class="col-sm">
						            <input id="address" type="text" class="form-control" name="address" value="{{ old('address',(isset($register['address']))?$register['address']:'') }}" required placeholder="Address">
						            @if ($errors->has('address'))
						                <span class="help-block">
						                    <strong>{{ $errors->first('address') }}</strong>
						                </span>
						            @endif
						        </div>
							</div>
							<div class="row form-group">
								<div class="col-sm-5 col-xs-12 col-spacing{{ $errors->has('city') ? ' has-error' : '' }}">
						            <input id="city" type="text" class="form-control" name="city" value="{{ old('city',(isset($register['city']))?$register['city']:'') }}" required placeholder="City">
						            @if ($errors->has('city'))
						                <span class="help-block">
						                    <strong>{{ $errors->first('city') }}</strong>
						                </span>
						            @endif
								</div>
								<div class="col-sm-3 col-xs-4 col-spacing{{ $errors->has('state') ? ' has-error' : '' }}">
						            <input id="state" type="text" class="form-control" name="state" value="{{ old('state',(isset($register['state']))?$register['state']:'') }}" required placeholder="ST">
						            @if ($errors->has('state'))
						                <span class="help-block">
						                    <strong>{{ $errors->first('state') }}</strong>
						                </span>
						            @endif
								</div>
								<div class="col-sm-4 col-xs-8{{ $errors->has('zip') ? ' has-error' : '' }}">
						            <input id="zip" type="text" class="form-control" name="zip" value="{{ old('zip',(isset($register['zip']))?$register['zip']:'') }}" required placeholder="Zip Code">
						            @if ($errors->has('zip'))
						                <span class="help-block">
						                    <strong>{{ $errors->first('zip') }}</strong>
						                </span>
						            @endif
								</div>
							</div>
						</div>
			        </div>
	            </div>
			</div>
			<p>&nbsp;</p>
			<div class="card">
				<div class="card-header">Company Contact</div>
	
	            <div class="card-body">
					<div class="row pb-3">
				        <div class="col-sm col-spacing{{ $errors->has('contactfname') ? ' has-error' : '' }}">
				            <input id="contactfname" type="text" class="form-control" name="contactfname" value="{{ old('contactfname',(isset($register['contactfname']))?$register['contactfname']:'') }}" placeholder="First Name">
							@if ($errors->has('contactfname'))
								<span class="help-block">
									<strong>{{ str_replace("contactfname","first name",$errors->first('contactfname')) }}</strong>
								</span>
							@endif
				        </div>
				        <div class="col-sm col-spacing{{ $errors->has('contactlname') ? ' has-error' : '' }}">
				            <input id="contactlname" type="text" class="form-control" name="contactlname" value="{{ old('contactlname',(isset($register['contactlname']))?$register['contactlname']:'') }}" placeholder="Last Name">
							@if ($errors->has('contactlname'))
								<span class="help-block">
									<strong>{{ str_replace("contactlname","last name",$errors->first('contactlname')) }}</strong>
								</span>
							@endif
				        </div>
					</div>
					<div class="row">
				        <div class="col-sm col-spacing{{ $errors->has('cphone') ? ' has-error' : '' }}">
				            <input id="cphone" type="text" class="form-control phone" name="cphone" value="{{ old('cphone',(isset($register['cphone']))?$register['cphone']:'') }}" placeholder="Phone">
							@if ($errors->has('cphone'))
								<span class="help-block">
									<strong>{{ str_replace("cphone","phone",$errors->first('cphone')) }}</strong>
								</span>
							@endif
				        </div>
					    <div class="col-sm{{ $errors->has('cemail') ? ' has-error' : '' }}">
					        <input id="cemail" type="cemail" class="form-control" name="cemail" value="{{ old('cemail',(isset($register['cemail']))?$register['cemail']:'') }}" autocomplete="off" placeholder="E-mail">
					        @if ($errors->has('cemail'))
					            <span class="help-block">
					                <strong>{{ str_replace("cemail","email",$errors->first('cemail')) }}</strong>
					            </span>
					        @endif
					    </div>
					</div>
	            </div>
			</div>
			
			<p>&nbsp;</p>
		    <div class="row form-group">
		        <div class="col-sm rtecenter">
		            <input type="submit" class="btn btn-primary" value="Continue">
		        </div>
		    </div>
		</div>
	</div>
	{!! Form::close() !!}
@endsection

@if(isset($register))
@section('rightsidebar')
	<div class="card">
		<div class="card-header text-center">
			<h4>Details</h4>
		</div>
		<div class="card-body">
			<h4><a href="{{route('registration.company',[$path])}}"><i class="fas fa-edit"></i></a> Company:</h4>
			<p><strong>{{$register['name']}}</strong><br>{{$register['address']}}<br>{{$register['city']}}, {{$register['state']}} {{$register['zip']}}</p>
			<p>{{$register['phone']}}</p>
			<p>&nbsp;</p>
		@if(sizeof($register['registrants']))
			<h4>Registrants:</h4>
			<?php $cost = 0; ?>
			@foreach($register['registrants'] as $key=>$registrant)
			<p style="line-height:1em;"><a href="{{route('registration.registrant.remove',[$path,$key])}}"><i class="fas fa-user-slash"></i></a> {{$registrant['firstname']}} {{$registrant['lastname']}}<br><small>{{$registrant['class']}}<br>Cost: ${{$registrant['cost']}}</small></p>
			<?php $cost += $registrant['cost']; ?>
			@endforeach
			<p>&nbsp;</p>
			<h5>Total Cost: <strong>${{number_format($cost,2)}}</strong></h5>
	        <div class="text-center">
	            <a href="{{route('registration.payment',$path)}}" class="btn btn-danger">Continue To Payment</a>
	        </div>
		    <p>&nbsp;</p>
		@endif
	        <div class="text-center">
	            <a href="{{route('registration.cancel',$path)}}" class="btn btn-warning">Cancel Registration</a>
	        </div>
		</div>
	</div>
@endsection
@endif

@section('footer')
<!-- Modal -->
<div class="modal fade" id="companyModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Choose Your Company</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
	      <p>Please let us know if this is your company to take advantage of member pricing:</p>
	      <div id="modalCompany"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="useNew()">Use This Information</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="keepOld()">Decline</button>
      </div>
    </div>
  </div>
</div>

<script>
(function($) {
	window.companyobj = 0;
	
	window.matchCompanyInformation = function(coname,coaddress,cocity,cozip,cophone) {
		$.ajaxSetup({
		    headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    }
		});
        $.ajax({
            url: '/ajax/company/compare/match',
            type: 'POST',
            data:{
	            name:coname,
	            address:coaddress,
	            city:cocity,
	            zip:cozip,
	            phone:cophone
            },
            dataType: 'HTML',
            success: function(data) {
	            data = JSON.parse(data);
	            if(jQuery.isEmptyObject(data)) {
		            document.getElementById('company_form').submit()
	            } else {
		            companyobj = data;
		            $("#modalCompany").html(data.name+'<br>'+data.address+'<br>'+data.city+', '+data.state+' '+data.zip+"<br>"+data.phone);
					$("#companyModal").modal({
						keyboard:false
					});
				}
            },
            error: function(jqXHR, textStatus, errorThrown) {
            }
        });
	}

	window.useNew = function() {
        $(".companies").html('');
        $("#company").val(companyobj.id);
        $("#name").val(companyobj.name);
        $("#address").val(companyobj.address);
        $("#phone").val(companyobj.phone);
        $("#city").val(companyobj.city);
        $("#state").val(companyobj.state);
        $("#zip").val(companyobj.zip);
		$("#companyModal").modal("hide");
        document.getElementById('company_form').submit()
	}
	
	window.keepOld = function() {
		document.getElementById('company_form').submit()
	}
	
	$(document).ready(function() {
		$("#company_form").on("submit",function(e) {
			if($("#company").val()==0) {
				e.preventDefault();
				matchCompanyInformation($('#name').val(),$('#address').val(),$('#city').val(),$('#zip').val(),$('#phone').val());
			}
		});
	});
})(jQuery);
</script>
@endsection