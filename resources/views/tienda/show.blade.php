@extends('scaffold-interface.layouts.app')
@section('title','Tiendas')
@section('content')

<section class="content">
    <h1>
        Detalles de {!!$tienda->bodega!!}
    </h1>
    <br>
    <a href='{!!url("tienda")!!}' class = 'btn btn-primary'><i class="fa fa-home"></i>Lista</a>
    <br>
    <table class = 'table table-bordered'>
        <thead>
            <th></th>
            <th>Información</th>
        </thead>
        <tbody>
            <tr>
                <td> <b>Código</b> </td>
                <td>{!!$tienda->cod_tienda!!}</td>
            </tr>
            <tr>
                <td> <b>Bodega</b> </td>
                <td>{!!$tienda->bodega!!}</td>
            </tr>
            <tr>
                <td> <b>Canal</b> </td>
                <td>{!!$tienda->canal!!}</td>
            </tr>
            <tr>
                <td> <b>Ciudad</b> </td>
                <td>{!!$tienda->ciudad!!}</td>
            </tr>
            <tr>
                <td> <b>Comuna</b> </td>
                <td>{!!$tienda->comuna!!}</td>
            </tr>
            <tr>
                <td> <b>Región</b> </td>
                <td>{!!$tienda->region!!}</td>
            </tr>
            <tr>
                <td> <b>Latitud</b> </td>
                <td>{!!$tienda->latitude!!}</td>
            </tr>
            <tr>
                <td> <b>Longitud</b> </td>
                <td>{!!$tienda->longitud!!}</td>
            </tr>
            <tr>
                <td> <b>Dirección</b> </td>
                <td>{!!$tienda->direccion!!}</td>
            </tr>
            <tr>
                <td> <b>Ultima Edición</b> </td>
                <td>
                    {!!$tienda->user['name']!!}
                    <br>
                    {!!$tienda->updated_at!!}
                </td>
            </tr>
        </tbody>
    </table>
</section>
@endsection