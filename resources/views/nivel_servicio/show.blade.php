@extends('scaffold-interface.layouts.app')
@section('title','Nivel de Servicio')
@section('content')

<section class="content">
    <h1>
        Nivel de Servicio Detallado
    </h1>
    <br>
    <a href='{!!url("nivel_servicio")!!}' class = 'btn btn-primary'><i class="fa fa-home"></i>Lista de  Niveles de Servicio</a>
    <br>
    <table class = 'table table-bordered'>
        <thead>
            <th style="width:30%"></th>
            <th>Información</th>
        </thead>
        <tbody>
            <tr>
                <td> <b>Clasificación</b> </td>
                <td>{!!$nivel_servicio->letra!!}</td>
            </tr>
            <tr>
                <td> <b>Nivel de Servicio</b> </td>
                <td>{!!$nivel_servicio->nivel_servicio!!}</td>
            </tr>
            <tr>
                <td> <b>Descripción</b> </td>
                <td>{!!$nivel_servicio->descripcion!!}</td>
            </tr>
        </tbody>
    </table>
</section>
@endsection