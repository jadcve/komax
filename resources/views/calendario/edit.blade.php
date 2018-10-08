@extends('scaffold-interface.layouts.app')
@section('title','Edit')
@section('content')

<section class="content">
    <h1>
        Calendario Edición
    </h1>
    <a href="{!!url('calendario')!!}" class = 'btn btn-primary pull-right'><i class="fa fa-home"></i> Calendario Lista</a>
    <br>
    <div class="row">
        <div class="col-xs-12 col-md-6 col-md-offset-3">
            <form method = 'POST' action = '{!! url("calendario")!!}/{!!$calendario->
                id!!}/update'> 
                <input type = 'hidden' name = '_token' value = '{{Session::token()}}'>
                <div class="form-group">
                    <label for="semana">Día
                        <select name="semana" id="semana" class="form-control" required>
                            <option value="">Seleccione</option>
                            @foreach (General::dias() as $key => $dia)
                                @php
                                    $selected = ($calendario->dia == $key) ? 'selected' : '';
                                @endphp
                                <option value="{!! $key !!}" {!! $selected !!}>{!! $dia !!}</option>
                            @endforeach
                        </select>
                    </label>
                </div>
                <div class="form-group">
                    <label for="dia_despacho">Día de Despacho
                            <select name="dia_despacho" id="dia_despacho" class="form-control" required>
                                <option value="">Seleccione</option>
                                @foreach (General::dias() as $key => $dia)
                                    @php
                                        $selected = ($calendario->dia_despacho == $key) ? 'selected' : '';
                                    @endphp
                                    <option value="{!! $key !!}" {!! $selected !!}>{!! $dia !!}</option>
                                @endforeach
                            </select>
                        </label>
                </div>
                <div class="form-group">
                    <label for="lead_time">Lead Time</label>
                    <input id="lead_time" name = "lead_time" type="number" class="form-control" value="{!!$calendario->
                    lead_time!!}" required placeholder="Lead Time"> 
                </div>
                <div class="form-group">
                    <label for="tiempo_entrega">Tiempo de Entrega</label>
                    <input id="tiempo_entrega" name = "tiempo_entrega" type="number" class="form-control" value="{!!$calendario->tiempo_entrega!!}" required placeholder="Tiempo de Entrega"> 
                </div>
                <div class="form-group">
                    <label for="bodega_id">Bodega
                    <select class="form-control" id="bodega_id" name="bodega_id" required>
                        <option  value="">Seleccione</option>
                        @foreach ($bodegas as $bodega)
                        @php
                            $selected = ($calendario->bodega_id == $bodega->id) ? 'selected' : '';
                        @endphp
                            <option value="{!! $bodega->id !!}" {!! $selected !!}>{!! $bodega->bodega !!}</option>
                        @endforeach
                    </select>
                    </label>
                </div>
                <button class = 'btn btn-success' type ='submit'><i class="fa fa-floppy-o"></i> Guardar</button>
            </form>
        </div>
    </div>
</section>
@endsection