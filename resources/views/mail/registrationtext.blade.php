@extends('layouts.textmail')

@section('content')
	@if(isset($messagestr) && !empty($messagestr))
	{{$messagestr}}

	@endif

{!!strip_tags(str_replace("<br>","\n",getSetting($path.'confirmation','editor')))!!}

---------------------------------------------------------------
Registration Details
---------------------------------------------------------------

	Registration ID: {{$registration->id}}
	Registration Date: {{date('m/d/Y g:i A T')}}
	
	@if($registration->name!='Self Students' && !$individual)
		Company:
		{{$registration->name}}
		{{$registration->address}}
		{{$registration->city}}, {{$registration->state}} {{$registration->zip}}
		
		Company Phone: {{$registration->phone}}
		@if(!empty($registration->contact))
			Contact: {{$registration->contactfname}} {{$registration->contactlname}} ({{$registration->cemail}}  {{$registration->cphone}})
		@endif

		Students:
	@else
		@if($registration->name!='Self Students')
		Company: {{$registration->name}}
		@endif
	@endif
	@if(!$individual)
	@foreach($registration->registrants as $registrant)
	{{$registrant->firstname}} {{$registrant->lastname}}
	{{$registrant->address}}
	{{$registrant->city}} {{$registrant->state}}, {{$registrant->zip}}
	
	Date of Birth: {{date('m/d/Y',$registrant->dob)}}
	Mobile: {{$registrant->mobile}}
	Mobile Carrier: {{$registrant->mobilecarrier}}
	E-mail: {{$registrant->email}}
		
	DAS Registered Apprentice: {{($registrant->das)?'yes':'no'}}
	Building Mass Careers Apprentice Program: {{($registrant->map)?'yes':'no'}}
	
	@if($path=='trade' || $path=='online' || $path=='correspondence')
	{{$registrant->course}}
	Cost: ${{$registrant->fee}}
	@elseif($path=='event' || $path=='training')
	{{$registrant->event}} ({{$registrant->ticket}})
	Cost: ${{$registrant->fee}}
	@endif
	@endforeach
	@else
	{{$registrant->firstname}} {{$registrant->lastname}}
	{{$registrant->address}}
	{{$registrant->city}} {{$registrant->state}}, {{$registrant->zip}}
	
	Date of Birth: {{date('m/d/Y',$registrant->dob)}}
	Mobile: {{$registrant->mobile}}
	Mobile Carrier: {{$registrant->mobilecarrier}}
	E-mail: {{$registrant->email}}
		
	DAS Registered Apprentice: {{($registrant->das)?'yes':'no'}}
	Building Mass Careers Apprentice Program: {{($registrant->map)?'yes':'no'}}
	
	@if($path=='trade' || $path=='online' || $path=='correspondence')
	{{$registrant->course}}
	Cost: ${{$registrant->fee}}
	@elseif($path=='event' || $path=='training')
	{{$registrant->event}} ({{$registrant->ticket}})
	Cost: ${{$registrant->fee}}
	@endif
	@endif

	Payment method: {{$registration->paytype}}
	{{(!is_null($registration->ponum) && !empty($registration->ponum))?"PO Number: ".$registration->ponum:''}}
	
	Subtotal: ${{number_format($registration->total+$registration->discount,2)}}
	Discount: ${{number_format($registration->discount,2)}}
	Total: ${{number_format($registration->total,2)}}
	Amount Due: ${{number_format($registration->due,2)}}
	@if($registration->paid>0)
	Amount Paid: ${{number_format($registration->paid,2)}}
	@endif
	@if($registration->balance!=$registration->total && $registration->balance>0)
	Balance: ${{number_format($registration->balance,2)}}
	@endif
	@if($registration->name!='Self Students' && !$individual)
	Responsible Party: {{$registration->responsible}}
	@endif
@stop