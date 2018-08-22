@extends('scaffold-interface.layouts.app')
@section('title','Index')
@section('content')

<section class="content">
    <h1>
        Calendario Index
    </h1>
    <a href='{!!url("calendario")!!}/create' class = 'btn btn-success'><i class="fa fa-plus"></i> New</a>
    <br>
    <br>
    <table class = "table table-striped table-bordered table-hover" style = 'background:#fff'>
        <thead>
            <th>dia_despacho</th>
            <th>lead_time</th>
            <th>tiempo_entrega</th>
            <th>tienda_id</th>
            <th>actions</th>
        </thead>
        <tbody>
            @foreach($calendarios as $calendario) 
            <tr>
                <td>{!!$calendario->dia_despacho!!}</td>
                <td>{!!$calendario->lead_time!!}</td>
                <td>{!!$calendario->tiempo_entrega!!}</td>
                <td>{!!$calendario->tienda_id!!}</td>
                <td>
                    <a data-toggle="modal" data-target="#myModal" class = 'delete btn btn-danger btn-xs' data-link = "/calendario/{!!$calendario->id!!}/deleteMsg" ><i class = 'fa fa-trash'> delete</i></a>
                    <a href = '#' class = 'viewEdit btn btn-primary btn-xs' data-link = '/calendario/{!!$calendario->id!!}/edit'><i class = 'fa fa-edit'> edit</i></a>
                    <a href = '#' class = 'viewShow btn btn-warning btn-xs' data-link = '/calendario/{!!$calendario->id!!}'><i class = 'fa fa-eye'> info</i></a>
                </td>
            </tr>
            @endforeach 
        </tbody>
    </table>
    {!! $calendarios->render() !!}

</section>
@endsection