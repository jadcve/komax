@extends('scaffold-interface.layouts.app')
@section('title','Error')
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
    <a href='{!!url("tienda")!!}' class = 'btn btn-primary'><i class="fa fa-home"></i> Lista de tiendas</a>
    <br><br>
</section>
@endsection