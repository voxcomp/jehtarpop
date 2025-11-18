@extends('layouts.app')

@section('title')
Administration - View Donations
@endsection

@section('content')
	    <div class="row justify-content-center">
		    <div class="col-sm">
	            <div class="card">
	                <div class="card-header">View Donations</div>
	
	                <div class="card-body">
						{{ html()->form('POST', route('admin.viewDonations'))->open() }}
						<div class="row">
							<div class="col-sm">
								<div class="form-group"><label>Start Date</label>{{ html()->text('start')->class('form-control datepicker')->required() }}</div>
					            @if ($errors->has('start'))
					                <span class="help-block">
					                    <strong>{{ $errors->first('start') }}</strong>
					                </span>
					            @endif
							</div>
							<div class="col-sm">
								<div class="form-group"><label>End Date</label>{{ html()->text('end')->class('form-control datepicker')->required() }}</div>
					            @if ($errors->has('end'))
					                <span class="help-block">
					                    <strong>{{ $errors->first('end') }}</strong>
					                </span>
					            @endif
							</div>
						</div>
						<div class="form-group">
							{{ html()->checkbox("hold", null, 1) }} Show only donations on <strong>hold</strong>
						</div>
						<div class="form-group"><label>&nbsp;</label>{{ html()->input('submit')->value('View')->class('btn btn-danger') }}</div>
						{{ html()->form()->close() }}
	                </div>
	            </div>
		    </div>
	    </div>
@endsection