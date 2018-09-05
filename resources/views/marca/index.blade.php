@extends('scaffold-interface.layouts.app')
@section('title','Index')
@section('content')

<section class="content">
    <h1>
        Marca Index
    </h1>
    <a href='{!!url("marca")!!}/create' class = 'btn btn-success'><i class="fa fa-plus"></i> New</a>
    <br>
    <br>
    <table class = "table table-striped table-bordered table-hover" style = 'background:#fff'>
        <thead>
            <th>canal</th>
            <th>marca</th>
            <th>actions</th>
        </thead>
        <tbody>
            @foreach($marcas as $marca) 
            <tr>
                <td>{!!$marca->canal!!}</td>
                <td>{!!$marca->marca!!}</td>
                <td>
                    <a data-toggle="modal" data-target="#myModal" class = 'delete btn btn-danger btn-xs' data-link = "/marca/{!!$marca->id!!}/deleteMsg" ><i class = 'fa fa-trash'> delete</i></a>
                    <a href = '#' class = 'viewEdit btn btn-primary btn-xs' data-link = '/marca/{!!$marca->id!!}/edit'><i class = 'fa fa-edit'> edit</i></a>
                    <a href = '#' class = 'viewShow btn btn-warning btn-xs' data-link = '/marca/{!!$marca->id!!}'><i class = 'fa fa-eye'> info</i></a>
                </td>
            </tr>
            @endforeach 
        </tbody>
    </table>
    {!! $marcas->render() !!}

</section>
@endsection