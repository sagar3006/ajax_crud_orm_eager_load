<script type="text/javascript">
    function show_delete_modal(action)
    {
      jQuery('#delete_modal').modal('show', {backdrop: 'static'});
      document.getElementById('delete_form').setAttribute('action', action);
    }
</script>

<div class="modal fade" id="delete_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Delete Info</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to delete this information?</p>
      </div>
      <div class="modal-footer">
        <form id="delete_form" action="">
          @method('DELETE')
          @csrf
          <input type="submit" id="submit" class="btn btn-danger" value="Yes">
          <button type="button" class="btn btn-success" data-bs-dismiss="modal">Cancel</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>

  $("#delete_form").submit(function(event) {
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
        if(response.status == 'true') {
          // HIDE DELETE MODAL
          $('#delete_modal').modal('hide');

          // ENABLE SUBMIT BUTTON
          $('#submit').prop('disabled', false);
          
          load_page('{{ url('users') }}');
        }
      }
    });
  });

</script>