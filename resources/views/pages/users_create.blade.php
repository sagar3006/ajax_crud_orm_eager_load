<a href="#" onclick="test_js()">Test</a>
<h1>Create User</h1>
<hr>

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#" onclick="load_page('{{ url('users') }}')">Users</a></li>
    <li class="breadcrumb-item active" aria-current="page">Create User</li>
  </ol>
</nav>

<div class="row justify-content-center">
	<div class="col-sm-6">

		<span id="errors"></span>

		<form id="form" action="{{ url('users') }}">
			@csrf
			<div class="mb-3">
		    	<label for="full-name">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="Enter your full name" autocomplete="off" required>
		  	</div>
		  	<div class="mb-3">
		  		<label for="phone">Phone</label>
                <input type="text" class="form-control" name="phone" value="{{ old('phone') }}" onkeyup="check_phone_validity(this.value, 0, '{{ url('verify-user-phone') }}')" placeholder="Provide a 11 digit phone number" autocomplete="off" required>
                <span id="phone_check"></span>
		  	</div>
		  	<div class="mb-3">
		    	<label for="address">Address</label>
                <textarea name="address" class="form-control" rows="2" placeholder="Enter your address" autocomplete="off" required>{{ old('address') }}</textarea>
		  	</div>
		  	<div class="mb-3">
		    	<label for="age">Age</label>
                <input type="number" class="form-control" name="age" value="{{ old('age') }}" min="1" max="130" placeholder="Enter your age" autocomplete="off">
		  	</div>
		  	<div class="mb-3">
		    	<label for="gender">Gender</label>
                <select class="form-select" name="gender">
				  	<option value="male" <?php if(old('gender') == 'male') echo 'selected'; ?>>Male</option>
				  	<option value="female" <?php if(old('gender') == 'female') echo 'selected'; ?>>Female</option>
				</select>
		  	</div>
		  	<div class="mb-3">
		    	<label for="profession">Profession</label>
                <input type="text" class="form-control" name="profession" value="{{ old('profession') }}" placeholder="Enter your profession" autocomplete="off">
		  	</div>
			<div class="text-center">
	  			<button type="submit" id="submit" class="btn btn-primary button">Submit</button>
		  	</div>
		</form>
	</div>
</div>

<script>
	
	$("#form").submit(function(event) {
		// DISABLE SUBMIT BUTTON
		$('#submit').prop('disabled', true);

		// PREVENT DEFAULT FORM SUBMIT
	  	event.preventDefault();

	  	// SEND AJAX REQUEST
	   	$.ajax({
	        url 	: $(this).attr('action'),
	        method 	: 'post',
	        data 	: $(this).serialize(),
	        success : function (response) {
	        	if(response.status == 'false') {
	        		// ENABLE SUBMIT BUTTON
	        		$('#submit').prop('disabled', false);

	        		// SET/RESET ERROR MESSAGES
			      	$('#errors').html(response.errors);

			      	// MANAGE ALERTS
	        		manage_alert();
	        	} else {
	        		load_page(response.redirect_url);
	        	}
	        }
	    });
	});

</script>