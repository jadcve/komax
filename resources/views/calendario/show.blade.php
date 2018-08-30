@extends('scaffold-interface.layouts.app')
@section('title','Show')
@section('content')

<section class="content">
    <h1>
        Calendario Detalles
    </h1>
    <br>
    <a href='{!!url("calendario")!!}' class = 'btn btn-primary'><i class="fa fa-home"></i>Calendario Lista</a>
    <br>
    <table class = 'table table-bordered'>
        <thead>
            <th style="width:30%"></th>
            <th>Información</th>
        </thead>
        <tbody>
            <tr>
                <td> <b>Día de Despacho</b> </td>
                <td>{!!$calendario->dia_despacho!!}</td>
            </tr>
            <tr>
                <td> <b>Lead Time</b> </td>
                <td>{!!$calendario->lead_time!!}</td>
            </tr>
            <tr>
                <td> <b>Tiempo de Entrega</b> </td>
                <td>{!!$calendario->tiempo_entrega!!}</td>
            </tr>
            <tr>
                <td> <b>Tienda</b> </td>
                <td>{!!$calendario->tienda_id!!}</td>
            </tr>
            <tr>
                <td> <b>Ultima Edición</b> </td>
                <td>
                    {!!$calendario->user['name']!!}
                    <br>
                    {!!$calendario->updated_at!!}
                </td>
            </tr>
        </tbody>
    </table>
</section>
@endsection