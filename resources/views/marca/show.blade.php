@extends('scaffold-interface.layouts.app')
@section('title','Show')
@section('content')

<section class="content">
    <h1>
        Show marca
    </h1>
    <br>
    <a href='{!!url("marca")!!}' class = 'btn btn-primary'><i class="fa fa-home"></i>Marca Index</a>
    <br>
    <table class = 'table table-bordered'>
        <thead>
            <th>Key</th>
            <th>Value</th>
        </thead>
        <tbody>
            <tr>
                <td> <b>agrupacion1</b> </td>
                <td>{!!$marca->agrupacion1!!}</td>
            </tr>
            <tr>
                <td> <b>marca</b> </td>
                <td>{!!$marca->marca!!}</td>
            </tr>
        </tbody>
    </table>
</section>
@endsection