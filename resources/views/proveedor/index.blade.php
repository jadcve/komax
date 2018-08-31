@extends('scaffold-interface.layouts.app')
@section('title','Proveedores')
@section('content')

<section class="content">
    <h1>
        Modulo de Proveedores
    </h1>
    <a href='{!!url("proveedor")!!}/create' class = 'btn btn-success'><i class="fa fa-plus"></i> Crear Proveedor</a>
    <br>
    <br>
    <br>
    <table class = "table table-striped table-bordered table-hover" style = 'background:#fff'>
        <thead>
            <th>Código Proveedor</th>
            <th>Nombre</th>
            <th>Leed Time</th>
            <th>Tiempo de entrega</th>
            <th>Editado</th>
            <th>Acciones</th>
        </thead>
        <tbody>
            @foreach($proveedors as $proveedor)
            <tr>
                <td>{!!$proveedor->cod_prov!!}</td>
                <td>{!!$proveedor->nombre_prov!!}</td>
                <td>{!!$proveedor->leedt_prov!!}</td>
                <td>{!!$proveedor->tentrega_prov!!}</td>
                <td>
                        {!!$proveedor->user['name']!!}<span style="font-size:8px"><br>{!!$proveedor->updated_at!!}</span>
                 </td>
                <td>
                    <a href = '#' class = 'viewShow btn btn-warning btn-xs' data-link = '/proveedor/{!!$proveedor->id!!}'><i class = 'fa fa-eye'> Detalles</i></a>
                    <a href = '#' class = 'viewEdit btn btn-primary btn-xs' data-link = '/proveedor/{!!$proveedor->id!!}/edit'><i class = 'fa fa-edit'> Editar</i></a>
                    <a data-toggle="modal" data-target="#myModal" class = 'delete btn btn-danger btn-xs' data-link = "/proveedor/{!!$proveedor->id!!}/deleteMsg" ><i class = 'fa fa-trash'> Eliminar</i></a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {!! $proveedors->render() !!}

</section>
@endsection
