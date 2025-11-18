@extends('layouts.app')

@section('title')
Administration - Support Ticket Detail
@endsection

@section('content')
<div class="row">
	<div class="col">
		<h3><a href="{{route('support.list')}}"><i class="fas fa-chevron-circle-left"></i> View All Support Tickets</a></h3>
	</div>
	<div class="col text-right">
		{{ html()->form('POST', route('support.delete', $ticket->id))->id('delete_ticket')->open() }}
		{{ html()->form()->close() }}
		<a href="#" class="btn btn-danger" onclick="SubmitConfirmDialog('Delete this support ticket permanently?','Delete Ticket',$('#delete_ticket'))">Delete Ticket</a>
	</div>
</div>
<div class="card">
	<div class="card-header" id="heading{{$ticket->id}}">
			{!!$ticket->light!!} {{date_format($ticket->created_at,'m/d/y h:i a')}} {{$ticket->title}}
	</div>

		<div class="card-body">
			<div class="row">
				<div class="col-sm-8 mb-3 p-3">
					<div class="mb-3 p-3">
						<h3>Description:</h3>
						{!! nl2br($ticket->description) !!}
					</div>
					@if(!empty($ticket->contactname))
						<div class="mb-3 p-3 bg-light">
							<h3>Registration Contact:</h3>
							<p><strong>Name:</strong> {{$ticket->contactname}}<br>
							<strong>Phone:</strong> {{$ticket->contactphone}}<br>
							<strong>Email:</strong> <a href="mailto:{{$ticket->contactemail}}">{{$ticket->contactemail}}</a></p>
						</div>
					@endif
					<div class="mb-3 p-3">
						<h3>Issue Contact Emails:</h3>
						{{ html()->form('POST', route('support.email.save', $ticket->id))->open() }}
							{{ html()->label('Email Addresses:', 'email')->class('form-label') }}
							{{ html()->text('email', old('email', $ticket->email))->class('form-control')->required() }}<br>
							{{ html()->input('submit')->value('Save')->class('btn btn-warning') }}
						{{ html()->form()->close() }}
					</div>
					@if(!empty($ticket->registration))
						<?php $register = unserialize($ticket->registration); ?>
						<div class="card">
							<div class="card-header">
								<h4>Temporary Registration Details</h4>
							</div>
							<div class="card-body">
								<h4>Company:</h4>
								<p><strong>{{$register['name']}}</strong><br>{{$register['address']}}<br>{{$register['city']}}, {{$register['state']}} {{$register['zip']}}</p>
								<p>{{$register['phone']}}</p>
								<p>&nbsp;</p>
								<h4>Registrants:</h4>
								<?php $cost = 0; ?>
								@foreach($register['registrants'] as $key=>$registrant)
								<p style="line-height:1em;">{{$registrant['firstname']}} {{$registrant['lastname']}}<br><small>{{$registrant['class']}}<br>Cost: ${{$registrant['cost']}}</small></p>
								<?php $cost += $registrant['cost']; ?>
								@endforeach
								<p>&nbsp;</p>
								<h5>Total Cost: <strong>${{number_format($cost,2)}}</strong></h5>
							</div>
						</div>
					@endif
					@if(!empty($ticket->record))
						<div class="card">
							<div class="card-header">
								<h4>Saved (On Hold) Registration Details</h4>
							</div>
							<div class="card-body">
								@if($ticket->record->name!='Self Students')
								<h4>Company:</h4>
								<p><strong>{{$ticket->record->name}}</strong><br>{{$ticket->record->address}}<br>{{$ticket->record->city}}, {{$ticket->record->state}} {{$ticket->record->zip}}</p>
								<p>{{$ticket->record->phone}}</p>
								<p>&nbsp;</p>
								<h4>Party Responsible for Payment:</h4>
								<p>{{$ticket->record->responsible}}
								@endif
								<?php $payment = $ticket->record->payment()->where('payment_status','hold')->first(); ?>
								@if(!empty($payment))
									<h4>Billing:</h4>
									<p>
										@if(isset($payment->fname))
											<strong>{{$payment->fname}} {{$payment->lname}}</strong><br>
										@else
											<strong>{{$payment->firstname}} {{$payment->lastname}}</strong><br>
										@endif
										{{$payment->address}}<br>{{$payment->city}}, {{$payment->state}} {{$payment->zip}}</p>
									<p>&nbsp;</p>
								@endif
								@if($ticket->record->name!='Self Students')
								<h4>Registrants:</h4>
								@endif
								@foreach($ticket->record->registrants as $registrant)
								<p style="line-height:1em;">{{$registrant->firstname}} {{$registrant->lastname}}<br>
								@if(empty($registrant->course))
									<small>{{$registrant->event}}  ({{$registrant->ticket}})<br>
								@else
									<small>{{$registrant->course}}<br>
								@endif
								Cost: ${{$registrant->fee}}</small></p>
								@endforeach
								<p>&nbsp;</p>
								<h5 class="text-dark">SubTotal: <strong>$<span class="subtotal">{{number_format($ticket->record->total,2)}}</span></strong></h5>
								<h5 class="text-dark">Discount: <strong>$<span class="discount">{{number_format($ticket->record->discount,2)}}</span></strong></h5>
								<h4 class="text-danger">Total Due: <strong>$<span class="total">{{number_format($ticket->record->due,2)}}</span></strong></h4>
							</div>
						</div>
					@endif
				</div>
				<div class="col-sm-4 mb-3">
					<div class="mb-3 p-3 bg-light">
						<h3>Issue Status:</h3>
						{{ html()->form('POST', route('support.status', $ticket->id))->id('status_form')->open() }}
							{{ html()->label('Status', 'status')->class('form-label') }}
							{{ html()->radio('status', $ticket->status == 'open' ? true : false, 'open')->attribute('onchange', 'this.form.submit()') }} Open<br>
							{{ html()->radio('status', $ticket->status == 'working' ? true : false, 'working')->attribute('onchange', 'this.form.submit()') }} In Progress<br>
							{{ html()->radio('status', $ticket->status == 'closed' ? true : false, 'closed')->attribute('onchange', 'this.form.submit()') }} Closed
						{{ html()->form()->close() }}
					</div>
					<div class="mb-3 p-3">
						<h3>Issue Notes:</h3>
						<div class="mb-3">
							@foreach($ticket->notes as $note)
								<div class="row align-items-center">
									<div class="col-sm-1">
										{{ html()->form('POST', route('support.note.delete', $note->id))->id('delete_note' . $note->id)->open() }}
										{{ html()->form()->close() }}
										<a href="#" class="text-danger" onclick="SubmitConfirmDialog('Delete note permanently?','Delete Note',$('#delete_note{{$note->id}}'))"><i class="fas fa-trash-alt"></i></a>
									</div>
									<div class="col-sm-3">
										{{date_format($note->created_at,'m/d')}}<br>
										{{date_format($note->created_at,'h:i a')}}
									</div>
									<div class="col-sm">
										{!!nl2br($note->description)!!}
									</div>
								</div>
							@endforeach
						</div>
						{{ html()->form('POST', route('support.note.save', $ticket->id))->open() }}
							{{ html()->label('New Note:', 'note')->class('form-label') }}
							{{ html()->textarea('note', old('note'))->required() }}<br>
							{{ html()->input('submit')->value('Save Note')->class('btn btn-warning') }}
						{{ html()->form()->close() }}
					</div>
					<div class="mb-3 p-3 bg-light">
						<h3>Attached Files:</h3>
						<div class="mb-3">
							@foreach($ticket->files as $file)
								<div class="row align-items-center">
									<div class="col-sm-1">
										{{ html()->form('POST', route('support.delete.file', $file->id))->id('delete_file' . $file->id)->open() }}
										{{ html()->form()->close() }}
										<a href="#" class="text-danger" onclick="SubmitConfirmDialog('Delete {{$file->original}} permanently?','Delete File',$('#delete_file{{$file->id}}'))"><i class="fas fa-trash-alt"></i></a>
									</div>
									<div class="col-sm-3">
										{{date_format($file->created_at,'m/d')}}<br>
										{{date_format($file->created_at,'h:i a')}}
									</div>
									<div class="col-sm">
										<a href="{{route('support.download',$file->id)}}">{{$file->original}}</a>
									</div>
								</div>
							@endforeach
						</div>
						{{ html()->form('POST', route('support.upload', $ticket->id))->acceptsFiles()->open() }}
							<div class="mb-2">
								{{ html()->file('document', ['required'])->attributes(null) }}
							</div>
							{{ html()->input('submit')->value('Upload')->class('btn btn-warning') }}
						{{ html()->form()->close() }}
					</div>
				</div>
			</div>
	</div>
</div>
@endsection