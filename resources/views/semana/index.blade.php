@extends('scaffold-interface.layouts.app')
@section('title','Index')
@section('content')

<section class="content">
    <h1>
        Semana Index
    </h1>
    <a href='{!!url("semana")!!}/create' class = 'btn btn-success'><i class="fa fa-plus"></i> New</a>
    <br>
    <br>
    <table class = "table table-striped table-bordered table-hover" style = 'background:#fff'>
        <thead>
            <th>dia_semana</th>
            <th>dia</th>
            <th>calendario_id</th>
            <th>actions</th>
        </thead>
        <tbody>
            @foreach($semanas as $semana) 
            <tr>
                <td>{!!$semana->dia_semana!!}</td>
                <td>{!!$semana->dia!!}</td>
                <td>{!!$semana->calendario_id!!}</td>
                <td>
                    <a data-toggle="modal" data-target="#myModal" class = 'delete btn btn-danger btn-xs' data-link = "/semana/{!!$semana->id!!}/deleteMsg" ><i class = 'fa fa-trash'> delete</i></a>
                    <a href = '#' class = 'viewEdit btn btn-primary btn-xs' data-link = '/semana/{!!$semana->id!!}/edit'><i class = 'fa fa-edit'> edit</i></a>
                    <a href = '#' class = 'viewShow btn btn-warning btn-xs' data-link = '/semana/{!!$semana->id!!}'><i class = 'fa fa-eye'> info</i></a>
                </td>
            </tr>
            @endforeach 
        </tbody>
    </table>
    {!! $semanas->render() !!}

</section>
@endsection