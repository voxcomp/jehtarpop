<table>
	<thead>
		<tr>
			<th>WebRegID</th>
			<th>WebRegType</th>
			<th>AccessEventID</th>
			<th>EventName</th>
			<th>RegDate</th>
			<th>AccessCOID</th>
			<th>EnterCompany</th>
			<th>EnterFirstName</th>
			<th>EnterLastName</th>
			<th>EnterEmail</th>
			<th>EnterPhone</th>
			<th>RegFirstName</th>
			<th>RegLastName</th>
			<th>RegEmail</th>
			<th>RegPhone</th>
			<th>RegCompany</th>
			<th>AccessTicketID</th>
			<th>TicketName</th>
			<th>TicketPrice</th>
			<th>TicketNum</th>
			<th>TicketTotal</th>
			<th>PaidStatus</th>
			<th>PaidType</th>
			<th>PayeeType</th>
			<th>PayeeFirstName</th>
			<th>PayeeLastName</th>
			<th>PayeeEmail</th>
			<th>PayeeCompany</th>
			<th>Misc</th>
	</thead>
    <tbody>
    @foreach($registrations as $registration)
            @foreach($registration->registrants as $registrant)
        <tr>
	            <td>{{ $registration->id }}{{ $registrant->id }}</td>
	            <td>Event</td>
	            <td>{{ $registrant->event_id }}</td>
	            <td>{{ $registrant->event }}</td>
				<td>{{ date("m/d/Y",strtotime($registration->created_at)) }}</td>
				<td></td>
				<td>{{ $registration->name }}</td>
	            <td>{{ $registrant->contactfname }}</td>
	            <td>{{ $registrant->contactlname }}</td>
	            <td>{{ $registration->cemail }}</td>
	            <td>{{ str_replace(["-","(",")"],["","",""],$registration->cphone) }}</td>
	            <td>{{ $registrant->firstname }}</td>
	            <td>{{ $registrant->lastname }}</td>
	            <td>{{ $registrant->email }}</td>
	            <td>{{ str_replace(["-","(",")"],["","",""],$registrant->mobile) }}</td>
	            <td>{{ $registration->name }}</td>
	            <td>{{ $registrant->ticket_id }}</td>
	            <td>{{ $registrant->ticket }}</td>
	            <td>{{ $registrant->fee }}</td>
	            <td>1</td>
	            <td>{{ $registrant->fee }}</td>
				<td>{{ ($registration->paytype=="credit")?'P':'O' }}</td>
	            <td>{{$registration->paytype}}</td>
				<td></td>
				<td>{{ (isset($registration->payment->firstname))?$registration->payment->firstname:$registrant->firstname }}</td>
				<td>{{ (isset($registration->payment->lastname))?$registration->payment->lastname:$registrant->lastname }}</td>
	            <td>{{ (!empty($registration->cemail))?$registration->cemail:$registrant->email }}</td>
				<td>{{ $registration->name }}</td>
				<td></td>
        </tr>
            @endforeach
    @endforeach
    </tbody>
</table>