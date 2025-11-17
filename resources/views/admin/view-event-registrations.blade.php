@extends('layouts.app')

@section('title')
Administration - Registrations
@endsection

@section('content')
	<p><a href="{{route('admin.viewRegistrations')}}" class="btn btn-primary">Back to dashboard</a></p>
<p>Scroll the table to the right to view all data.</p>
<table class="table table-striped table-responsive">
	<thead>
		<tr>
			<th scope="col">WebRegID</th>
			<th scope="col">EventName</th>
			<th scope="col">Date</th>
			<th scope="col">Company</th>
			<th scope="col">Contact First Name</th>
			<th scope="col">Contact Last Name</th>
			<th scope="col">Contact E-mail</th>
			<th scope="col">Contact Phone</th>
			<th scope="col">First Name</th>
			<th scope="col">Last Name</th>
			<th scope="col">E-mail</th>
			<th scope="col">Phone</th>
			<th scope="col">MAP</th>
			<th scope="col">DAS</th>
			<th scope="col">Ticket</th>
			<th scope="col">Total</th>
			<th scope="col">Paid Status</th>
			<th scope="col">Pay Type</th>
			<th scope="col">Payee First Name</th>
			<th scope="col">Payee Last Name</th>
			<th scope="col">Payee E-mail</th>
			<th scope="col">Payee Company</th>
			<th scope="col">Party Responsible</th>
	</thead>
    <tbody>
    @foreach($registrations as $registration)
            @foreach($registration->registrants as $registrant)
        <tr>
	            <td>{{ $registration->id }}{{ $registrant->id }}</td>
	            <td>{{ $registrant->event }}</td>
				<td>{{ date("m/d/Y",strtotime($registration->created_at)) }}</td>
				<td>{{ $registration->name }}</td>
	            <td>{{ $registrant->contactfname }}</td>
	            <td>{{ $registrant->contactlname }}</td>
	            <td>{{ $registration->cemail }}</td>
	            <td>{{ str_replace("-","",$registration->cphone) }}</td>
	            <td>{{ $registrant->firstname }}</td>
	            <td>{{ $registrant->lastname }}</td>
	            <td>{{ $registrant->email }}</td>
	            <td>{{ str_replace("-","",$registrant->mobile) }}</td>
	            <td>{{ ($registrant->map)?'yes':'no' }}</td>
	            <td>{{ ($registrant->das)?'yes':'no' }}</td>
	            <td>{{ $registrant->ticket }}</td>
	            <td>${{ $registrant->fee }}</td>
				<td>{{ ($registration->paytype=="credit")?'P':'O' }}</td>
	            <td>{{$registration->paytype}}</td>
				<td>{{ (isset($registration->payment->firstname))?$registration->payment->firstname:$registrant->firstname }}</td>
				<td>{{ (isset($registration->payment->lastname))?$registration->payment->lastname:$registrant->lastname }}</td>
	            <td>{{ (!empty($registration->cemail))?$registration->cemail:$registrant->email }}</td>
				<td>{{ $registration->name }}</td>
				<td>{{ $registration->responsible }}</td>
        </tr>
            @endforeach
    @endforeach
    </tbody>
</table>
@endsection
