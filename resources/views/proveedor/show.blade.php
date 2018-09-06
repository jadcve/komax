@extends('scaffold-interface.layouts.app')
@section('title','Proveedores')
@section('content')

<section class="content">
    <h1>
        Show proveedor
    </h1>
    <br>
    <a href='{!!url("proveedor")!!}' class = 'btn btn-primary'><i class="fa fa-home"></i>Proveedor Index</a>
    <br>
    <table class = 'table table-bordered'>
        <thead>
            <th style="width:30%"></th>
            <th>Información</th>
        </thead>
        <tbody>
            <tr>
                <td> <b>Código del Proveedor</b> </td>
                <td>{!!$proveedor->codigo_proveedor!!}</td>
            </tr>
            <tr>
                <td> <b>Nombre del Proveedor</b> </td>
                <td>{!!$proveedor->descripcion_proveedor!!}</td>
            </tr>
            <tr>
                <td> <b>Leed Time del Proveedor</b> </td>
                <td>{!!$proveedor->lead_time_proveedor!!}</td>
            </tr>
            <tr>
                <td> <b>Tiempo de Entrega del Proveedor</b> </td>
                <td>{!!$proveedor->tiempo_entrega_proveedor!!}</td>
            </tr>
            <tr>
                <td> <b>Ultima Edición</b> </td>
                <td>
                    {!!$proveedor->user['name']!!}
                    <br>
                    {!!$proveedor->updated_at!!}
                </td>
            </tr>
        </tbody>
    </table>
</section>
@endsection