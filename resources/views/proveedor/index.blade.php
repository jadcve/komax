@extends('scaffold-interface.layouts.app')
@section('title','Proveedores')
@section('content')

<section class="content">
    <h1>
        Modulo de Proveedores
    </h1>
    <a href='{!!url("proveedor")!!}/create' class = 'btn btn-success'><i class="fa fa-plus"></i> Crear Proveedor</a><br><br>
    {{-- <form style="display:inline-block;" method = 'POST' action = '{!!url("import")!!}' enctype="multipart/form-data"> --}}
        <div class="row">
            <div class="col-xs-12 col-md-4">
                <form style="display:inline-block; padding-right: 5px;" method = 'POST' action = '{!!url("proveedor/load")!!}' enctype="multipart/form-data">
                    <div class="form-group">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <label for="up_csv">Carga masiva por CSV</label>
                        <input type="file" class="form-control-file" id="up_csv" name="up_csv">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-upload" aria-hidden="true"></i> Cargar</button>
                    </div>
                </form>
            </div>
            <div class="col-xs-12 col-md-4">
                <form style="display:inline-block; padding-right: 5px;" method = 'POST' action = '{!!url("")!!}' enctype="multipart/form-data">
                    <div class="form-group">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <label for="">Descargar datos</label><br>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-download" aria-hidden="true"></i> Descargar</button>
                    </div>
                </form>
            </div>
            <div class="col-xs-12 col-md-4">
                <form style="display:inline-block; padding-right: 5px;" method = 'POST' action = '{!!url("")!!}' enctype="multipart/form-data">
                    <div class="form-group">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <button type="submit" class="btn btn-primary search-button"><i class="fa fa-search" aria-hidden="true"></i> Buscar</button>
                        <input type="text" class="form-control-file search-input" id="buscar" name="buscar">
                    </div>
                </form>
            </div>
        </div>
    <br>
    <br>
    <table class = "table table-striped table-bordered table-hover" style = 'background:#fff'>
        <thead>
            <th>Código Proveedor</th>
            <th>Nombre</th>
            <th>Leed Time</th>
            <th>Tiempo de entrega</th>
            <th>Editado</th>
            <th>Acciones</th>
        </thead>
        <tbody>
            @foreach($proveedors as $proveedor)
            <tr>
                <td>{!!$proveedor->codigo_proveedor!!}</td>
                <td>{!!$proveedor->descripcion_proveedor!!}</td>
                <td>{!!$proveedor->lead_time_proveedor!!}</td>
                <td>{!!$proveedor->tiempo_entrega_proveedor!!}</td>
                <td>
                        {!!$proveedor->user['name']!!}<span style="font-size:8px"><br>{!!$proveedor->updated_at!!}</span>
                 </td>
                <td>
                    <a href = '#' class = 'viewShow btn btn-warning btn-xs' data-link = '/proveedor/{!!$proveedor->id!!}'><i class = 'fa fa-eye'> Detalles</i></a>
                    <a href = '#' class = 'viewEdit btn btn-primary btn-xs' data-link = '/proveedor/{!!$proveedor->id!!}/edit'><i class = 'fa fa-edit'> Editar</i></a>
                    <a data-toggle="modal" data-target="#myModal" class = 'delete btn btn-danger btn-xs' data-link = "/proveedor/{!!$proveedor->id!!}/deleteMsg" ><i class = 'fa fa-trash'> Eliminar</i></a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {!! $proveedors->render() !!}

</section>
@endsection
