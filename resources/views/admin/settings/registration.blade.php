@extends('layouts.app')

@section('head')
@endsection

@section('title')
Administration - Registration Settings
@endsection

@section('content')
		<div class="row justify-content-center">
			<div class="col-sm">
				<div class="card">
					<div class="card-header">Registration Status</div>
	
					<div class="card-body">
						{{ html()->form('POST', route('registrationStatus'))->open() }}
						<div class="row">
							<div class="col-sm">
								<div class="form-group">
									<p><strong>Correspondence Class Registration</strong></p>
									{{ html()->radio('correspondenceregistration', $settings['status']->correspondenceregistration ? true : false, 'true') }} Open<br>
									{{ html()->radio('correspondenceregistration', $settings['status']->correspondenceregistration ? false : true, 'false') }} Closed<br><br>
									<label for='correspondencemessage'>Closed Message:</label>
									{{ html()->textarea('correspondencemessage', $settings['status']->correspondencemessage)->class('form-control') }}
								</div>
							</div>
							<div class="col-sm">
								<div class="form-group">
									<p><strong>Online Registration</strong></p>
									{{ html()->radio('onlineregistration', $settings['status']->onlineregistration ? true : false, 'true') }} Open<br>
									{{ html()->radio('onlineregistration', $settings['status']->onlineregistration ? false : true, 'false') }} Closed<br><br>
									<label for='onlinemessage'>Closed Message:</label>
									{{ html()->textarea('onlinemessage', $settings['status']->onlinemessage)->class('form-control') }}
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm">
								<div class="form-group">
									<p><strong>Trade Class Registration</strong></p>
									{{ html()->radio('traderegistration', $settings['status']->traderegistration ? true : false, 'true') }} Open<br>
									{{ html()->radio('traderegistration', $settings['status']->traderegistration ? false : true, 'false') }} Closed<br><br>
									<label for='trademessage'>Closed Message:</label>
									{{ html()->textarea('trademessage', $settings['status']->trademessage)->class('form-control') }}
								</div>
							</div>
							<div class="col-sm">
								<div class="form-group">
									<p><strong>Training Registration</strong></p>
									{{ html()->radio('trainingregistration', $settings['status']->trainingregistration ? true : false, 'true') }} Open<br>
									{{ html()->radio('trainingregistration', $settings['status']->trainingregistration ? false : true, 'false') }} Closed<br><br>
									<label for='trainingmessage'>Closed Message:</label>
									{{ html()->textarea('trainingmessage', $settings['status']->trainingmessage)->class('form-control') }}
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm">
								<div class="form-group">
								<p><strong>Event Registration</strong></p>
								{{ html()->radio('eventregistration', $settings['status']->eventregistration ? true : false, 'true') }} Open<br>
								{{ html()->radio('eventregistration', $settings['status']->eventregistration ? false : true, 'false') }} Closed<br><br>
								<label for='eventmessage'>Closed Message:</label>
								{{ html()->textarea('eventmessage', $settings['status']->eventmessage)->class('form-control') }}
							</div>
							</div>
						</div>
						<div class="form-group">{{ html()->input('submit')->value('Submit')->class('btn btn-primary') }}</div>
						{{ html()->form()->close() }}
					</div>
				</div>
			</div>
		</div>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<div class="row justify-content-center">
			<div class="col-sm">
				<div class="card">
					<div class="card-header">Events/Training Classes</div>
		
					<div class="card-body">
						<p><strong>Check items to mark as an event only:</strong></p>
						{{ html()->form('POST', route('eventsMark'))->open() }}
						<div style="max-height:250px; border:1px solid #999; overflow-y:auto;" class="p-2 mb-1">
							<div class="row">
								@foreach($eventlist as $key=>$event)
								<div class="col-sm-4">
									{{ html()->checkbox('events[]', isset($eventitems[$key]) ? true : false, $key) }} {{$event}}
								</div>
								@endforeach
							</div>
						</div>
						<div class="form-group">{{ html()->input('submit')->value('Mark As Events')->class('btn btn-primary') }}</div>
						{{ html()->form()->close() }}
					</div>
				</div>
			</div>
		</div>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<div class="row justify-content-center">
			<div class="col-sm">
				<div class="card">
					<div class="card-header">In-House Classes</div>
		
					<div class="card-body">
						@if(!empty($customersih))
							<p><strong>Companies marked to show In-House location:</strong><br>
							<span class="help-block">Check items to remove</span></p>
							{{ html()->form('POST', route('customerRemoveInHouse'))->open() }}
							<div style="max-height:150px; border:1px solid #999;overflow-y:auto;" class="p-2 mb-1">
								<div class="row">
									@foreach($customersih as $key=>$customer)
									<div class="col-sm-4">
										{{ html()->checkbox('customers[]', null, $key) }} {{$customer}}
									</div>
									@endforeach
								</div>
							</div>
							<div class="form-group">{{ html()->input('submit')->value('Remove In House')->class('btn btn-primary') }}</div>
							{{ html()->form()->close() }}
							<p>&nbsp;</p>
							<p>&nbsp;</p>
						@endif
						<p><strong>Check companies to add In House location option:</strong></p>
						{{ html()->form('POST', route('customerAddInHouse'))->open() }}
						<div style="max-height:250px; border:1px solid #999; overflow-y:auto;" class="p-2 mb-1">
							<div class="row">
								@foreach($customers as $key=>$customer)
								<div class="col-sm-4">
									{{ html()->checkbox('customers[]', null, $key) }} {{$customer}}
								</div>
								@endforeach
							</div>
						</div>
						<div class="form-group">{{ html()->input('submit')->value('Add In House')->class('btn btn-primary') }}</div>
						{{ html()->form()->close() }}
					</div>
				</div>
			</div>
		</div>
@endsection

@section('footer')
@endsection