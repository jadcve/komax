@extends('scaffold-interface.layouts.app')
@section('content')
<section class="content">
<div class="box box-primary">
<div class="box-header">
	<h3>Usuarios del sistema</h3>
</div>
	<div class="box-body">
		<a href="{{url('/scaffold-users/create')}}" class = "btn btn-warning"><i class="fa fa-plus fa-md" aria-hidden="true"></i> Nuevo usuario</a>
		<table class = "table table-hover">
		<thead>
			<th>Nombre</th>
			<th>Email</th>
			<th>Perfil</th>
			<th>Acciones</th>
		</thead>
		<tbody>
			@foreach($users as $user)
			<tr>
				<td>{{$user->name}}</td>
				<td>{{$user->email}}</td>
				<td>
				@if(!empty($user->roles))
					@foreach($user->roles as $role)
					<small class = 'label bg-red'>{{$role->name}}</small>
					@endforeach
				@else
					<small class = 'label bg-red'>Sin perfil</small>
				@endif
				</td>
				<td>
					<a href="{{url('/scaffold-users/edit')}}/{{$user->id}}" class = 'btn btn-primary btn-sm'><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
					<a href="{{url('scaffold-users/delete')}}/{{$user->id}}" class = "btn btn-danger btn-sm"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
</div>
</section>
@endsection
