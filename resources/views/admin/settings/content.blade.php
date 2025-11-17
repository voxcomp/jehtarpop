@extends('layouts.app')

@section('head')
	<script src="https://cdn.ckeditor.com/ckeditor5/33.0.0/decoupled-document/ckeditor.js"></script>
@endsection

@section('title')
Administration - Content Settings
@endsection

@section('content')
		<div class="row justify-content-center">
			<div class="col-sm">
				<div class="card">
					<div class="card-header">Front Page Content Sections</div>
	
					<div class="card-body">
						{!!Form::open(array('route'=>'editContent','id'=>'content_form'))!!}
						<div class="row">
							<div class="col-sm mb-3">
								<label for="fp_correspondence">Correspondence Courses:</label>
								{!! Form::hidden('fp_correspondence',$settings['editor']->fp_correspondence,['id'=>'fp_correspondence']) !!}
								<div id="fp_correspondence_toolbar"></div>
								<div id="fp_correspondence_content">
									{!! $settings['editor']->fp_correspondence !!}
								</div>
							</div>
							<div class="col-sm mb-3">
								<label for="fp_online">Online Courses:</label>
								{!! Form::hidden('fp_online',$settings['editor']->fp_online,['id'=>'fp_online']) !!}
								<div id="fp_online_toolbar"></div>
								<div id="fp_online_content">
									{!! $settings['editor']->fp_online !!}
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm mb-3">
								<label for="fp_correspondence">Trade Courses:</label>
								{!! Form::hidden('fp_trade',$settings['editor']->fp_trade,['id'=>'fp_trade']) !!}
								<div id="fp_trade_toolbar"></div>
								<div id="fp_trade_content">
									{!! $settings['editor']->fp_trade !!}
								</div>
							</div>
							<div class="col-sm mb-3"</div>
								<label for="fp_training">Training Courses:</label>
								{!! Form::hidden('fp_training',$settings['editor']->fp_training,['id'=>'fp_training']) !!}
								<div id="fp_training_toolbar"></div>
								<div id="fp_training_content">
									{!! $settings['editor']->fp_training !!}
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm mb-3">
								<label for="fp_event">Events:</label>
								{!! Form::hidden('fp_event',$settings['editor']->fp_event,['id'=>'fp_event']) !!}
								<div id="fp_event_toolbar"></div>
								<div id="fp_event_content">
									{!! $settings['editor']->fp_event !!}
								</div>
							</div>
						</div>
						<div class="form-group">{!!Form::submit('Save Content',['class'=>'btn btn-primary'])!!}</div>
						{!!Form::close()!!}
					</div>
				</div>
			</div>
		</div>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<div class="row justify-content-center">
			<div class="col-sm">
				<div class="card">
					<div class="card-header">Help Desk Content Sections</div>
		
					<div class="card-body">
						<p>Shown on the corresponding page during the registration process.</p>

						{!!Form::open(array('route'=>'editHelpDesk','id'=>'help_form'))!!}
						<div class="row">
							<div class="col-sm mb-3">
								<label for="hd_company">Company Information:</label>
								{!! Form::hidden('hd_company',$settings['editor']->hd_company,['id'=>'hd_company']) !!}
								<div id="hd_company_toolbar"></div>
								<div id="hd_company_content">
									{!! $settings['editor']->hd_company !!}
								</div>
							</div>
							<div class="col-sm mb-3">
								<label for="hd_registrant">Add Registrant:</label>
								{!! Form::hidden('hd_registrant',$settings['editor']->hd_registrant,['id'=>'hd_registrant']) !!}
								<div id="hd_registrant_toolbar"></div>
								<div id="hd_registrant_content">
									{!! $settings['editor']->hd_registrant !!}
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm mb-3">
								<label for="hd_billing">Payment Billing Information:</label>
								{!! Form::hidden('hd_billing',$settings['editor']->hd_billing,['id'=>'hd_billing']) !!}
								<div id="hd_billing_toolbar"></div>
								<div id="hd_billing_content">
									{!! $settings['editor']->hd_billing !!}
								</div>
							</div>
							<div class="col-sm mb-3"</div>
								<label for="hd_payment">Payment:</label>
								{!! Form::hidden('hd_payment',$settings['editor']->hd_payment,['id'=>'hd_payment']) !!}
								<div id="hd_payment_toolbar"></div>
								<div id="hd_payment_content">
									{!! $settings['editor']->hd_payment !!}
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm mb-3">
								<label for="hd_individual">Individual:</label>
								{!! Form::hidden('hd_individual',$settings['editor']->hd_individual,['id'=>'hd_individual']) !!}
								<div id="hd_individual_toolbar"></div>
								<div id="hd_individual_content">
									{!! $settings['editor']->hd_individual !!}
								</div>
							</div>
						</div>
						<div class="form-group">{!!Form::submit('Save',['class'=>'btn btn-primary'])!!}</div>
						{!!Form::close()!!}
					</div>
				</div>
			</div>
		</div>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<div class="row justify-content-center">
			<div class="col-sm">
				<div class="card">
					<div class="card-header">Registration Confirmation Email</div>
		
					<div class="card-body">
						<p>Shown in the confirmation email when a registrant completes a registration.</p>
						{!!Form::open(array('route'=>'confirmationEmail','id'=>'confirmationEmail_form'))!!}
						<div class="row">
							<div class="col-sm">
								<h3>Trade Confirmation</h3>
								<div class="form-group">
								{!! Form::hidden('tradeConfirmation',$settings['editor']->tradeconfirmation,['id'=>'tradeConfirmation']) !!}
								<div id="tradeConfirmation_toolbar"></div>
								<div id="tradeConfirmation_content">
									{!! $settings['editor']->tradeconfirmation !!}
								</div>
								</div>
							</div>
							<div class="col-sm">
								<h3>Correspondence Confirmation</h3>
								<div class="form-group">
								{!! Form::hidden('correspondenceConfirmation',$settings['editor']->correspondenceconfirmation,['id'=>'correspondenceConfirmation']) !!}
								<div id="correspondenceConfirmation_toolbar"></div>
								<div id="correspondenceConfirmation_content">
									{!! $settings['editor']->correspondenceconfirmation !!}
								</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm">
								<h3>Training Confirmation</h3>
								<div class="form-group">
								{!! Form::hidden('trainingConfirmation',$settings['editor']->trainingconfirmation,['id'=>'trainingConfirmation']) !!}
								<div id="trainingConfirmation_toolbar"></div>
								<div id="trainingConfirmation_content">
									{!! $settings['editor']->trainingconfirmation !!}
								</div>
								</div>
							</div>
							<div class="col-sm">
								<h3>Online Confirmation</h3>
								<div class="form-group">
								{!! Form::hidden('onlineConfirmation',$settings['editor']->onlineconfirmation,['id'=>'onlineConfirmation']) !!}
								<div id="onlineConfirmation_toolbar"></div>
								<div id="onlineConfirmation_content">
									{!! $settings['editor']->onlineconfirmation !!}
								</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm">
								<h3>Event Confirmation</h3>
								<div class="form-group">
								{!! Form::hidden('eventConfirmation',$settings['editor']->eventconfirmation,['id'=>'eventConfirmation']) !!}
								<div id="eventConfirmation_toolbar"></div>
								<div id="eventConfirmation_content">
									{!! $settings['editor']->eventconfirmation !!}
								</div>
								</div>
							</div>
						</div>
						<div class="form-group">{!!Form::submit('Submit',['class'=>'btn btn-primary'])!!}</div>
						{!!Form::close()!!}
					</div>
				</div>
			</div>
		</div>
