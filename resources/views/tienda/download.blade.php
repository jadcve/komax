@extends('scaffold-interface.layouts.app')
@section('title','Descarga de datos')
@section('content')

<section class="content">
    <h1>
        <i class="fa fa-download" aria-hidden="true"></i> Descarga de datos de Tiendas
    </h1>
    <div class="row">
        <div class="col-xs-12">
            <h2>La descarga automática iniciará pronto</h2>
        </div>
    </div>
    <br>
    <a href='{!!url("tienda")!!}' class = 'btn btn-primary'><i class="fa fa-home"></i> Lista de Tiendas</a>
    <br><br>
</section>
@endsection