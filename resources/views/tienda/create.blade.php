@extends('scaffold-interface.layouts.app')
@section('title','Tiendas')
@section('content')

<section class="content">
    <h1>
        Crear Bodega
    </h1>
    <a href="{!!url('tienda')!!}" class = 'btn btn-primary pull-right'><i class="fa fa-home"></i> Lista de Tiendas</a>
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
                    <label for="tienda_id">Agrupacion1</label>
                        <select class="form-control" id="agrupacion1" name="agrupacion1">
                            <option  value="">Seleccione</option>
                            @foreach ($agrupaciones1 as $agrupacion1)
                                <option value="{!! $agrupacion1->agrupacion1 !!}">{!! $agrupacion1->agrupacion1 !!}</option>
                            @endforeach
                        </select>
                </div>
                <div class="form-group">
                    <label for="nuevo_agrupacion1">Nueva agrupacion1</label>
                    <input id="nuevo_agrupacion1" name = "nuevo_agrupacion1" type="text" class="form-control" placeholder="Agregar una Nueva Agrupacion1">
                </div>
                <div class="form-group">
                    <label for="ciudad">Ciudad</label>
                        <select class="form-control" id="ciudad" name="ciudad">
                            <option  value="">Seleccione</option>
                            @foreach ($ciudades as $ciudad)
                                <option value="{!! $ciudad->ciudad !!}">{!! $ciudad->ciudad !!}</option>
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
                                $com_tit = ($comuna->comuna == '') ? "Dejar en Blanco" : $comuna->comuna;
                                echo '<option value="'.$comuna->comuna.'">'.$com_tit.'</option>';
                            @endphp
                                {{-- <option value="{!! $comuna->comuna !!}">{!! $comuna->comuna !!}</option> --}}
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
                                <option value="{!! $region->region !!}">{!! $region->region !!}</option>
                            @endforeach
                        </select>
                </div>
                <div class="form-group">
                    <label for="nueva_region">Nueva Región</label>
                    <input id="nueva_region" name = "nueva_region" type="text" class="form-control" placeholder="Agregar una Nueva Región">
                </div>
                <div class="form-group">
                    <label for="latitude">Latitud</label>
                    <input id="latitude" name = "latitude" type="number" step="any" class="form-control" placeholder="Latitud" required>
                </div>
                <div class="form-group">
                    <label for="longitud">Longitud</label>
                    <input id="longitud" name = "longitud" type="number" step="any" class="form-control" placeholder="Longitud" required>
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