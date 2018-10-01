@extends('scaffold-interface.layouts.app')
@section('title','Bodegas')
@section('content')

<section class="content">
    <h1>
        Detalles de {!!$bodega->bodega!!}
    </h1>
    <br>
    <a href='{!!url("bodega")!!}' class = 'btn btn-primary'><i class="fa fa-home"></i> Lista de Bodegas</a>
    <br>
    <table class = 'table table-bordered'>
        <thead>
            <th></th>
            <th>Información</th>
        </thead>
        <tbody>
            <tr>
                <td> <b>Código</b> </td>
                <td>{!!$bodega->cod_bodega!!}</td>
            </tr>
            <tr>
                <td> <b>Bodega</b> </td>
                <td>{!!$bodega->bodega!!}</td>
            </tr>
            <tr>
                <td> <b>Agrupacion1</b> </td>
                <td>{!!$bodega->agrupacion1!!}</td>
            </tr>
            <tr>
                <td> <b>Ciudad</b> </td>
                <td>{!!$bodega->ciudad!!}</td>
            </tr>
            <tr>
                <td> <b>Comuna</b> </td>
                <td>{!!$bodega->comuna!!}</td>
            </tr>
            <tr>
                <td> <b>Región</b> </td>
                <td>{!!$bodega->region!!}</td>
            </tr>
            <tr>
                <td> <b>Latitud</b> </td>
                <td>{!!$bodega->latitude!!}</td>
            </tr>
            <tr>
                <td> <b>Longitud</b> </td>
                <td>{!!$bodega->longitud!!}</td>
            </tr>
            <tr>
                <td> <b>Dirección</b> </td>
                <td>{!!$bodega->direccion!!}</td>
            </tr>
            <tr>
                <td> <b>Ultima Edición</b> </td>
                <td>
                    {!!$bodega->user['name']!!}
                    <br>
                    {!!$bodega->updated_at!!}
                </td>
            </tr>
        </tbody>
    </table>
</section>
@endsection