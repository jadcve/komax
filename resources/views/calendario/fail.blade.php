@extends('scaffold-interface.layouts.app')
@section('title','Proveedores')
@section('content')

<section class="content">
    <h1>
        <i class="fa fa-exclamation-triangle"aria-hidden="true" style="color: red;"></i> Error
    </h1>
    <div class="row">
        <div class="col-xs-12">
            <h2>{!!$message!!}</h2>
        </div>
    </div>
    <br>
    <a href='{!!url("calendario")!!}' class = 'btn btn-primary'><i class="fa fa-home"></i> Lista de Proveedores</a>
    <br><br>
</section>
@endsection