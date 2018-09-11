@extends('scaffold-interface.layouts.app')
@section('title','Edit')
@section('content')

<section class="content">
    <h1>
        Editar proveedor {!!$proveedor->descripcion_proveedor!!}
    </h1>
    <a href="{!!url('proveedor')!!}" class = 'btn btn-primary pull-right'><i class="fa fa-home"></i> Lista de Proveedores</a>
    <br>
    <div class="row">
        <div class="col-xs-12 col-md-6 col-md-offset-3">
            <form method = 'POST' action = '{!! url("proveedor")!!}/{!!$proveedor->
                id!!}/update'> 
                <input type = 'hidden' name = '_token' value = '{{Session::token()}}'>
                <div class="form-group">
                    <label for="codigo_proveedor">Código de Proveedor</label>
                    <input id="codigo_proveedor" name = "codigo_proveedor" type="text" class="form-control" value="{!!$proveedor->codigo_proveedor!!}" required placeholder="Código de Proveedor"> 
                </div>
                <div class="form-group">
                    <label for="descripcion_proveedor">Nombre del Proveedor</label>
                    <input id="descripcion_proveedor" name = "descripcion_proveedor" type="text" class="form-control" value="{!!$proveedor->descripcion_proveedor!!}" required placeholder="Nombre del Proveedor"> 
                </div>
                <div class="form-group">
                    <label for="lead_time_proveedor">Lead Time Proveedor</label>
                    <input id="lead_time_proveedor" name = "lead_time_proveedor" type="text" class="form-control" value="{!!$proveedor->lead_time_proveedor!!}" required placeholder="Leed Time Proveedor"> 
                </div>
                <div class="form-group">
                    <label for="tiempo_entrega_proveedor">Tiempo de entrega de Proveedor</label>
                    <input id="tiempo_entrega_proveedor" name = "tiempo_entrega_proveedor" type="text" class="form-control" value="{!!$proveedor->tiempo_entrega_proveedor!!}" required placeholder="Tiempo de entrega de Proveedor"> 
                </div>
                <button class = 'btn btn-success' type ='submit'><i class="fa fa-floppy-o"></i> Guardar</button>
            </form>
        </div>
    </div>
</section>
@endsection