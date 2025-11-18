@extends('layouts.app')

@section('title')
Administration - Uploads
@endsection

@section('content')
	    <div class="row justify-content-center">
	        <div class="col-sm">
	            <div class="card">
	                <div class="card-header">Member/Customer Upload</div>
	
	                <div class="card-body">
	                    @if (session('status'))
	                        <div class="alert alert-success" role="alert">
	                            {{ session('status') }}
	                        </div>
	                    @endif
	                    <p>Upload an Excel spreadsheet containing a list of members/companies.  All member information stored in the site will be replaced.</p>
	                    <p>The columns must be: <strong>ID, Name, Member, Address, City, State, Zip, Phone, Balance</strong></p>
						
						{{ html()->form('POST', route('customerUpload'))->acceptsFiles()->open() }}
						<div class="form-group">{{ html()->file('customers') }}</div>
						<div class="form-group">{{ html()->input('submit')->value('Submit')->class('btn btn-primary') }}</div>
						{{ html()->form()->close() }}
	                </div>
	            </div>
	        </div>
	        <div class="col-sm">
	            <div class="card">
	                <div class="card-header">Student Upload</div>
	
	                <div class="card-body">
	                    @if (session('status'))
	                        <div class="alert alert-success" role="alert">
	                            {{ session('status') }}
	                        </div>
	                    @endif
	                    <p>Upload an Excel spreadsheet containing a list of courses.  All course information stored in the site will be replaced.</p>
	                    <p>The columns must be: <strong>COID, INDID, FirstName, LastName, Member Amount, Non-Member Amount</strong></p>
						
						{{ html()->form('POST', route('studentUpload'))->acceptsFiles()->open() }}
						<div class="form-group">{{ html()->file('students') }}</div>
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
	                <div class="card-header">Course Upload</div>
	
	                <div class="card-body">
	                    @if (session('status'))
	                        <div class="alert alert-success" role="alert">
	                            {{ session('status') }}
	                        </div>
	                    @endif
	                    <p>Upload an Excel spreadsheet containing a list of courses.  All course information stored in the site will be replaced.</p>
	                    <p>The columns must be: <strong>School Year, Course ID, Course Description, Trade (CraftID), Trade Description (CraftDesc), Location ID, Member Amount, Non-Member Amount</strong></p>
						
						{{ html()->form('POST', route('courseUpload'))->acceptsFiles()->open() }}
						<div class="form-group">{{ html()->file('courses') }}</div>
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
	                <div class="card-header">Online Class Upload</div>
	
	                <div class="card-body">
	                    @if (session('status'))
	                        <div class="alert alert-success" role="alert">
	                            {{ session('status') }}
	                        </div>
	                    @endif
	                    <p>Upload an Excel spreadsheet containing a list of online classes.  All online class information stored in the site will be replaced.</p>
	                    <p>The columns must be: <strong>School Year, Course ID, Course Description, Trade (CraftID), Trade Description (CraftDesc), Location ID, Member Amount, Non-Member Amount</strong></p>
						
						{{ html()->form('POST', route('onlineClassUpload'))->acceptsFiles()->open() }}
						<div class="form-group">{{ html()->file('courses') }}</div>
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
	                <div class="card-header">Correspondence Class Upload</div>
	
	                <div class="card-body">
	                    @if (session('status'))
	                        <div class="alert alert-success" role="alert">
	                            {{ session('status') }}
	                        </div>
	                    @endif
	                    <p>Upload an Excel spreadsheet containing a list of correspondence classes.  All online class information stored in the site will be replaced.</p>
	                    <p>The columns must be: <strong>School Year, Course ID, Course Description, Trade (CraftID), Trade Description (CraftDesc), Location ID, Member Amount, Non-Member Amount</strong></p>
						
						{{ html()->form('POST', route('correspondenceClassUpload'))->acceptsFiles()->open() }}
						<div class="form-group">{{ html()->file('courses') }}</div>
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
	                <div class="card-header">Event Upload</div>
	
	                <div class="card-body">
	                    @if (session('status'))
	                        <div class="alert alert-success" role="alert">
	                            {{ session('status') }}
	                        </div>
	                    @endif
	                    <p>Upload an Excel spreadsheet containing a list of events.  All event information stored in the site will be replaced.</p>
	                    <p>The columns must be: <strong>ID, Event Start Date, Event End Date, Event Start Time, Event End Time, Event Name, Minimum, Maximum, Staff Contact, Location Name, Phone, Address1, Address2, City, State</strong></p>
						
						{{ html()->form('POST', route('eventUpload'))->acceptsFiles()->open() }}
						<div class="form-group">{{ html()->file('events') }}</div>
						<div class="form-group">{{ html()->input('submit')->value('Submit')->class('btn btn-primary') }}</div>
						{{ html()->form()->close() }}
	                </div>
	            </div>
	        </div>
	        <div class="col-sm">
	            <div class="card">
	                <div class="card-header">Ticket Upload</div>
	
	                <div class="card-body">
	                    @if (session('status'))
	                        <div class="alert alert-success" role="alert">
	                            {{ session('status') }}
	                        </div>
	                    @endif
	                    <h3>NOTE: PLEASE UPLOAD EVENTS FIRST</h3>
	                    <p>Upload an Excel spreadsheet containing a list of event tickets.  All ticket information stored in the site will be replaced.</p>
	                    <p>The columns must be: <strong>Event ID, Ticket Name, Ticket ID, Member Amount, Non-Member Amount</strong></p>
						
						{{ html()->form('POST', route('ticketUpload'))->acceptsFiles()->open() }}
						<div class="form-group">{{ html()->file('tickets') }}</div>
						<div class="form-group">{{ html()->input('submit')->value('Submit')->class('btn btn-primary') }}</div>
						{{ html()->form()->close() }}
	                </div>
	            </div>
	        </div>
	    </div>
@endsection