<table>
	<thead>
		<tr>
			<th>ID</th>
			<th>Date</th>
			<th>FirstName</th>
			<th>LastName</th>
			<th>Title</th>
			<th>Company</th>
			<th>Address</th>
			<th>City</th>
			<th>State</th>
			<th>Zip</th>
			<th>Email</th>
			<th>Phone</th>
			<th>PayType</th>
			<th>Amount</th>
			<th>Paid</th>
			<th>CardType</th>
			<th>CardNo</th>
			<th>Sponsor</th>
			<th>Option</th>
			<th>IP Address</th>
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