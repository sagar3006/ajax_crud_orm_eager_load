<div class="row justify-content-center">
	<div class="col-sm-12">
		@if(session()->has('success_message'))
	      	<p class="alert alert-success text-center">
	          	<b>{{ session()->get('success_message') }}</b>
	      	</p>
	  	@endif
  	</div>
</div>