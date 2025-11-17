@extends('layouts.app')

@section('title')
	Donation Confirmation
@endsection

@section('content')
	<div class="row justify-content-center">
		<div class="col-lg-8">
			<p>Thank you for your donation of ${{number_format($donation->amount,2)}} and for your support of Gould Construction Institute! Someone from our team will reach out to you about your contribution. For any questions, please contact Julie DeStefano: julie@gwgci.org.</p>
			<p>&nbsp;</p>
			<p class="text-center"><a href="http://www.gwgci.org" class="btn btn-primary">Back To Website</a></p>
		</div>
	</div>
@endsection

@section('rightsidebar')
	@include('donations.progress-part')
@endsection
