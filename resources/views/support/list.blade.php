@extends('layouts.app')

@section('title')
Administration - Support Tickets
@endsection

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-sm-8">
		@if($tickets->where('status','<>','closed')->where('visitor',1)->count())
			<div class="mb-4">
				<h2><i class="fas fa-user"></i> Open Visitor Issues</h2>
				<table class="table table-striped">
					@foreach($tickets->where('status','<>','closed')->where('visitor',1) as $ticket)
						<tr><td><a href="{{route('support.detail',$ticket->id)}}">{!!$ticket->light!!} <strong>{{date_format($ticket->created_at,'m/d/y h:i a')}}</strong> &nbsp; {{$ticket->title}}</a></td></tr>
					@endforeach
				</table>
			</div>
		@endif
		@if($tickets->where('status','<>','closed')->where('visitor',0)->count())
			<div class="mb-4">
				<h2><i class="fas fa-users-cog"></i> Open Admin Issues</h2>
				<table class="table table-striped">
					@foreach($tickets->where('status','<>','closed')->where('visitor',0) as $ticket)
						<tr><td><a href="{{route('support.detail',$ticket->id)}}">{!!$ticket->light!!} <strong>{{date_format($ticket->created_at,'m/d/y h:i a')}}</strong> &nbsp; {{$ticket->title}}</a></td></tr>
					@endforeach
				</table>
			</div>
		@endif
		@if($tickets->where('status','closed')->count())
			<div class="mb-4">
				<div id="accordion">
					<div class="card">
						<div class="card-header" id="headingOne">
							<h5 class="mb-0">
								<button class="btn btn-link" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
								<i class="fas fa-window-close"></i> Closed (archived) Issues
								</button>
							</h5>
						</div>
					
						<div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
							<div class="card-body">
								<table class="table table-striped">
									@foreach($tickets->where('status','closed') as $ticket)
										<tr><td><a href="{{route('support.detail',$ticket->id)}}">{!!$ticket->light!!} <strong>{{date_format($ticket->created_at,'m/d/y h:i a')}}</strong> &nbsp; {{$ticket->title}}</a></td></tr>
									@endforeach
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		@endif
			</div>
			<div class="col-sm">
				<h3 class="text-center">Create New Support Ticket</h3>
				<p>Files and notes can be added after the ticket is created.</p>
				{!! Form::open(array('route' => ['support.create'])) !!}
					<div class="mb-2{{ $errors->has('title') ? ' has-error' : '' }}">
						{!! Form::label('title', 'Please give your issue a title:', ['class'=>'form-label']) !!}
						{!! Form::text('title', old('title'), ['id'=>'title', 'class'=>'form-control','required','autocomplete'=>'nope']) !!}
						@if ($errors->has('title'))
							<span class="help-block">
								<strong>{{ $errors->first('title') }}</strong>
							</span>
						@endif
					</div>
					<div class="mb-2{{ $errors->has('description') ? ' has-error' : '' }}">
						{!! Form::label('description', 'Please describe the issue that was encountered in as much detail as possible:', ['class'=>'form-label']) !!}
						{!! Form::textarea('description', old('description'), ['id'=>'description', 'class'=>'form-control','required','autocomplete'=>'nope']) !!}
						@if ($errors->has('description'))
							<span class="help-block">
								<strong>{{ $errors->first('description') }}</strong>
							</span>
						@endif
					</div>
					<div class="mb-2">
						{!! Form::label('email', 'Ticket Contacts', ['class'=>'form-label']) !!}
						{!! Form::text('email', old('email',getSetting('ADMIN_EMAIL','general').','.env("SUPPORT_EMAIL")), ['id'=>'email','class'=>'form-control']) !!}
						<div class="help-block">
							Notified on status change and new notes.  Comma separate multiple addresses.
						</div>
					</div>
					<div class="text-right">
						{!! Form::submit('Create',['class'=>'btn btn-primary']) !!}
					</div>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
@endsection