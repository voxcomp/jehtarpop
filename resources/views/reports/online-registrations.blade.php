<table>
	<thead>
		<tr>
			<th>WebID</th>
			<th>NumReg</th>
			<th>RegDate</th>
			<th>FirstName</th>
			<th>LastName</th>
			<th>DOB</th>
			<th>MailAddress</th>
			<th>MailCity</th>
			<th>MailState</th>
			<th>MailZip</th>
			<th>StudentEmail</th>
			<th>StudentMobile</th>
			<th>StudentMobileCarrier</th>
			<th>Program</th>
			<th>Location</th>
			<th>Correspondence</th>
			<th>Trade</th>
			<th>Course</th>
			<th>Fee</th>
			<th>CompanyID</th>
			<th>Company</th>
			<th>CoPhone</th>
			<th>CoAddress</th>
			<th>CoCity</th>
			<th>CoState</th>
			<th>CoZip</th>
			<th>CoContact</th>
			<th>CoContactPhone</th>
			<th>CoContactEmail</th>
			<th>RegType</th>
			<th>CoMemberTrueFalse</th>
			<th>NeedProof</th>
			<th>PayType</th>
			<th>AmountDue</th>
			<th>AmountPaid</th>
			<th>Balance</th>
			<th>CardLast4</th>
			<th>CardType</th>
			<th>PONumber</th>
			<th>SchoolYear</th>
			<th>Responsible</th>
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
	            <td>{{ ($registrant->dob!=0)?date("m/d/Y",$registrant->dob):'' }}</td>
	            <td>{{ $registrant->address }}</td>
	            <td>{{ $registrant->city }}</td>
	            <td>{{ $registrant->state }}</td>
	            <td>{{ $registrant->zip }}</td>
	            <td>{{ $registrant->email }}</td>
	            <td>{{ str_replace(["-","(",")"],["","",""],$registrant->mobile) }}</td>
	            <td>{{ $registrant->mobilecarrier }}</td>
	            <td>Online</td>
	            <td></td>
	            <td></td>
				<td></td>
	            <td>{{ $registrant->course }}</td>
	            <td>{{ $registrant->fee }}</td>
	            <td>{{ $registration->coid }}</td>
	            <td>{{ $registration->name }}</td>
	            <td>{{ str_replace(["-","(",")"],["","",""],$registration->phone) }}</td>
	            <td>{{ $registration->address }}</td>
	            <td>{{ $registration->city }}</td>
	            <td>{{ $registration->state }}</td>
	            <td>{{ $registration->zip }}</td>
	            <td>{{ $registration->contact }}</td>
	            <td>{{ str_replace(["-","(",")"],["","",""],$registration->cphone) }}</td>
	            <td>{{ $registration->cemail }}</td>
	            @if($registration->name=="Self Students")
	            	<td>I</td>
	            @else
	            	<td>C</td>
	            @endif
	            <td>{{ ($registration->member)?'true':'false' }}</td>
	            <td></td>
	            <td>{{$registration->paytype}}</td>
	            <td>{{$registration->due}}</td>
	            <td>{{$registration->paid}}</td>
	            <td>{{$registration->balance}}</td>
	            <td>{{$registration->cardno}}</td>
	            <td>{{$registration->cardtype}}</td>
	            <td>{{$registration->ponum}}</td>
	            <td>{{$registrant->schoolyear}}</td>
	            <td>{{$registration->responsible}}</td>
        </tr>
            @endforeach
    @endforeach
    </tbody>
</table>