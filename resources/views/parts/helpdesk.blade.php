<div class="my-5 col-sm-3 h-100 help-desk">
	@if(isset($section))
		<div class="p-4 mb-3" style="background:#C5D5E4;">
			{!!getSetting('hd_'.$section,'editor')!!}
		</div>
	@endif
	<div class="p-4 text-center" style="background:#C5D5E4;">
		<img src="{{ URL::to('/') }}/images/support.png" class="img-fluid" style="max-width:120px;">
		<h2>Experiencing an issue?</h2>
		<p>Let us know what's going wrong. Our support team is ready to troubleshoot and get you back on track.</p>
		@if(isset($path) && isset($id))
			<a href="{{route('support.page.registration',[$path,$id])}}" class="btn btn-primary">Report a Problem</a>
		@elseif(isset($path) && !isset($id))
			<a href="{{route('support.page.path',[$path])}}" class="btn btn-warning">Report a Problem</a>
		@endif
	</div>
</div>