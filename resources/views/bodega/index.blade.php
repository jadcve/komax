@extends('scaffold-interface.layouts.app')
@section('title','Bodegas')
@section('content')

<section class="content">
    <h1>
        Bodegas
    </h1>
    <a href='{!!url("bodega")!!}/create' class = 'btn btn-success'><i class="fa fa-plus"></i> Crear Bodega</a>
    <br><br>
    <div class="row">
            <div class="col-xs-12 col-md-4">
                <form style="display:inline-block; padding-right: 5px;" method = 'POST' action = '{!!url("bodega/load")!!}' enctype="multipart/form-data">
                    <div class="form-group">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <label for="up_csv">Carga masiva por CSV</label>
                        <input type="file" class="form-control-file" id="up_csv" name="up_csv" required>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-upload" aria-hidden="true"></i> Cargar</button>
                    </div>
                </form>
            </div>
            <div class="col-xs-12 col-md-4">
                <form style="display:inline-block; padding-right: 5px;" method = 'POST' action = '{!!url("bodega/download")!!}' enctype="multipart/form-data">
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
                        <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}" autofocus>
                        <button type="submit" id="buscar_btn" class="btn btn-primary search-button"><i class="fa fa-search" aria-hidden="true"></i> Buscar</button>
                        <input type="text" class="form-control-file search-input" id="buscar" name="buscar">
                    </div>
                </form>
            </div>
        </div>
    <br><br>
    <table  class = "table table-striped table-bordered table-hover" style = 'background:#fff'>
        <thead>
            <th>Código</th>
            <th>Bodega</th>
            <th>Agrupacion1</th>
            <th>Ciudad</th>
            <th>Comuna</th>
            <th>Región</th>
            <th>Latitud</th>
            <th>Longitud</th>
            <th>Dirección</th>
            <th>Editado</th>
            <th style="width: 5%;"></th>
        </thead>
        <tbody>
            @foreach($bodegas as $bodega)
            <tr>
                <td>{!!$bodega->cod_bodega!!}</td>
                <td>{!!$bodega->bodega!!}</td>
                <td>{!!$bodega->agrupacion1!!}</td>
                <td>{!!$bodega->ciudad!!}</td>
                <td>{!!$bodega->comuna!!}</td>
                <td>{!!$bodega->region!!}</td>
                <td>{!!$bodega->latitude!!}</td>
                <td>{!!$bodega->longitud!!}</td>
                <td>{!!$bodega->direccion!!}</td>
                <td>
                       {!!$bodega->user['name']!!}<span style="font-size:8px"><br>{!!$bodega->updated_at!!}</span>
                </td>
                <td>
                        <a href = '#' class = 'viewShow btn btn-warning btn-xs' data-link = '/bodega/{!!$bodega->id!!}'><i class = 'fa fa-eye'> Detalles</i></a>
                        <a href = '#' class = 'viewEdit btn btn-primary btn-xs' data-link = '/bodega/{!!$bodega->id!!}/edit'><i class = 'fa fa-edit'> Editar</i></a>
                        <a data-toggle="modal" data-target="#myModal" class = 'delete btn btn-danger btn-xs' data-link = "/bodega/{!!$bodega->id!!}/deleteMsg" ><i class = 'fa fa-trash'> Eliminar</i></a>    
                </td>
            </tr>
            @endforeach 
        </tbody>
    </table>
    {!! $bodegas->render() !!}

</section>
@endsection