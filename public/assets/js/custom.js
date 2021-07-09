// LOAD NEW PAGE VIA AJAX
function load_page(url) {
    $.ajax({
        url 	: url,
        type 	: 'get',
        success : function (response) {
        	// LOAD NEW CONTENT
        	$('#content').html(response);

        	// SET AUTOFOCUS FOR NAME FIELD
            $('#name').focus();

            // INITIALIZE DATATABLE
            $('#example').DataTable();

    		// INITIALIZE TOOLTIP
            initialize_tooltip();

            // HIDE CONFLICTING TOOLTIPS
            $('.tooltip').hide();

            // MANAGE ALERTS
    		manage_alert();
        }
    });
}

// VERIFY USER'S PHONE FOR DUPLICATES
function check_phone_validity(phone, id, url) {
	if(phone.length == 11) {
        $.ajax({
            url 	: url,
            type 	: 'get',
            data 	: {
                phone 	: phone,
                id		: id
            },
            success : function (response) {
                $('#phone_check').html(response);
            }
        });
    } else if(phone.length > 11) {
    	$('#phone_check').html('<p style="color: red;">Provide a 11 digit phone number!</p>');
    } else {
    	$('#phone_check').html('');
    }
}

$("#form").submit(function(event) {
    // DISABLE SUBMIT BUTTON
    $('#submit').prop('disabled', true);

    // PREVENT DEFAULT FORM SUBMIT
    event.preventDefault();

    // SEND AJAX REQUEST
    $.ajax({
        url     : $(this).attr('action'),
        method  : 'post',
        data    : $(this).serialize(),
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

// INITIALIZE TOOLTIP
function initialize_tooltip() {
	var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
	var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
		return new bootstrap.Tooltip(tooltipTriggerEl);
	});
}

// AUTOMATICALLY HIDE ALERTS AFTER DELAY
function hide_alert() {
	$(".alert").delay(10000).slideUp(400, function() {
      	$(this).alert('close');
  	});
}

// MANAGE ALERTS
function manage_alert() {
	$('.alert').hide();
	$('.alert').slideDown(400);
	hide_alert();
}