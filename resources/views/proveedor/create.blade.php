@extends('scaffold-interface.layouts.app')
@section('title','Create')
@section('content')

<section class="content">
    <h1>
        Agregar Proveedor
    </h1>
    <a href="{!!url('proveedor')!!}" class = 'btn btn-danger'><i class="fa fa-home"></i> Lista de Proveedores</a>
    <br>
    <form method = 'POST' action = '{!!url("proveedor")!!}'>
        <input type = 'hidden' name = '_token' value = '{{Session::token()}}'>
        <div class="form-group">
            <label for="cod_prov">Código de Proveedor</label>
            <input id="cod_prov" name = "cod_prov" type="text" class="form-control" required placeholder="Código de Proveedor">
        </div>
        <div class="form-group">
            <label for="nombre_prov">Nombre del Proveedor</label>
            <input id="nombre_prov" name = "nombre_prov" type="text" class="form-control" required placeholder="Nombre del Proveedor">
        </div>
        <div class="form-group">
            <label for="leedt_prov">Leed Time Proveedor</label>
            <input id="leedt_prov" name = "leedt_prov" type="text" class="form-control" required placeholder="Leed Time Proveedor">
        </div>
        <div class="form-group">
            <label for="tentrega_prov">Tiempo de entrega de Proveedor</label>
            <input id="tentrega_prov" name = "tentrega_prov" type="text" class="form-control" required placeholder="Tiempo de entrega de Proveedor">
        </div>
        <button class = 'btn btn-success' type ='submit'> <i class="fa fa-floppy-o"></i> Guardar</button>
    </form>
</section>
@endsection