@extends('scaffold-interface.layouts.app')
@section('title','Create')
@section('content')

<section class="content">
    <h1>
        Agregar Información al Calendario
    </h1>
    <a href="{!!url('calendario')!!}" class = 'btn btn-primary pull-right'><i class="fa fa-home"></i> Calendario Lista</a>
    <br>
    <div class="row">
        <div class="col-xs-12 col-md-6 col-md-offset-3">
            <form method = 'POST' action = '{!!url("calendario")!!}'>
                <input type = 'hidden' name = '_token' value = '{{Session::token()}}'>
                <div class="form-group">
                    <label for="semana">
                        <select name="semana" id="semana" class="form-control">
                            <option value="">Seleccione</option>
                            @foreach ($semanas as $semana)
                                <option value="{!!$semana->dia_semana!!}">{!!$semana->dia!!}</option>
                            @endforeach
                        </select>
                    </label>
                </div>
                <div class="form-group">
                    <label for="dia_despacho">Día de Despacho</label>
                    <input id="dia_despacho" name = "dia_despacho" type="number" class="form-control" required placeholder="Día de Despacho">
                </div>
                <div class="form-group">
                    <label for="lead_time">Lead Time</label>
                    <input id="lead_time" name = "lead_time" type="number" class="form-control" required placeholder="Lead Time">
                </div>
                <div class="form-group">
                    <label for="tiempo_entrega">Tiempo de Entrega</label>
                    <input id="tiempo_entrega" name = "tiempo_entrega" type="number" class="form-control" required placeholder="Tiempo de Entrega">
                </div>
                <div class="form-group">
                    <label for="tienda_id">Tienda</label>
                        <select class="form-control" id="tienda_id" name="tienda_id">
                            <option  value="">Seleccione</option>
                            @foreach ($tiendas as $tienda)
                                <option value="{!! $tienda->id !!}">{!! $tienda->bodega !!}</option>
                            @endforeach
                        </select>
                </div>
                <button class = 'btn btn-success' type ='submit'> <i class="fa fa-floppy-o"></i> Guardar</button>
            </form>
        </div>
    </div>
</section>
@endsection