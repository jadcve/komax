@extends('scaffold-interface.layouts.app')
@section('title','Index')
@section('content')

<section class="content">
    <h1>Cálculos para Obtener el ABC</h1>
    <br>
    {!! Form::open(['url' => 'tran', 'method'=>'POST', 'class'=>'form-inline']) !!}
        <div class="form-group">
            {!! Form::label('fecha_inicial', 'Fecha Inicial'); !!}
            <br>
            <input class="form-control" id="fechaInicial" name="fechaInicial"    type="date" required/>
        </div>
        <div class="form-group">
            {!! Form::label('fecha_final', 'Fecha Final'); !!}
            <br>
            <input class="form-control" id="fechaFinal" name="fechaFinal"   type="date" required/>
        </div>
        <div class="form-group">
            <label for="agrupacion1">Agrupacion1</label>
            <br>
            <select name="agrupacion1" id="agrupacion1" class="form-control" required>
                <option  value="">Seleccione</option>
                @foreach ($agrupaciones1 as $agrupacion1)
                    <option value="{!! $agrupacion1->agrupacion1 !!}">{!! $agrupacion1->agrupacion1 !!}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Marca</label>
            <br>
            <select name="marca" id="marca" class="form-control" required>
            </select>
        </div>
        <div class="form-group">
            {!! Form::label('a', 'Clas. A'); !!}
            <br>
            {!! Form::number('a', null, ['class'=>'form-control', 'required'])!!}
        </div>
        <div class="form-group">
            {!! Form::label('b', 'Clas. B'); !!}
            <br>
            {!! Form::number('b', null, ['class'=>'form-control', 'required'])!!}
        </div>
        <div class="form-group"><br>
            <button id="busca_abc" type="submit" class="btn btn-primary">Buscar</button>
        </div>
    {!! Form::close() !!}
</section>
<div id="loading_abc" class="loading_abc">
        <img src="{{URL::asset('/images/spinner.gif')}}" alt="" srcset="" style="width: 15vw;">
</div>
@endsection