@endsection

@section('footer')
<script>
	var sections = ['fp_correspondence', 'fp_online', 'fp_trade', 'fp_training', 'fp_event', 'tradeConfirmation', 'correspondenceConfirmation', 'eventConfirmation', 'onlineConfirmation', 'trainingConfirmation', 'hd_company', 'hd_registrant', 'hd_billing', 'hd_payment', 'hd_individual'];
	sections.forEach(function(value) {
//		console.log(value);
		DecoupledEditor
			.create( document.querySelector( '#'+value+'_content' ) )
			.then( editor => {
				const toolbarContainer = document.querySelector( '#'+value+'_toolbar' );
	
				toolbarContainer.appendChild( editor.ui.view.toolbar.element );
			} )
			.catch( error => {
				console.error( error );
			} );
	});
	$(document).ready(function() {
		$('#content_form').on('submit',function() {
			$("#fp_correspondence").val($('#fp_correspondence_content').html());
			$("#fp_online").val($('#fp_online_content').html());
			$("#fp_trade").val($('#fp_trade_content').html());
			$("#fp_training").val($('#fp_training_content').html());
			$("#fp_event").val($('#fp_event_content').html());
		});
		$('#help_form').on('submit',function() {
			$("#hd_company").val($('#hd_company_content').html());
			$("#hd_registrant").val($('#hd_registrant_content').html());
			$("#hd_billing").val($('#hd_billing_content').html());
			$("#hd_payment").val($('#hd_payment_content').html());
			$("#hd_individual").val($('#hd_individual_content').html());
		});
		$('#confirmationEmail_form').on('submit',function() {
			$("#tradeConfirmation").val($('#tradeConfirmation_content').html());
			$("#correspondenceConfirmation").val($('#correspondenceConfirmation_content').html());
			$("#eventConfirmation").val($('#eventConfirmation_content').html());
			$("#onlineConfirmation").val($('#onlineConfirmation_content').html());
			$("#trainingConfirmation").val($('#trainingConfirmation_content').html());
		});
		
	});
</script>
@endsection