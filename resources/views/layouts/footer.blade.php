<!-- Bootstrap JS -->
<script src="{{ asset('public/assets/js/bootstrap.bundle.min.js') }}" ></script>
<!-- DataTables JS -->
<script src="{{ asset('public/assets/js/datatables.min.js') }}" ></script>

<!-- CUSTOM JS -->
<script src="{{ asset('public/assets/js/custom.js') }}" ></script>

<script>

	// LOAD USERS PAGE ON APPLICATION START
	$(document).ready(function() {
		load_page('{{ url('users') }}');
	});

</script>