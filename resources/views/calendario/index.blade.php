@extends('scaffold-interface.layouts.app')
@section('title','Index')
@section('content')

<section class="content">
    <h1>
        Calendario
    </h1>
    <a href='{!!url("calendario")!!}/create' class = 'btn btn-success'><i class="fa fa-plus"></i> Agregar</a>
    <br>
    <br>
    <table class = "table table-striped table-bordered table-hover" style = 'background:#fff'>
        <thead>
            <th>Día de Despacho</th>
            <th>Lead Time</th>
            <th>Tiempo de Entrega</th>
            <th>Tienda</th>
            <th>Editado</th>
            <th>Acciones</th>
        </thead>
        <tbody>
            @foreach($calendarios as $calendario) 
            <tr>
                <td>{!!$calendario->dia_despacho!!}</td>
                <td>{!!$calendario->lead_time!!}</td>
                <td>{!!$calendario->tiempo_entrega!!}</td>
                <td>{!!$calendario->tienda['bodega']!!}</td>
                <td>
                        {!!$calendario->user['name']!!}<span style="font-size:8px"><br>{!!$calendario->updated_at!!}</span>
                </td>
                <td>
                    <a href = '#' class = 'viewShow btn btn-warning btn-xs' data-link = '/calendario/{!!$calendario->id!!}'><i class = 'fa fa-eye'> Detalles</i></a>
                    <a href = '#' class = 'viewEdit btn btn-primary btn-xs' data-link = '/calendario/{!!$calendario->id!!}/edit'><i class = 'fa fa-edit'> Editar</i></a>
                    <a data-toggle="modal" data-target="#myModal" class = 'delete btn btn-danger btn-xs' data-link = "/calendario/{!!$calendario->id!!}/deleteMsg" ><i class = 'fa fa-trash'> Eliminar</i></a>
                </td>
            </tr>
            @endforeach 
        </tbody>
    </table>
    {!! $calendarios->render() !!}

</section>
@endsection