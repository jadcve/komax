@extends('scaffold-interface.layouts.app')
@section('title','Show')
@section('content')

<section class="content">
    <h1>
        Show tienda
    </h1>
    <br>
    <a href='{!!url("tienda")!!}' class = 'btn btn-primary'><i class="fa fa-home"></i>Tienda Index</a>
    <br>
    <table class = 'table table-bordered'>
        <thead>
            <th>Key</th>
            <th>Value</th>
        </thead>
        <tbody>
            <tr>
                <td> <b>cod_tienda</b> </td>
                <td>{!!$tienda->cod_tienda!!}</td>
            </tr>
            <tr>
                <td> <b>bodega</b> </td>
                <td>{!!$tienda->bodega!!}</td>
            </tr>
            <tr>
                <td> <b>canal</b> </td>
                <td>{!!$tienda->canal!!}</td>
            </tr>
            <tr>
                <td> <b>ciudad</b> </td>
                <td>{!!$tienda->ciudad!!}</td>
            </tr>
            <tr>
                <td> <b>comuna</b> </td>
                <td>{!!$tienda->comuna!!}</td>
            </tr>
            <tr>
                <td> <b>region</b> </td>
                <td>{!!$tienda->region!!}</td>
            </tr>
            <tr>
                <td> <b>latitude</b> </td>
                <td>{!!$tienda->latitude!!}</td>
            </tr>
            <tr>
                <td> <b>longitud</b> </td>
                <td>{!!$tienda->longitud!!}</td>
            </tr>
            <tr>
                <td> <b>direccion</b> </td>
                <td>{!!$tienda->direccion!!}</td>
            </tr>
        </tbody>
    </table>
</section>
@endsection