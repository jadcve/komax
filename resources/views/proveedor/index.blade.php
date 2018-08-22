@extends('scaffold-interface.layouts.app')
@section('title','Index')
@section('content')

<section class="content">
    <h1>
        Proveedor Index
    </h1>
    <a href='{!!url("proveedor")!!}/create' class = 'btn btn-success'><i class="fa fa-plus"></i> New</a>
    <br>
    <br>
    <table class = "table table-striped table-bordered table-hover" style = 'background:#fff'>
        <thead>
            <th>cod_prov</th>
            <th>nombre_prov</th>
            <th>leedt_prov</th>
            <th>tentrega_prov</th>
            <th>actions</th>
        </thead>
        <tbody>
            @foreach($proveedors as $proveedor) 
            <tr>
                <td>{!!$proveedor->cod_prov!!}</td>
                <td>{!!$proveedor->nombre_prov!!}</td>
                <td>{!!$proveedor->leedt_prov!!}</td>
                <td>{!!$proveedor->tentrega_prov!!}</td>
                <td>
                    <a data-toggle="modal" data-target="#myModal" class = 'delete btn btn-danger btn-xs' data-link = "/proveedor/{!!$proveedor->id!!}/deleteMsg" ><i class = 'fa fa-trash'> delete</i></a>
                    <a href = '#' class = 'viewEdit btn btn-primary btn-xs' data-link = '/proveedor/{!!$proveedor->id!!}/edit'><i class = 'fa fa-edit'> edit</i></a>
                    <a href = '#' class = 'viewShow btn btn-warning btn-xs' data-link = '/proveedor/{!!$proveedor->id!!}'><i class = 'fa fa-eye'> info</i></a>
                </td>
            </tr>
            @endforeach 
        </tbody>
    </table>
    {!! $proveedors->render() !!}

</section>
@endsection