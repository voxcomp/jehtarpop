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
						{!!Form::open(array('route'=>'registrationStatus'))!!}
						<div class="row">
							<div class="col-sm">
								<div class="form-group">
									<p><strong>Correspondence Class Registration</strong></p>
									{!!Form::radio('correspondenceregistration','true',($settings['status']->correspondenceregistration)?true:false)!!} Open<br>
									{!!Form::radio('correspondenceregistration','false',($settings['status']->correspondenceregistration)?false:true)!!} Closed<br><br>
									<label for='correspondencemessage'>Closed Message:</label>
									{!!Form::textarea('correspondencemessage',$settings['status']->correspondencemessage,['class'=>'form-control'])!!}
								</div>
							</div>
							<div class="col-sm">
								<div class="form-group">
									<p><strong>Online Registration</strong></p>
									{!!Form::radio('onlineregistration','true',($settings['status']->onlineregistration)?true:false)!!} Open<br>
									{!!Form::radio('onlineregistration','false',($settings['status']->onlineregistration)?false:true)!!} Closed<br><br>
									<label for='onlinemessage'>Closed Message:</label>
									{!!Form::textarea('onlinemessage',$settings['status']->onlinemessage,['class'=>'form-control'])!!}
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm">
								<div class="form-group">
									<p><strong>Trade Class Registration</strong></p>
									{!!Form::radio('traderegistration','true',($settings['status']->traderegistration)?true:false)!!} Open<br>
									{!!Form::radio('traderegistration','false',($settings['status']->traderegistration)?false:true)!!} Closed<br><br>
									<label for='trademessage'>Closed Message:</label>
									{!!Form::textarea('trademessage',$settings['status']->trademessage,['class'=>'form-control'])!!}
								</div>
							</div>
							<div class="col-sm">
								<div class="form-group">
									<p><strong>Training Registration</strong></p>
									{!!Form::radio('trainingregistration','true',($settings['status']->trainingregistration)?true:false)!!} Open<br>
									{!!Form::radio('trainingregistration','false',($settings['status']->trainingregistration)?false:true)!!} Closed<br><br>
									<label for='trainingmessage'>Closed Message:</label>
									{!!Form::textarea('trainingmessage',$settings['status']->trainingmessage,['class'=>'form-control'])!!}
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm">
								<div class="form-group">
								<p><strong>Event Registration</strong></p>
								{!!Form::radio('eventregistration','true',($settings['status']->eventregistration)?true:false)!!} Open<br>
								{!!Form::radio('eventregistration','false',($settings['status']->eventregistration)?false:true)!!} Closed<br><br>
								<label for='eventmessage'>Closed Message:</label>
								{!!Form::textarea('eventmessage',$settings['status']->eventmessage,['class'=>'form-control'])!!}
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
					<div class="card-header">Events/Training Classes</div>
		
					<div class="card-body">
						<p><strong>Check items to mark as an event only:</strong></p>
						{!!Form::open(array('route'=>'eventsMark'))!!}
						<div style="max-height:250px; border:1px solid #999; overflow-y:auto;" class="p-2 mb-1">
							<div class="row">
								@foreach($eventlist as $key=>$event)
								<div class="col-sm-4">
									{!!Form::checkbox('events[]',$key,(isset($eventitems[$key]))?true:false)!!} {{$event}}
								</div>
								@endforeach
							</div>
						</div>
						<div class="form-group">{!!Form::submit('Mark As Events',['class'=>'btn btn-primary'])!!}</div>
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
					<div class="card-header">In-House Classes</div>
		
					<div class="card-body">
						@if(!empty($customersih))
							<p><strong>Companies marked to show In-House location:</strong><br>
							<span class="help-block">Check items to remove</span></p>
							{!!Form::open(array('route'=>'customerRemoveInHouse'))!!}
							<div style="max-height:150px; border:1px solid #999;overflow-y:auto;" class="p-2 mb-1">
								<div class="row">
									@foreach($customersih as $key=>$customer)
									<div class="col-sm-4">
										{!!Form::checkbox('customers[]',$key)!!} {{$customer}}
									</div>
									@endforeach
								</div>
							</div>
							<div class="form-group">{!!Form::submit('Remove In House',['class'=>'btn btn-primary'])!!}</div>
							{!!Form::close()!!}
							<p>&nbsp;</p>
							<p>&nbsp;</p>
						@endif
						<p><strong>Check companies to add In House location option:</strong></p>
						{!!Form::open(array('route'=>'customerAddInHouse'))!!}
						<div style="max-height:250px; border:1px solid #999; overflow-y:auto;" class="p-2 mb-1">
							<div class="row">
								@foreach($customers as $key=>$customer)
								<div class="col-sm-4">
									{!!Form::checkbox('customers[]',$key)!!} {{$customer}}
								</div>
								@endforeach
							</div>
						</div>
						<div class="form-group">{!!Form::submit('Add In House',['class'=>'btn btn-primary'])!!}</div>
						{!!Form::close()!!}
					</div>
				</div>
			</div>
		</div>
@endsection

@section('footer')
@endsection