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
                    <label for="dia_despacho">Día de Despacho</label>
                    <input id="dia_despacho" name = "dia_despacho" type="text" class="form-control" required placeholder="Día de Despacho">
                </div>
                <div class="form-group">
                    <label for="lead_time">Lead Time</label>
                    <input id="lead_time" name = "lead_time" type="text" class="form-control" required placeholder="Lead Time">
                </div>
                <div class="form-group">
                    <label for="tiempo_entrega">Tiempo de Entrega</label>
                    <input id="tiempo_entrega" name = "tiempo_entrega" type="text" class="form-control" required placeholder="Tiempo de Entrega">
                </div>
                <div class="form-group">
                    <label for="tienda_id">Tienda</label>
                    <input id="tienda_id" name = "tienda_id" type="text" class="form-control" required placeholder="Tienda">
                </div>
                <button class = 'btn btn-success' type ='submit'> <i class="fa fa-floppy-o"></i> Guardar</button>
            </form>
        </div>
    </div>
</section>
@endsection