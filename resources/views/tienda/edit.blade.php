@extends('scaffold-interface.layouts.app')
@section('title','Edit')
@section('content')

<section class="content">
    <h1>
        Editar {!!$tienda->bodega!!}
    </h1>
    <a href="{!!url('tienda')!!}" class = 'btn btn-primary pull-right'><i class="fa fa-home"></i>Lista</a>
    <br>
    <div class="row">
        <div class="col-xs-12 col-md-6 col-md-offset-3">
            <form method = 'POST' action = '{!! url("tienda")!!}/{!!$tienda->
                id!!}/update'> 
                <input type = 'hidden' name = '_token' value = '{{Session::token()}}'>
                <div class="form-group">
                    <label for="cod_tienda">Código</label>
                    <input id="cod_tienda" name = "cod_tienda" type="text" class="form-control" value="{!!$tienda->
                    cod_tienda!!}" placeholder="Código"> 
                </div>
                <div class="form-group">
                    <label for="bodega">Bodega</label>
                    <input id="bodega" name = "bodega" type="text" class="form-control" value="{!!$tienda->
                    bodega!!}" required placeholder="Bodega"> 
                </div>
                <div class="form-group">
                    <label for="canal">Canal</label>
                    <input id="canal" name = "canal" type="text" class="form-control" value="{!!$tienda->
                    canal!!}" required placeholder="Canal"> 
                </div>
                <div class="form-group">
                    <label for="ciudad">Ciudad</label>
                    <input id="ciudad" name = "ciudad" type="text" class="form-control" value="{!!$tienda->
                    ciudad!!}" required placeholder="Ciudad"> 
                </div>
                <div class="form-group">
                    <label for="comuna">Comuna</label>
                    <input id="comuna" name = "comuna" type="text" class="form-control" value="{!!$tienda->
                    comuna!!}" placeholder="Comuna"> 
                </div>
                <div class="form-group">
                    <label for="region">Región</label>
                    <input id="region" name = "region" type="text" class="form-control" value="{!!$tienda->
                    region!!}" required placeholder="Región"> 
                </div>
                <div class="form-group">
                    <label for="latitude">Latitud</label>
                    <input id="latitude" name = "latitude" type="text" class="form-control" value="{!!$tienda->
                    latitude!!}" required placeholder="Latitud"> 
                </div>
                <div class="form-group">
                    <label for="longitud">Longitud</label>
                    <input id="longitud" name = "longitud" type="text" class="form-control" value="{!!$tienda->
                    longitud!!}" required placeholder="Longitud"> 
                </div>
                <div class="form-group">
                    <label for="direccion">Dirección</label>
                    <input id="direccion" name = "direccion" type="text" class="form-control" value="{!!$tienda->
                    direccion!!}" required placeholder="Dirección"> 
                </div>
                <button class = 'btn btn-success pull-right type ='submit'><i class="fa fa-floppy-o"></i> Guardar</button>
            </form>
         </div>
    </div>
</section>
@endsection