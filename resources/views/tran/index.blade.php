@extends('scaffold-interface.layouts.app')
@section('title','Index')
@section('content')

<section class="content">
    <h1>Cálculos para Obtener el ABC</h1>
    <br>
    {!! Form::open(['url' => 'tran', 'method'=>'POST', 'class'=>'form-inline abc']) !!}
        <div class="form-group">
            <label for="agrupacion1">Agrupacion1</label>
            <br>
            <div class="checkbox box-multiple">
                @foreach ($agrupaciones1 as $agrupacion1)
                    <label><input name="agrupacion1" type="checkbox" value="{!! $agrupacion1->agrupacion1 !!}" checked>{!! $agrupacion1->agrupacion1 !!}</label>
                    <br>
                @endforeach
              </div>
        </div>
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
            {!! Form::label('a', 'Clas. A'); !!}
            <br>
            {!! Form::number('a', null, ['class'=>'form-control', 'required'])!!}
        </div>
        <div class="form-group">
            {!! Form::label('b', 'Clas. B'); !!}
            <br>
            {!! Form::number('b', null, ['class'=>'form-control', 'required'])!!}
        </div>
        <div class="form-group">
            <label for="busca_abc"> &nbsp;</label>
            <br>
            <button id="busca_abc" type="submit" class="btn btn-primary">Buscar</button>
        </div>
    {!! Form::close() !!}
</section>
<div id="loading_abc" class="loading_abc">
        <img src="{{URL::asset('/images/spinner.gif')}}" alt="" srcset="" style="width: 15vw;">
</div>
@endsection
