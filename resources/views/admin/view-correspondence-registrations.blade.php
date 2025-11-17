@extends('layouts.app')

@section('title')
Administration - Correspondence Registrations
@endsection

@section('content')
	<p><a href="{{route('admin.viewRegistrations')}}" class="btn btn-primary">Back to dashboard</a></p>
<p>Scroll the table to the right to view all data.</p>
<table class="table table-striped table-responsive">
	<thead>
		<tr>
			<th scope="col">Web ID</th>
			<th scope="col">NumReg</th>
			<th scope="col">Date</th>
			<th scope="col">First Name</th>
			<th scope="col">Last Name</th>
			<th scope="col">DOB</th>
			<th scope="col">Address</th>
			<th scope="col">City</th>
			<th scope="col">State</th>
			<th scope="col">Zip</th>
			<th scope="col">E-mail</th>
			<th scope="col">Mobile</th>
			<th scope="col">Carrier</th>
			<th scope="col">MAP</th>
			<th scope="col">DAS</th>
			<th scope="col">Program</th>
			<th scope="col">Location</th>
			<th scope="col">Correspondence</th>
			<th scope="col">Trade</th>
			<th scope="col">Course</th>
			<th scope="col">Fee</th>
			<th scope="col">CompanyID</th>
			<th scope="col">Company</th>
			<th scope="col">Phone</th>
			<th scope="col">Address</th>
			<th scope="col">City</th>
			<th scope="col">State</th>
			<th scope="col">Zip</th>
			<th scope="col">Contact</th>
			<th scope="col">Phone</th>
			<th scope="col">E-mail</th>
			<th scope="col">Registration Type</th>
			<th scope="col">Member</th>
			<th scope="col">Payment</th>
			<th scope="col">Due</th>
			<th scope="col">Paid</th>
			<th scope="col">Balance</th>
			<th scope="col">Party Responsible</th>
			<th scope="col">Card Last 4</th>
			<th scope="col">Card Type</th>
			<th scope="col">PO Number</th>
			<th scope="col">SchoolYear</th>
	</thead>
    <tbody>
    @foreach($registrations as $registration)
            @foreach($registration->registrants as $registrant)
        <tr>
	            <td>{{ $registration->id }}</td>
	            <td>{{ $registrant->id }}</td>
				<td>{{ date("m/d/Y",strtotime($registration->created_at)) }}</td>
	            <td>{{ $registrant->firstname }}</td>
	            <td>{{ $registrant->lastname }}</td>
	            <td>{{ date("m/d/Y",$registrant->dob) }}</td>
	            <td>{{ $registrant->address }}</td>
	            <td>{{ $registrant->city }}</td>
	            <td>{{ $registrant->state }}</td>
	            <td>{{ $registrant->zip }}</td>
	            <td>{{ $registrant->email }}</td>
	            <td>{{ str_replace("-","",$registrant->mobile) }}</td>
	            <td>{{ $registrant->mobilecarrier }}</td>
	            <td>{{ ($registrant->map)?'yes':'no' }}</td>
	            <td>{{ ($registrant->das)?'yes':'no' }}</td>
	            <td>Correspondence</td>
	            <td></td>
	            <td></td>
				<td>{{ $registrant->program }}</td>
	            <td>{{ $registrant->course }}</td>
	            <td>${{ $registrant->fee }}</td>
	            <td>{{ $registration->coid }}</td>
	            <td>{{ $registration->name }}</td>
	            <td>{{ str_replace("-","",$registration->phone) }}</td>
	            <td>{{ $registration->address }}</td>
	            <td>{{ $registration->city }}</td>
	            <td>{{ $registration->state }}</td>
	            <td>{{ $registration->zip }}</td>
	            <td>{{ $registration->contact }}</td>
	            <td>{{ str_replace("-","",$registration->cphone) }}</td>
	            <td>{{ $registration->cemail }}</td>
	            @if($registration->name=="Self Students")
	            	<td>I</td>
	            @else
	            	<td>C</td>
	            @endif
	            <td>{{ ($registration->member)?'true':'false' }}</td>
	            <td>{{$registration->paytype}}</td>
	            <td>{{$registration->due}}</td>
	            <td>{{$registration->paid}}</td>
	            <td>{{$registration->balance}}</td>
	            <td>{{$registration->responsible}}</td>
	            <td>{{$registration->cardno}}</td>
	            <td>{{$registration->cardtype}}</td>
	            <td>{{$registration->ponum}}</td>
	            <td>{{$registrant->schoolyear}}</td>
        </tr>
            @endforeach
    @endforeach
    </tbody>
</table>
@endsection
