@extends('scaffold-interface.layouts.app')
@section('title','Show')
@section('content')

<section class="content">
    <h1>
        Show semana
    </h1>
    <br>
    <a href='{!!url("semana")!!}' class = 'btn btn-primary'><i class="fa fa-home"></i>Semana Index</a>
    <br>
    <table class = 'table table-bordered'>
        <thead>
            <th>Key</th>
            <th>Value</th>
        </thead>
        <tbody>
            <tr>
                <td> <b>dia_semana</b> </td>
                <td>{!!$semana->dia_semana!!}</td>
            </tr>
            <tr>
                <td> <b>dia</b> </td>
                <td>{!!$semana->dia!!}</td>
            </tr>
            <tr>
                <td> <b>calendario_id</b> </td>
                <td>{!!$semana->calendario_id!!}</td>
            </tr>
        </tbody>
    </table>
</section>
@endsection