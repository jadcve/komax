@extends('scaffold-interface.layouts.app')
@section('title','Show')
@section('content')

<section class="content">
    <h1>
        Show nivel_servicio
    </h1>
    <br>
    <a href='{!!url("nivel_servicio")!!}' class = 'btn btn-primary'><i class="fa fa-home"></i>Nivel_servicio Index</a>
    <br>
    <table class = 'table table-bordered'>
        <thead>
            <th>Key</th>
            <th>Value</th>
        </thead>
        <tbody>
            <tr>
                <td> <b>letra</b> </td>
                <td>{!!$nivel_servicio->letra!!}</td>
            </tr>
            <tr>
                <td> <b>nivel_servicio</b> </td>
                <td>{!!$nivel_servicio->nivel_servicio!!}</td>
            </tr>
            <tr>
                <td> <b>descripcion</b> </td>
                <td>{!!$nivel_servicio->descripcion!!}</td>
            </tr>
        </tbody>
    </table>
</section>
@endsection