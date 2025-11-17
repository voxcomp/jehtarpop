@extends('layouts.app')

@section('title')
Administration
@endsection

@section('content')
		<div class="row justify-content-center mb-5">
			<div class="col col-sm-auto text-center">
				<a href="{{route('admin.viewRegistrations')}}"><i class="fas fa-eye mb-2" style="font-size:50px;"></i><br>View Registrations</a>
			</div>
			<div class="col col-sm-auto text-center">
				<a href="{{route('admin.downloads')}}"><i class="fas fa-download mb-2" style="font-size:50px;"></i><br>Download Registrations</a>
			</div>
			<div class="col col-sm-auto text-center">
				<a href="{{route('admin.uploads')}}"><i class="fas fa-upload mb-2" style="font-size:50px;"></i><br>Upload Data</a>
			</div>
			<div class="col col-sm-auto text-center">
				<a href="{{route('settings.registration')}}"><i class="fas fa-cogs mb-2" style="font-size:50px;"></i></i><br>Registration Settings</a>
			</div>
			<div class="col col-sm-auto text-center">
				<a href="{{route('support.list')}}"><i class="fas fa-ticket-alt mb-2" style="font-size:50px;"></i></i><br>Support Tickets</a>
			</div>
		</div>
	    <div class="row justify-content-center">
	        <div class="col-sm">
	            <div class="card">
	                <div class="card-header">Registrations: 7 Days</div>
	
	                <div class="card-body">
						<strong>Registration Count</strong><br>
						Companies: {{$registrations->where('coid','<>','7617')->where('paytype','<>','hold')->filter(fn($s)=>$s->created_at>=now()->subDay())->count()}}<br>
						Individuals: {{$registrations->where('coid','=','7617')->where('paytype','<>','hold')->filter(fn($s)=>$s->created_at>=now()->subDay())->count()}}<br>
						On Hold: {{$registrations->where('paytype','=','hold')->filter(fn($s)=>$s->created_at>=now()->subDay())->count()}}<br>
						<hr>
						<strong>Totals</strong><br>
						Charged Amount: ${{number_format($registrations->where('paytype','credit')->filter(fn($s)=>$s->created_at>=now()->subDay())->sum('total'),2)}}<br>
						Check Amount: ${{number_format($registrations->where('paytype','check')->filter(fn($s)=>$s->created_at>=now()->subDay())->sum('total'),2)}}<br>
						<hr>
						<strong>Registration Types</strong>
						<div class="pl-2">
							@foreach($registrations->where('paytype','<>','hold')->filter(fn($s)=>$s->created_at>=now()->subDay())->groupBy('regtype')->map(fn ($items) => $items->count()) as $regtype => $total)
								{{ucfirst($regtype)}}: {{$total}}<br>
							@endforeach
						</div>
	                </div>
	            </div>
	        </div>
			<div class="col-sm">
				<div class="card">
					<div class="card-header">Registrations: 30 Days</div>
			
					<div class="card-body">
						<strong>Registration Count</strong><br>
						Companies: {{$registrations->where('coid','<>','7617')->where('paytype','<>','hold')->filter(fn($s)=>$s->created_at>=now()->subDays(30))->count()}}<br>
						Individuals: {{$registrations->where('coid','=','7617')->where('paytype','<>','hold')->filter(fn($s)=>$s->created_at>=now()->subDays(30))->count()}}<br>
						On Hold: {{$registrations->where('paytype','=','hold')->filter(fn($s)=>$s->created_at>=now()->subDays(30))->count()}}<br>
						<hr>
						<strong>Totals</strong><br>
						Charged Amount: ${{number_format($registrations->where('paytype','credit')->filter(fn($s)=>$s->created_at>=now()->subDays(30))->sum('total'),2)}}<br>
						Check Amount: ${{number_format($registrations->where('paytype','check')->filter(fn($s)=>$s->created_at>=now()->subDays(30))->sum('total'),2)}}
						<hr>
						<strong>Registration Types</strong>
						<div class="pl-2">
							@foreach($registrations->where('paytype','<>','hold')->filter(fn($s)=>$s->created_at>=now()->subDays(30))->groupBy('regtype')->map(fn ($items) => $items->count()) as $regtype => $total)
								{{ucfirst($regtype)}}: {{$total}}<br>
							@endforeach
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm">
				<div class="card">
					<div class="card-header">Registrations: 90 Days</div>
			
					<div class="card-body">
						<strong>Registration Count</strong><br>
						Companies: {{$registrations->where('coid','<>','7617')->where('paytype','<>','hold')->filter(fn($s)=>$s->created_at>=now()->subDays(90))->count()}}<br>
						Individuals: {{$registrations->where('coid','=','7617')->where('paytype','<>','hold')->filter(fn($s)=>$s->created_at>=now()->subDays(90))->count()}}<br>
						On Hold: {{$registrations->where('paytype','=','hold')->filter(fn($s)=>$s->created_at>=now()->subDays(90))->count()}}<br>
						<hr>
						<strong>Totals</strong><br>
						Charged Amount: ${{number_format($registrations->where('paytype','credit')->filter(fn($s)=>$s->created_at>=now()->subDays(90))->sum('total'),2)}}<br>
						Check Amount: ${{number_format($registrations->where('paytype','check')->filter(fn($s)=>$s->created_at>=now()->subDays(90))->sum('total'),2)}}
						<hr>
						<strong>Registration Types</strong>
						<div class="pl-2">
							@foreach($registrations->where('paytype','<>','hold')->filter(fn($s)=>$s->created_at>=now()->subDays(90))->groupBy('regtype')->map(fn ($items) => $items->count()) as $regtype => $total)
								{{ucfirst($regtype)}}: {{$total}}<br>
							@endforeach
						</div>
					</div>
				</div>
			</div>
	    </div>
@endsection

