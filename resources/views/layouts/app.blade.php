<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
	{{--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" />--}}
    <link href="{{ asset('css/app.css') }}?ver=1.0" rel="stylesheet">
    @yield('head')
</head>
<body>
    <div id="app">
	    <div class="top-bar bg-primary py-2 px-5 text-end no-print">
		    <a href="https://www.gwgci.org/">BACK TO WEBSITE</a>
		    @if(Auth::check())
                <a href="{{ route('home') }}">
                    &nbsp; |&nbsp; MY ACCOUNT
                </a>
                <a href="{{ url('/logout') }}"
                    onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();">
                    &nbsp; |&nbsp; LOGOUT
                </a>

                <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
		    @endif
	    </div>

        <div class="container-fluid py-4">
	        <div class="row">
		        <div class="col-sm col-lg-7">
		            <a class="logo" href="{{ url('/') }}">
		                <img src="{{ URL::to('/') }}/images/gould-logo.jpg" class="img-fluid" style="width:268px;">
		            </a>
		        </div>
		        <div class="col-sm col-lg-5 no-print">
			        <div class="row">
				        <div class="col-8">
					        <a href="https://www.abcma.org/" target="_blank"><img src="{{ URL::to('/') }}/images/abc-mass.png" class="img-fluid"></a>
				        </div>
				        <div class="col-4">
					        <a href="https://www.buildingmasscareers.com/" target="_blank"><img src="{{ URL::to('/') }}/images/building-mass.png" class="img-fluid"></a>
				        </div>
			        </div>
		        </div>
	        </div>
        </div>
        
        <div class="container-fluid bg-danger py-2">
	        <div class="row">
		        <div class="col">
			        <h1 class="page-title">@yield('title')</h1>
		        </div>
	        </div>
        </div>

        @if(\Auth::check() && \Auth::user()->isAdmin())
	        <div class="container-fluid py-2">
		        <div class="row">
			        <div class="col">
						<ul class="nav nav-tabs">
							<li class="nav-item">
								<a class="nav-link" href="{{route('home')}}">Dashboard</a>
							</li>
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">Registrations</a>
								<div class="dropdown-menu">
									<a class="dropdown-item" href="{{route('admin.downloads')}}">Downloads</a>
									<a class="dropdown-item" href="{{route('admin.viewRegistrations')}}">View</a>
								</div>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="{{route('admin.uploads')}}">Uploads</a>
							</li>
							<li class="nav-item">
								<a href="{{route('admin.viewDonations')}}" class="nav-link">Donations</a>
							</li>
						    <li class="nav-item">
						        <a href="{{route('admin.coupons')}}" class="nav-link">Discount Codes</a>
						    </li>
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">Site Settings</a>
								<div class="dropdown-menu">
									<a class="dropdown-item" href="{{route('settings.general')}}">General</a>
									<a class="dropdown-item" href="{{route('settings.content')}}">Content</a>
									<a class="dropdown-item" href="{{route('settings.registration')}}">Registration</a>
									<a class="dropdown-item" href="{{route('settings.registrationContent')}}">Registration Content</a>
								</div>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="{{route('support.list')}}">Support Tickets</a>
							</li>
						</ul>
			        </div>
		        </div>
	        </div>
        @endif

		@if (session()->has('message'))
	        <div class="container-fluid py-2">
		        <div class="row">
			        <div class="col">
					    <div class="alert alert-success">
					        {{ session()->get('message') }}
					    </div>
			        </div>
		        </div>
	        </div>
		@endif
		@if (session()->has('errormessage'))
	        <div class="container-fluid py-2">
		        <div class="row">
			        <div class="col">
					    <div class="alert alert-danger nohide">
					        {!! session()->get('errormessage') !!}<br>
							Please see below for more information.
					    </div>
			        </div>
		        </div>
	        </div>
		@endif
		@if (isset($message))
			<div class="container-fluid py-2">
				<div class="alert alert-danger nohide">
					{{ $message }}
				</div>
			</div>
		@endif
		
		@if(isset($front))
			<div class="container-fluid">
			<div class="row">
		        <main>
		@else
			<div class="container" style="max-width:1500px;">
			<div class="row">
				@if(View::hasSection('helpdesk'))
					@yield('helpdesk')
				@endif
		        <main class="py-5 col-sm">
		@endif
		            @yield('content')
		        </main>
				@if(View::hasSection('rightsidebar'))
			      <aside class="col-md-3" id="right-sidebar" role="complementary">
			        @yield('rightsidebar')
			      </aside>
				@endif
			</div>
		</div>
        
        @if(!\Auth::check())
        	@if(!isset($front))
	        	<div class="container-fluid">
			        <div class="row row-eq-height no-print">
				        <div class="col-sm bg-primary text-white px-5 py-5 text-center">
							<h3>ELEVEN CONVENIENT LOCATIONS</h3>
							<p> Andover &nbsp;|&nbsp; Canton |&nbsp; Franklin&nbsp; |&nbsp; Holyoke<br>Medford |&nbsp; North Adams |&nbsp;Springfield<br>Taunton |&nbsp; Westfield |&nbsp; Woburn</p>
							<p><a href="http://www.gwgci.com/education/online-program-overview/" target="_blank" class="btn btn-info">Or Online</a></p>
				        </div>
				        <div class="col-sm bg-danger text-white px-5 py-5 text-center">
					        <h3>OUR PARTNERS</h3>
					        <p> Wentworth Institute of Technology<br>Springfield Technical Community College<br>Massasoit Community College&nbsp; |&nbsp; Penn Foster</p>
							<p><a href="#" target="_blank" class="btn btn-danger">Read More</a></p>
				        </div>
			        </div>
	        	</div>
        	@endif
			<footer class="container-fluid p-4">
		        <div class="row mb-4">
			        <div class="col-sm-7 no-print mobile-text-center">
				        <div>POWERFUL ALLIES:</div>
				        <div class="row align-items-center">
					        <div class="col">
						        <a href="https://www.abcma.org/" target="_blank"><img class="img-fluid" src="{{ URL::to('/') }}/images/abc-mass-color.png"></a>
					        </div>
					        <div class="col">
						        <a href="https://www.buildingmasscareers.com/" target="_blank"><img class="img-fluid" src="{{ URL::to('/') }}/images/building-mass-color.png"></a>
					        </div>
					        <div class="col">
						        <a href="https://www.gwgci.org" target="_blank"><img class="img-fluid" src="{{ URL::to('/') }}/images/gould-color.jpg"></a>
					        </div>
				        </div>
				        <p style="font-size:120%">Promoting, Educating and Advancing the Construction Industry</p>
			        </div>
			        <div class="col-sm-5 text-end mobile-text-center no-print">
				        <div>CONNECT WITH US ON:</div>
				        <p class="social">
					        <a href="https://twitter.com/gwgci" target="_blank"><i class="fab fa-twitter"></i></a>
					        <a href="https://www.instagram.com/gwgci/" target="_blank"><i class="fab fa-instagram"></i></a>
					        <a href="https://www.facebook.com/GouldConstructionInstitute/" target="_blank"><i class="fab fa-facebook-f"></i></a>
					        <a href="https://www.linkedin.com/company/gould-construction-institute" target="_blank"><i class="fab fa-linkedin"></i></a>
					        <a href="https://www.gwgci.org/About/Contact-Us" target="_blank"><i class="fas fa-envelope-open-text"></i></a>
				        </p>
			        </div>
		        </div>
		        <div class="row">
			        <div class="col-sm-7 no-print mobile-text-center">
				        <div>The Massachusetts Chapter of Associated Builders and Contractors (ABCMA) is the largest construction trade association in the Commonwealth, representing over 480 local general contractor, subcontractor, supplier and associate companies. These companies employ more than 22,000 workers throughout Massachusetts.</div>
			        </div>
			        <div class="col-sm-5 text-end mobile-text-center print-left">
				        <div><strong>100 Unicorn Park Drive, Suite 2<br>Woburn, MA 01801<br>781-270-9990</strong></div>
				        <div>&copy; {{date("Y")}} Gould Construction Institute. All Rights Reserved.</div>
			        </div>
		        </div>			        
			</footer>
	    @endif
	    <div class="bottom-bar bg-danger py-2 no-print">
	    </div>
    </div>

	<div id="dialog-confirm"></div>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}?ver=2.0" ></script>
	{{--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>--}}
    @yield('footer')
	
	{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" ></script>--}}
	{{--<script src="{{ asset('js/theme.js') }}?ver=2.0" ></script>--}}
</body>
</html>
