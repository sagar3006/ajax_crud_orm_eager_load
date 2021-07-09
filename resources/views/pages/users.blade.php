<!-- ALERT FOR SUCCESS -->
@include('layouts/alert_success')

<h1>Users</h1>
<hr>

<div class="clearfix">
	<a href="#" class="btn btn-outline-primary float-end button-add" onclick="load_page('{{ url('users/create') }}')">
		<i class="fas fa-user-plus"></i>
		<b>Create User</b>
	</a>
</div>
<br>

<?php if($users->isEmpty()) { ?>
	<p class="alert alert-info text-center"><b>No users found!</b></p>
<?php } else { ?>
	<div class="table-responsive">
	  	<table id="example" class="table table-striped" style="width:100%">
	    	<thead>
			    <tr>
			      	<th scope="col">#</th>
			      	<th scope="col">Name</th>
			      	<th scope="col">Phone</th>
			      	<th scope="col">Address</th>
			      	<th scope="col">Additional Info</th>
			      	<th scope="col">Actions</th>
			    </tr>
	  		</thead>
	  		<tbody>
	  			<?php
	  			foreach($users as $user) {
	  				$user_detail = $user->detail; ?>
				    <tr>
				      	<th scope="row">{{ $count++ }}</th>
				      	<td>{{ $user->name }}</td>
				      	<td>{{ $user->phone }}</td>
				      	<td>{{ $user->address }}</td>
				      	<td>
				      		<?php
				      			echo ($user_detail->age ? 'Age: ' . $user_detail->age . '<br>' : '');
				      			echo 'Gender: ' . ucfirst($user_detail->gender);
				      			echo ($user_detail->profession ? '<br> Profession: ' . $user_detail->profession : '');
				      		?>
				      	</td>
				      	<td>
				      		<a href="#" onclick="load_page('{{ url('users/' . $user->id . '/edit') }}')" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit User"><i class="fas fa-edit"></i></a>
				      		<a href="#" onclick="show_delete_modal('{{ url('users/' . $user->id) }}')" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete User"><i class="fas fa-trash-alt"></i></a>
				      	</td>
				    </tr>
	  			<?php } ?>
	  		</tbody>
	  	</table>
	</div>
<?php } ?>