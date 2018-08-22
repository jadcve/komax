@extends('scaffold-interface.layouts.app')
@section('title','Show')
@section('content')

<section class="content">
    <h1>
        Show calendario
    </h1>
    <br>
    <a href='{!!url("calendario")!!}' class = 'btn btn-primary'><i class="fa fa-home"></i>Calendario Index</a>
    <br>
    <table class = 'table table-bordered'>
        <thead>
            <th>Key</th>
            <th>Value</th>
        </thead>
        <tbody>
            <tr>
                <td> <b>dia_despacho</b> </td>
                <td>{!!$calendario->dia_despacho!!}</td>
            </tr>
            <tr>
                <td> <b>lead_time</b> </td>
                <td>{!!$calendario->lead_time!!}</td>
            </tr>
            <tr>
                <td> <b>tiempo_entrega</b> </td>
                <td>{!!$calendario->tiempo_entrega!!}</td>
            </tr>
            <tr>
                <td> <b>tienda_id</b> </td>
                <td>{!!$calendario->tienda_id!!}</td>
            </tr>
        </tbody>
    </table>
</section>
@endsection