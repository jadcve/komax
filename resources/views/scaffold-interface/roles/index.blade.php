@extends('scaffold-interface.layouts.app')
@section('content')
<section class="content">
	<div class="box box-primary">
		<div class="box-header">
			<h3>Perfiles del Sistema</h3>
		</div>
		<div class="box-body">
			<a href="{{url('scaffold-roles/create')}}" class = "btn btn-warning"><i class="fa fa-plus fa-md" aria-hidden="true"></i> Nuevo Perfil</a>
			<br/>
            <br/>
            <br/>
            <table class="table table-striped">
				<head>
					<th>Perfil</th>
					<th>Acción</th>
				</head>
				<tbody>
					@foreach($roles as $role)
					<tr>
						<td>{{$role->name}}</td>
						<td>
							<a href="{{url('/scaffold-roles/edit')}}/{{$role->id}}" class = "btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
							<a href="{{url('/scaffold-roles/delete')}}/{{$role->id}}" class = "btn btn-danger btn-sm"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</section>
@endsection
