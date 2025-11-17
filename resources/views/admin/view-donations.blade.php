@extends('layouts.app')

@section('title')
Administration - Donations
@endsection

@section('content')
	<p><a href="{{route('admin.viewDonations')}}" class="btn btn-primary">Back to dashboard</a></p>
<p>Scroll the table to the right to view all data.</p>
<table class="table table-striped table-responsive">
	<thead>
		<tr>
			<th scope="col">ID</th>
			<th scope="col">Date</th>
			<th scope="col">FirstName</th>
			<th scope="col">LastName</th>
			<th scope="col">Title</th>
			<th scope="col">Company</th>
			<th scope="col">Address</th>
			<th scope="col">City</th>
			<th scope="col">State</th>
			<th scope="col">Zip</th>
			<th scope="col">Email</th>
			<th scope="col">Phone</th>
			<th scope="col">PayType</th>
			<th scope="col">Amount</th>
			<th scope="col">Paid</th>
			<th scope="col">CardType</th>
			<th scope="col">CardNo</th>
			<th scope="col">Sponsor</th>
			<th scope="col">Option</th>
			<th scope="col">IP Address</th>
	</thead>
    <tbody>
	@foreach($donations as $donation)
		<tr>
			<td>{{ $donation->id }}</td>
			<td>{{ date("m/d/Y",strtotime($donation->created_at)) }}</td>
			<td>{{ $donation->fname }}</td>
			<td>{{ $donation->lname }}</td>
			<td>{{ $donation->title }}</td>
			<td>{{ $donation->company }}</td>
			<td>{{ $donation->address }}</td>
			<td>{{ $donation->city }}</td>
			<td>{{ $donation->state }}</td>
			<td>{{ $donation->zip }}</td>
			<td>{{ $donation->email }}</td>
			<td>{{ $donation->phone }}</td>
			<td>{{ $donation->paytype}}</td>
			<td>{{ $donation->amount }}</td>
			<td>{{ $donation->paid }}</td>
			<td>{{ $donation->cardtype}}</td>
			<td>{{ $donation->cardno}}</td>
			<td>{{ ($donation->sponsor)?'Yes':'No' }}</td>
			<td>{{ $donation->options }}</td>
			<td>{{ $donation->clientip }}</td>
		</tr>
	@endforeach
    </tbody>
</table>
@endsection
