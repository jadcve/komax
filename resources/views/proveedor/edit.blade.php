@extends('scaffold-interface.layouts.app')
@section('title','Edit')
@section('content')

<section class="content">
    <h1>
        Editar proveedor {!!$proveedor->nombre_prov!!}
    </h1>
    <a href="{!!url('proveedor')!!}" class = 'btn btn-primary pull-right'><i class="fa fa-home"></i>Lista de Proveedores</a>
    <br>
    <div class="row">
        <div class="col-xs-12 col-md-6 col-md-offset-3">
            <form method = 'POST' action = '{!! url("proveedor")!!}/{!!$proveedor->
                id!!}/update'> 
                <input type = 'hidden' name = '_token' value = '{{Session::token()}}'>
                <div class="form-group">
                    <label for="cod_prov">Código de Proveedor</label>
                    <input id="cod_prov" name = "cod_prov" type="text" class="form-control" value="{!!$proveedor->
                    cod_prov!!}" required placeholder="Código de Proveedor"> 
                </div>
                <div class="form-group">
                    <label for="nombre_prov">Nombre del Proveedor</label>
                    <input id="nombre_prov" name = "nombre_prov" type="text" class="form-control" value="{!!$proveedor->
                    nombre_prov!!}" required placeholder="Nombre del Proveedor"> 
                </div>
                <div class="form-group">
                    <label for="leedt_prov">Leed Time Proveedor</label>
                    <input id="leedt_prov" name = "leedt_prov" type="text" class="form-control" value="{!!$proveedor->
                    leedt_prov!!}" required placeholder="Leed Time Proveedor"> 
                </div>
                <div class="form-group">
                    <label for="tentrega_prov">Tiempo de entrega de Proveedor</label>
                    <input id="tentrega_prov" name = "tentrega_prov" type="text" class="form-control" value="{!!$proveedor->tentrega_prov!!}" required placeholder="Tiempo de entrega de Proveedor"> 
                </div>
                <button class = 'btn btn-success' type ='submit'><i class="fa fa-floppy-o"></i> Guardar</button>
            </form>
        </div>
    </div>
</section>
@endsection