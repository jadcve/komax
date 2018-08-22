@extends('scaffold-interface.layouts.app')
@section('title','Index')
@section('content')

<section class="content">
    <h1>
        Nivel_servicio Index
    </h1>
    <a href='{!!url("nivel_servicio")!!}/create' class = 'btn btn-success'><i class="fa fa-plus"></i> New</a>
    <br>
    <br>
    <table class = "table table-striped table-bordered table-hover" style = 'background:#fff'>
        <thead>
            <th>letra</th>
            <th>nivel_servicio</th>
            <th>descripcion</th>
            <th>actions</th>
        </thead>
        <tbody>
            @foreach($nivel_servicios as $nivel_servicio) 
            <tr>
                <td>{!!$nivel_servicio->letra!!}</td>
                <td>{!!$nivel_servicio->nivel_servicio!!}</td>
                <td>{!!$nivel_servicio->descripcion!!}</td>
                <td>
                    <a data-toggle="modal" data-target="#myModal" class = 'delete btn btn-danger btn-xs' data-link = "/nivel_servicio/{!!$nivel_servicio->id!!}/deleteMsg" ><i class = 'fa fa-trash'> delete</i></a>
                    <a href = '#' class = 'viewEdit btn btn-primary btn-xs' data-link = '/nivel_servicio/{!!$nivel_servicio->id!!}/edit'><i class = 'fa fa-edit'> edit</i></a>
                    <a href = '#' class = 'viewShow btn btn-warning btn-xs' data-link = '/nivel_servicio/{!!$nivel_servicio->id!!}'><i class = 'fa fa-eye'> info</i></a>
                </td>
            </tr>
            @endforeach 
        </tbody>
    </table>
    {!! $nivel_servicios->render() !!}

</section>
@endsection