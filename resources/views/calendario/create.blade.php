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
                    <label for="semana">Día
                        <select name="semana" id="semana" class="form-control" required>
                            <option value="">Seleccione</option>
                            @foreach (General::dias() as $key => $dia)
                                <option value="{!!$key!!}">{!!$dia!!}</option>
                            @endforeach
                        </select>
                    </label>
                </div>
                <div class="form-group">
                    <label for="semana">Día de Despacho
                            <select name="dia_despacho" id="dia_despacho" class="form-control" required>
                                <option value="">Seleccione</option>
                                @foreach (General::dias() as $key => $dia)
                                    <option value="{!!$key!!}">{!!$dia!!}</option>
                                @endforeach
                            </select>
                        </label>
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
                    <label for="bodega_id">Bodega
                        <select class="form-control" id="bodega_id" name="bodega_id" required>
                            <option  value="">Seleccione</option>
                            @foreach ($bodegas as $bodega)
                                <option value="{!! $bodega->id !!}">{!! $bodega->bodega !!}</option>
                            @endforeach
                        </select>
                    </label>
                </div>
                <button class = 'btn btn-success' type ='submit'> <i class="fa fa-floppy-o"></i> Guardar</button>
            </form>
        </div>
    </div>
</section>
@endsection