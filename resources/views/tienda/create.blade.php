@extends('scaffold-interface.layouts.app')
@section('title','Tiendas')
@section('content')

<section class="content">
    <h1>
        Crear Bodega
    </h1>
    <a href="{!!url('tienda')!!}" class = 'btn btn-primary pull-right'><i class="fa fa-home"></i> Lista</a>
    <br>
    <div class="row">
        <div class="col-xs-12 col-md-6 col-md-offset-3">
            <form method = 'POST' action = '{!!url("tienda")!!}'>
                <input type = 'hidden' name = '_token' value = '{{Session::token()}}'>
                <div class="form-group">
                    <label for="cod_tienda">Código Tienda</label>
                    <input id="cod_tienda" name = "cod_tienda" type="text" class="form-control" placeholder="Código Tienda">
                </div>
                <div class="form-group">
                    <label for="bodega">Bodega</label>
                    <input id="bodega" name = "bodega" type="text" class="form-control" placeholder="Bodega" required>
                </div>
                <div class="form-group">
                    <label for="canal">Canal</label>
                    <input id="canal" name = "canal" type="text" class="form-control" placeholder="Canal" required>
                </div>
                <div class="form-group">
                    <label for="ciudad">Ciudad</label>
                    <input id="ciudad" name = "ciudad" type="text" class="form-control" placeholder="Ciudad" required>
                </div>
                <div class="form-group">
                    <label for="comuna">Comuna</label>
                    <input id="comuna" name = "comuna" type="text" class="form-control" placeholder="Comuna">
                </div>
                <div class="form-group">
                    <label for="region">Región</label>
                    <input id="region" name = "region" type="text" class="form-control" placeholder="Región" required>
                </div>
                <div class="form-group">
                    <label for="latitude">Latitud</label>
                    <input id="latitude" name = "latitude" type="text" class="form-control" placeholder="Latitud" required>
                </div>
                <div class="form-group">
                    <label for="longitud">Longitud</label>
                    <input id="longitud" name = "longitud" type="text" class="form-control" placeholder="Longitud" required>
                </div>
                <div class="form-group">
                    <label for="direccion">Dirección</label>
                    <input id="direccion" name = "direccion" type="text" class="form-control" placeholder="Dirección" required>
                </div>
                <button class = 'btn btn-success pull-right' type ='submit'> <i class="fa fa-floppy-o"></i> Guardar</button>
            </form>
        </div>
    </div>
</section>
@endsection