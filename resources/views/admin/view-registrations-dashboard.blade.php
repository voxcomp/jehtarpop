@extends('layouts.app')

@section('title')
Administration - View Registrations
@endsection

@section('content')
	    <div class="row justify-content-center">
		    <div class="col-sm">
	            <div class="card">
	                <div class="card-header">View Trade Class Registrations</div>
	
	                <div class="card-body">
						{!!Form::open(array('route'=>'viewRegistrations'))!!}
						{!!Form::hidden('regtype',\Crypt::encrypt('trade'))!!}
						<div class="row">
							<div class="col-sm">
								<div class="form-group"><label>Start Date</label>{!!Form::text('start', null, ['class'=>'form-control datepicker','required'])!!}</div>
					            @if ($errors->has('start'))
					                <span class="help-block">
					                    <strong>{{ $errors->first('start') }}</strong>
					                </span>
					            @endif
							</div>
							<div class="col-sm">
								<div class="form-group"><label>End Date</label>{!!Form::text('end', null, ['class'=>'form-control datepicker','required'])!!}</div>
					            @if ($errors->has('end'))
					                <span class="help-block">
					                    <strong>{{ $errors->first('end') }}</strong>
					                </span>
					            @endif
							</div>
						</div>
						<div class="form-group">
							{!!Form::checkbox("hold",1)!!} Show only registrations on <strong>hold</strong>
						</div>
						<div class="form-group"><label>&nbsp;</label>{!!Form::submit('View',['class'=>'btn btn-danger'])!!}</div>
						{!!Form::close()!!}
	                </div>
	            </div>
		    </div>
		    <div class="col-sm">
	            <div class="card">
	                <div class="card-header">View Event Registrations</div>
	
	                <div class="card-body">
						{!!Form::open(array('route'=>'viewRegistrations'))!!}
						{!!Form::hidden('regtype',\Crypt::encrypt('event'))!!}
						<div class="row">
							<div class="col-sm">
								<div class="form-group"><label>Start Date</label>{!!Form::text('start', null, ['class'=>'form-control datepicker','required'])!!}</div>
					            @if ($errors->has('start'))
					                <span class="help-block">
					                    <strong>{{ $errors->first('start') }}</strong>
					                </span>
					            @endif
							</div>
							<div class="col-sm">
								<div class="form-group"><label>End Date</label>{!!Form::text('end', null, ['class'=>'form-control datepicker','required'])!!}</div>
					            @if ($errors->has('end'))
					                <span class="help-block">
					                    <strong>{{ $errors->first('end') }}</strong>
					                </span>
					            @endif
							</div>
						</div>
						<div class="form-group">
							{!!Form::checkbox("hold",1)!!} Show only registrations on <strong>hold</strong>
						</div>
						<div class="form-group"><label>&nbsp;</label>{!!Form::submit('View',['class'=>'btn btn-danger'])!!}</div>
						{!!Form::close()!!}
	                </div>
	            </div>
		    </div>
	    </div>
	    <p>&nbsp;</p>
	    <div class="row justify-content-center">
		    <div class="col-sm">
	            <div class="card">
	                <div class="card-header">View Correspondence Class Registrations</div>
	
	                <div class="card-body">
						{!!Form::open(array('route'=>'viewRegistrations'))!!}
						{!!Form::hidden('regtype',\Crypt::encrypt('correspondence'))!!}
						<div class="row">
							<div class="col-sm">
								<div class="form-group"><label>Start Date</label>{!!Form::text('start', null, ['class'=>'form-control datepicker','required'])!!}</div>
					            @if ($errors->has('start'))
					                <span class="help-block">
					                    <strong>{{ $errors->first('start') }}</strong>
					                </span>
					            @endif
							</div>
							<div class="col-sm">
								<div class="form-group"><label>End Date</label>{!!Form::text('end', null, ['class'=>'form-control datepicker','required'])!!}</div>
					            @if ($errors->has('end'))
					                <span class="help-block">
					                    <strong>{{ $errors->first('end') }}</strong>
					                </span>
					            @endif
							</div>
						</div>
						<div class="form-group">
							{!!Form::checkbox("hold",1)!!} Show only registrations on <strong>hold</strong>
						</div>
						<div class="form-group"><label>&nbsp;</label>{!!Form::submit('View',['class'=>'btn btn-danger'])!!}</div>
						{!!Form::close()!!}
	                </div>
	            </div>
		    </div>
		    <div class="col-sm">
	            <div class="card">
	                <div class="card-header">View Online Class Registrations</div>
	
	                <div class="card-body">
						{!!Form::open(array('route'=>'viewRegistrations'))!!}
						{!!Form::hidden('regtype',\Crypt::encrypt('online'))!!}
						<div class="row">
							<div class="col-sm">
								<div class="form-group"><label>Start Date</label>{!!Form::text('start', null, ['class'=>'form-control datepicker','required'])!!}</div>
					            @if ($errors->has('start'))
					                <span class="help-block">
					                    <strong>{{ $errors->first('start') }}</strong>
					                </span>
					            @endif
							</div>
							<div class="col-sm">
								<div class="form-group"><label>End Date</label>{!!Form::text('end', null, ['class'=>'form-control datepicker','required'])!!}</div>
					            @if ($errors->has('end'))
					                <span class="help-block">
					                    <strong>{{ $errors->first('end') }}</strong>
					                </span>
					            @endif
							</div>
						</div>
						<div class="form-group">
							{!!Form::checkbox("hold",1)!!} Show only registrations on <strong>hold</strong>
						</div>
						<div class="form-group"><label>&nbsp;</label>{!!Form::submit('View',['class'=>'btn btn-danger'])!!}</div>
						{!!Form::close()!!}
	                </div>
	            </div>
		    </div>
	    </div>
		<p>&nbsp;</p>
		<div class="row">
			<div class="col-sm-6">
				<div class="card">
					<div class="card-header">View Training Registrations</div>
			
					<div class="card-body">
						{!!Form::open(array('route'=>'viewRegistrations'))!!}
						{!!Form::hidden('regtype',\Crypt::encrypt('training'))!!}
						<div class="row">
							<div class="col-sm">
								<div class="form-group"><label>Start Date</label>{!!Form::text('start', null, ['class'=>'form-control datepicker','required'])!!}</div>
								@if ($errors->has('start'))
									<span class="help-block">
										<strong>{{ $errors->first('start') }}</strong>
									</span>
								@endif
							</div>
							<div class="col-sm">
								<div class="form-group"><label>End Date</label>{!!Form::text('end', null, ['class'=>'form-control datepicker','required'])!!}</div>
								@if ($errors->has('end'))
									<span class="help-block">
										<strong>{{ $errors->first('end') }}</strong>
									</span>
								@endif
							</div>
						</div>
						<div class="form-group">
							{!!Form::checkbox("hold",1)!!} Show only registrations on <strong>hold</strong>
						</div>
						<div class="form-group"><label>&nbsp;</label>{!!Form::submit('View',['class'=>'btn btn-danger'])!!}</div>
						{!!Form::close()!!}
					</div>
				</div>
			</div>
		</div>
@endsection