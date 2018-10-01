@extends('scaffold-interface.layouts.app')
@section('title','Edit')
@section('content')

<section class="content">
    <h1>
        Editar {!!$tienda->bodega!!}
    </h1>
    <a href="{!!url('tienda')!!}" class = 'btn btn-primary pull-right'><i class="fa fa-home"></i> Lista de Tiendas</a>
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
                    <label for="tienda_id">Agrupacion1</label>
                        <select class="form-control" id="agrupacion1" name="agrupacion1">
                            <option  value="">Seleccione</option>
                            @foreach ($agrupaciones1 as $agrupacion1)
                            @php
                                $selected = ($tienda->agrupacion1 == $agrupacion1->agrupacion1) ? ' selected' : '';
                                echo '<option value="'.$agrupacion1->agrupacion1.'"'.$selected.'>'.$agrupacion1->agrupacion1.'</option>';
                            @endphp
                            @endforeach
                        </select>
                </div>
                <div class="form-group">
                    <label for="nuevo_agrupacion1">Nueva Agrupacion1</label>
                    <input id="nuevo_agrupacion1" name = "nuevo_agrupacion1" type="text" class="form-control" placeholder="Agregar una Nueva Agrupacion1">
                </div>
                <div class="form-group">
                    <label for="ciudad">Ciudad</label>
                        <select class="form-control" id="ciudad" name="ciudad">
                            <option  value="">Seleccione</option>
                            @foreach ($ciudades as $ciudad)
                            @php
                                $selected = ($tienda->ciudad == $ciudad->ciudad) ? ' selected' : '';
                                echo '<option value="'.$ciudad->ciudad.'"'.$selected.'>'.$ciudad->ciudad.'</option>';
                            @endphp
                            @endforeach
                        </select>
                </div>
                <div class="form-group">
                    <label for="nueva_ciudad">Nueva Ciudad</label>
                    <input id="nueva_ciudad" name = "nueva_ciudad" type="text" class="form-control" placeholder="Agregar una Nueva Ciudad">
                </div>
                <div class="form-group">
                    <label for="comuna">Comuna</label>
                        <select class="form-control" id="comuna" name="comuna">
                            <option  value="">Seleccione</option>
                            @foreach ($comunas as $comuna)
                            @php
                                $selected = ($tienda->comuna == $comuna->comuna) ? ' selected' : '';
                                $com_tit = ($comuna->comuna == '') ? "Dejar en Blanco" : $comuna->comuna;
                                echo '<option value="'.$comuna->comuna.'"'.$selected.'>'.$com_tit.'</option>';
                            @endphp
                            @endforeach
                        </select>
                </div>
                <div class="form-group">
                    <label for="nueva_comuna">Nueva Comuna</label>
                    <input id="nueva_comuna" name = "nueva_comuna" type="text" class="form-control" placeholder="Agregar una Nueva Comuna">
                </div>
                <div class="form-group">
                    <label for="region">Región</label>
                        <select class="form-control" id="region" name="region">
                            <option  value="">Seleccione</option>
                            @foreach ($regiones as $region)
                            @php
                                $selected = ($tienda->region == $region->region) ? ' selected' : '';
                                echo '<option value="'.$region->region.'"'.$selected.'>'.$region->region.'</option>';
                            @endphp
                            @endforeach
                        </select>
                </div>
                <div class="form-group">
                    <label for="nueva_region">Nueva Región</label>
                    <input id="nueva_region" name = "nueva_region" type="text" class="form-control" placeholder="Agregar una Nueva Región">
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