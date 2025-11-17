@extends('layouts.app')

@section('head')
	<script src="https://cdn.ckeditor.com/ckeditor5/33.0.0/decoupled-document/ckeditor.js"></script>
@endsection

@section('title')
Administration - Registration Content Settings
@endsection

@section('content')
		<div class="row justify-content-center">
			<div class="col-sm">
				<div class="card">
					<div class="card-header">Payment Agreement</div>
		
					<div class="card-body">
						<p>Shown in a popup when a registrant chooses check or invoice payment.</p>
						{!!Form::open(array('route'=>'paymentAgree','id'=>'paymentAgree_form'))!!}
						<div class="row">
							<div class="col-sm">
								<div class="form-group">
								{!! Form::hidden('paymentAgree',$settings['editor']->paymentAgree,['id'=>'paymentAgree']) !!}
								<div id="paymentAgree_toolbar"></div>
								<div id="paymentAgree_content">
									{!! $settings['editor']->paymentAgree !!}
									{{--{!! html_entity_decode($paymentAgree) !!}--}}
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
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<div class="row justify-content-center">
			<div class="col-sm">
				<div class="card">
					<div class="card-header">Trade Agreement Checkboxes</div>
	
					<div class="card-body">
						{!!Form::open(array('route'=>'registrationTradeAgree'))!!}
						<div class="row">
							<div class="col-sm">
								<p>Add an agreement checkbox when a specific trade is chosen during registration.  The trade name must exactly match those in the registration dropdown.</p>
								<div class="form-group">
									<label for='trade'>Trade:</label>
									{!!Form::text('trade',old('trade'),['class'=>'form-control'])!!}
								</div>
								<div class="form-group">
									<label for='cbmessage'>Checkbox Content:</label>
									{!!Form::textarea('message',old('message'),['class'=>'form-control'])!!}
								</div>
							</div>
							<div class="col-sm">
								<table class="table table-striped table-bordered">
									<tbody>
										@foreach($settings['agreement'] as $key=>$agreement)
											<?php $key = str_replace('t_','',$key); ?>
											<tr><td width="10%"><a href="{{route('registrationTradeAgreeRemove',$key)}}"><i class="far fa-trash-alt"></i></a></td>
											<td width="20%">{{$key}}</td>
											<td width="*">{!!$agreement!!}</td>
											</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						</div>
						<div class="form-group">{!!Form::submit('Submit',['class'=>'btn btn-primary'])!!}</div>
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
					<div class="card-header"><a name="cdform"></a>Class Descriptions</div>
		
					<div class="card-body">
						<div class="row">
							<div class="col-sm-4 mb-4">
								{!!Form::select('classes',$classlist,null,['id'=>'classlist','class'=>'form-control'])!!}
								<div class="help-block" id="classDescriptionMessage"></div>
							</div>
							<div class="col-sm-8">
								{!!Form::open(array('route'=>'classDescription','id'=>'description_form'))!!}
								{!!Form::textarea('classDescription','',['class'=>'form_control','id'=>'classDescription','data-id'=>'0'])!!}<br>
								{!!Form::submit('Save Description',['class'=>'btn btn-primary','style'=>'display:none;','id'=>'classDescriptionSubmit'])!!}
								{!!Form::close()!!}
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
@endsection

@section('footer')
<script>
	var sections = ['paymentAgree'];
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
		$('#paymentAgree_form').on('submit',function() {
			$("#paymentAgree").val($('#paymentAgree_content').html());
		});
		
		$('#classlist').on('change',function() {
			$('#classDescription').data('id',0).val('');
			$("#classDescriptionSubmit").hide(300);
			$("#classDescriptionMessage").text('');
			if(this.value!='0') {
				$.ajaxSetup({
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					}
				});
				$.ajax({
					url: '/ajax/class/description/'+$("#classlist").val(),
					type: 'POST',
					dataType: 'JSON',
					success: function(data) {
						$('#classDescription').data('id',data.id).val(data.description);
						$('#classDescriptionSubmit').show(300);
					},
					error: function(jqXHR, textStatus, errorThrown) {
					}
				});
			}
		});
		$('#description_form').submit(function(e) {
			e.preventDefault();
			if($("classDescription").val()!='') {
				$.ajaxSetup({
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					}
				});
				$.ajax({
					url: '{{route("classDescription")}}',
					type: 'POST',
					data: { id:$("#classDescription").data('id'), description:$("#classDescription").val() },
					dataType: 'HTML',
					success: function(data) {
						$("#classlist").val('0');
						$('#classDescription').data('id',0).val('');
						$("#classDescriptionSubmit").hide(300);
						$("#classDescriptionMessage").text(data);
					},
					error: function(jqXHR, textStatus, errorThrown) {
						$('#classDescription').data('id',0).val('');
						$("#classDescriptionSubmit").hide(300);
						$("#classDescriptionMessage").text('');
					}
				});
			}
		});
	});
</script>
@endsection