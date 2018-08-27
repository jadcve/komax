@extends('scaffold-interface.layouts.app')
@section('title','Tiendas')
@section('content')

<section class="content">
    <h1>
        Tienda Index
    </h1>
    <a href='{!!url("tienda")!!}/create' class = 'btn btn-success'><i class="fa fa-plus"></i> Crear Tienda</a>
    <br>
    <br>
    <table class = "table table-striped table-bordered table-hover" style = 'background:#fff'>
        <thead>
            <th>Código</th>
            <th>Bodega</th>
            <th>Canal</th>
            <th>Ciudad</th>
            <th>Comuna</th>
            <th>Región</th>
            <th>Latitud</th>
            <th>Longitud</th>
            <th>Dirección</th>
            <th></th>
        </thead>
        <tbody>
            @foreach($tiendas as $tienda) 
            <tr>
                <td>{!!$tienda->cod_tienda!!}</td>
                <td>{!!$tienda->bodega!!}</td>
                <td>{!!$tienda->canal!!}</td>
                <td>{!!$tienda->ciudad!!}</td>
                <td>{!!$tienda->comuna!!}</td>
                <td>{!!$tienda->region!!}</td>
                <td>{!!$tienda->latitude!!}</td>
                <td>{!!$tienda->longitud!!}</td>
                <td>{!!$tienda->direccion!!}</td>
                <td>
                        <a href = '#' class = 'viewShow btn btn-warning btn-xs' data-link = '/tienda/{!!$tienda->id!!}'><i class = 'fa fa-eye'> info</i></a>
                        <a href = '#' class = 'viewEdit btn btn-primary btn-xs' data-link = '/tienda/{!!$tienda->id!!}/edit'><i class = 'fa fa-edit'> edit</i></a>
                        <a data-toggle="modal" data-target="#myModal" class = 'delete btn btn-danger btn-xs' data-link = "/tienda/{!!$tienda->id!!}/deleteMsg" ><i class = 'fa fa-trash'> delete</i></a>    
                </td>
            </tr>
            @endforeach 
        </tbody>
    </table>
    {!! $tiendas->render() !!}

</section>
@endsection