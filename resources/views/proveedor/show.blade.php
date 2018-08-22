@extends('scaffold-interface.layouts.app')
@section('title','Show')
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
            <th>Key</th>
            <th>Value</th>
        </thead>
        <tbody>
            <tr>
                <td> <b>cod_prov</b> </td>
                <td>{!!$proveedor->cod_prov!!}</td>
            </tr>
            <tr>
                <td> <b>nombre_prov</b> </td>
                <td>{!!$proveedor->nombre_prov!!}</td>
            </tr>
            <tr>
                <td> <b>leedt_prov</b> </td>
                <td>{!!$proveedor->leedt_prov!!}</td>
            </tr>
            <tr>
                <td> <b>tentrega_prov</b> </td>
                <td>{!!$proveedor->tentrega_prov!!}</td>
            </tr>
        </tbody>
    </table>
</section>
@endsection