@extends('layouts.dashboard')

@section('pagetitle')
Add Group
@endsection

@section('content')

	<!-- Display Validation Errors -->
	@include('common.errors')
	
	<div class="col-md-12">
		<div class="example-wrap">
			<div class="example table-responsive">
				<form action="/settings/groups{{ isset($group->id) ? '/'.$group->id : '' }}" method="POST">
				<div class="col-md-4">
					<input type="text" placeholder="Group Name" name="name" class="form-control" value="{{ isset($group->name) ? $group->name : '' }}" /><br>
					<textarea name="desc" class="form-control" placeholder="Group Description">{{ isset($group->desc) ? $group->desc : '' }}</textarea>
				</div>
					<div class="clearfix visible-md-block visible-lg-block"></div><br><br>
					<table class="table" id="users">
						<thead>
							<tr>
								<th>Name</th>
								<th>
									<button data-original-title="Add User" data-toggle="tooltip" class="btn btn-sm btn-icon btn-flat btn-default" type="button" onclick="$('#addUser').modal('show');">
										<i aria-hidden="true" class="icon wb-plus"></i>
									</button>
								</th>
							</tr>
						</thead>
						<tbody>
						@if(isset($group) && count($group->users) > 0)
							@foreach($group->users as $c)
								<tr id="line{{ $c['id'] }}">
									<td>{{ $c['name'] }}</td>
									<td>
										<button onclick="removeLine('{{ $c['id'] }}')" data-original-title="Remove Line" data-toggle="tooltip" class="btn btn-sm btn-icon btn-flat btn-default removeline" type="button"> <i aria-hidden="true" class="icon wb-minus"></i></button><input type="hidden" name="user[]" value="{{ $c['id'] }}"/>
									</td>
								</tr>
							@endforeach
						@endif
						</tbody>
					</table>
					<div class="col-lg-12">
						<div class="form-group">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<button class="btn btn-primary save" style="float: right;" type="submit">Save Group</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="clearfix visible-md-block visible-lg-block"></div>
	
	
	<div tabindex="-1" role="dialog" aria-labelledby="exampleModalTabs" aria-hidden="true" id="addUser" class="modal fade" style="display: none;">
		<div class="modal-dialog modal-lg modal-center">
			<div class="modal-content">
				<div class="modal-header">
					<button aria-label="Close" data-dismiss="modal" class="close" type="button">
						<span aria-hidden="true">×</span>
					</button>
					<h4 id="exampleModalTabs" class="modal-title">Add User</h4>
				</div>
				<div class="modal-body" style="overflow: scroll; max-height: 800px;">
					<table class="table">
						<thead>
							<tr>
								<th>Name</th>
								<th>Email</th>
								<th>Role</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							<?php $i = 0; ?>
							@foreach ($users as $c)
							<tr id="selrow{{ $c['id'] }}">
								<td>{{ $c['name'] }}</td>
								<td>{{ $c['email'] }}</td>
								<td>{{ $c['role'] }}</td>
								<td>
									<button data-original-title="Add" onclick="addUser('{{ $c['name'] }}', '{{ $c['id'] }}')" data-toggle="tooltip" class="btn btn-sm btn-icon btn-flat btn-default" type="button">
										<i aria-hidden="true" class="icon wb-plus"></i>
									</button>
								</td>
							</tr>
							<?php $i++; ?>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	
	<script>
		function addUser(name, id){
			$('#selrow'+id).remove();
			$('#addUser').modal('hide');
			var row = '<tr id="line'+id+'"> <td>'+name+'</td><td> <button onclick="removeLine('+id+')" data-original-title="Remove Line" data-toggle="tooltip" class="btn btn-sm btn-icon btn-flat btn-default removeline" type="button"> <i aria-hidden="true" class="icon wb-minus"></i></button><input type="hidden" name="user[]" value="'+id+'"/> </td> </tr>';
			$('#users tbody').append(row);
			
		}
		function removeLine(id){
			$('#line'+id).remove();
		}
	</script>
@endsection