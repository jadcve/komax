@extends('scaffold-interface.layouts.app')
@section('title','Index')
@section('content')

<section class="content">
    <h1>Cálculo para Obtener los Despachos Sugeridos</h1>
    <br>
    {!! Form::open(['url' => 'sugerido', 'method'=>'POST', 'class'=>'form-inline']) !!}
        <div class="form-group" style="padding-right: 2vw;">
            {!! Form::label('fecha', 'Fecha'); !!}
            <br>
            <input class="form-control" id="fecha" name="fecha" type="date" required/>
        </div>
        <div class="form-group" style="padding-right: 2vw;">
            <label for="bodega">Bodega</label>
            <br>
            <select class="form-control" id="bodega" name="bodega" required>
                <option  value="">Seleccione</option>
                @foreach ($bodegas as $bodega)
                    <option value="{!! $bodega->bodega !!}">{!! $bodega->bodega !!}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <br>
            <button id="busca_sugerido" type="submit" class="btn btn-primary">Buscar</button>
        </div>
    {!! Form::close() !!}
</section>
<div id="loading_sugerido" class="loading_abc">
        <img src="{{URL::asset('/images/spinner.gif')}}" alt="" srcset="" style="width: 15vw;">
</div>
@endsection
