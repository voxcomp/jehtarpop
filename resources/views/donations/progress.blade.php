<div class="dp1201-container">
	<div class="dp1201-image">
		<img src="{{env('APP_URL')}}/images/donations-progress.png">
	</div>
	<div class="dp1201-bar" style="height:{{$percent}}%;"></div>
	<div class="dp1201-title">
		<div>{{$total}}</div>
		<div><span>RAISED</span></div>
	</div>
</div>
<style>
	.dp1201-container {
		position:relative;
		z-index:1;
		width:100%;
		max-width:350px;
		margin:0 auto;
	}
	.dp1201-container .dp1201-image {
		position:relative;
		z-index:2;
	}
	.dp1201-container .dp1201-image img {
		width:100%;
		height:auto;
	}
	.dp1201-container .dp1201-bar {
		position:absolute;
		left:41%;
		width:50%;
		bottom:51%;
		height:0%;
		background:#EE3B43;
		z-index:1;
	}
	.dp1201-container .dp1201-title {
		font-family:'Montserrat', Helvetica, sans-serif;
		position:absolute;
		left:51%;
		top:11.5%;
		width:31%;
		height:4.5%;
		overflow:hidden;
		color:#fff;
		font-weight:700;
		font-size:24px;
	  	font-size: 1vmin;
		line-height:0.6em;
		text-align:center;
		display:flex;
		flex-direction: column;
		justify-content:center;
		align-items:center;
		z-index:3;
	}
	.dp1201-container .dp1201-title span {
		font-size:15px;
		font-size:0.8vmin;
	}
	@media screen and (min-width: 991px) {
  		.dp1201-container .dp1201-title {
	  		font-size: 1.4vmin;
  		}
	}
	@media screen and (min-width: 1200px) {
		  .dp1201-container .dp1201-title {
			  font-size: 1.7vmin;
		  }
	}
	@media screen and (max-width: 500px) {
		  .dp1201-container .dp1201-title {
			  font-size: 6vmin;
		  }
	}
</style>
