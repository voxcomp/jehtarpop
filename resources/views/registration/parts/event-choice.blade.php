			<div class="card">
				<div class="card-header">Event Choice</div>
	
	            <div class="card-body">
		            @if(isset($errors) && $errors->count() > 0)
		            	<p class="text-danger"><strong>Please select an event and ticket</strong></p>
		            @endif
					{{--
		            @if ($errors->has('event-ticket'))
		                <p><span class="help-block">
		                    <strong>{{ $errors->first('event-ticket') }}</strong>
		                </span></p>
		            @endif
					--}}
		            <div class="row form-group{{ $errors->has('cost') ? ' has-error' : '' }}">
			            <div class="col-sm">
				            <label for="event-name">Select Event:</label>
				            {!! Form::select('event-name',['0'=>'Choose...']+$classes,null,['class'=>'form-control event-name','onchange'=>'getEventTickets()', 'required']) !!}
			            </div>
			            <div class="col-sm">
				            <div class="event-ticket-container" style="display:none;">
					            <label for="event-ticket">Select Ticket:</label>
					            {!! Form::select('event-ticket',[],null,['class'=>'form-control event-ticket','onchange'=>"getEventCost('".$path."')"]) !!}
				            </div>
			            </div>
		            </div>
		            <div class="row">
			            <div class="col text-center">
				            <div class="event-cost-container" style="display:none;">
					            {!! Form::hidden('cost',null,['id'=>'cost']) !!}
					            <p>Cost:<br><strong><span class="event-cost"></span></strong></p>
				            </div>
			            </div>
		            </div>
	            </div>
			</div>
