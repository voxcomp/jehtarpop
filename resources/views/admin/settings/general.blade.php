@extends('layouts.app')

@section('head')
@endsection

@section('title')
Administration - General Settings
@endsection

@section('content')
		<div class="row justify-content-center">
			<div class="col-sm">
				<div class="card">
					<div class="card-header">Fundraising</div>
		
					<div class="card-body">
						{{ html()->form('POST', route('fundraising'))->open() }}
						<div class="row">
							<div class="col-sm">
								<div class="form-group">
									<label for='fund_goal'>Funding Goal:</label>
									{{ html()->text('fund_goal', $settings['donation']->fund_goal)->class('form-control') }}
								</div>
								<div class="form-group">
									<label for='fund_goal'>Require check payment amount:</label>
									{{ html()->text('payment_limit', $settings['donation']->payment_limit)->class('form-control') }}
								</div>
								<div class="form-group">{{ html()->input('submit')->value('Submit')->class('btn btn-primary') }}</div>
								<table class="table table-striped">
									<thead>
										<tr>
											<th>Option</th>
											<th>Available</th>
											<th>Sold</th>
											<th>Price</th>
										</tr>
									</thead>
									<tbody>
										@foreach($sponsoritems as $opt)
										<tr>
											<td>{{$opt->name}}</td>
											<td>{{$opt->qty}}</td>
											<td>{{$opt->sold}}</td>
											<td>${{$opt->price}}</td>
										</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						</div>
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
					<div class="card-header">Administrator Email</div>
	
					<div class="card-body">
						{{ html()->form('POST', route('adminEmail'))->open() }}
						<div class="row">
							<div class="col-sm">
								<div class="form-group">
									<label for='adminemail'>Administrator Email List:</label>
									{{ html()->text('ADMIN_EMAIL', $settings['general']->ADMIN_EMAIL)->class('form-control') }}
									<div class="help-block">Use a comma separated list for multiple addresses</div>
								</div>
								{{--
								<div class="form-group">
									<label for='adminemail2'>Second Administrator Email:</label>
									{{ html()->text('ADMIN_EMAIL2', $settings['general']->ADMIN_EMAIL2)->class('form-control') }}
								</div>
								--}}
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
					<div class="card-header">Authorize.net API</div>
	
					<div class="card-body">
						{{ html()->form('POST', route('adminAPI'))->open() }}
						<div class="row">
							<div class="col-sm">
								<div class="form-group">
									<label for='adminemail'>API Login:</label>
									{{ html()->text('api_login', $settings['api']->api_login)->class('form-control') }}
								</div>
								<div class="form-group">
									<label for='adminemail2'>Transaction Key:</label>
									{{ html()->text('transaction_key', $settings['api']->transaction_key)->class('form-control') }}
								</div>
							</div>
						</div>
						<div class="form-group">{{ html()->input('submit')->value('Submit')->class('btn btn-primary') }}</div>
						{{ html()->form()->close() }}
					</div>
				</div>
			</div>
		</div>
@endsection

@section('footer')
@endsection