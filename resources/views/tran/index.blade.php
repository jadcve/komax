@extends('scaffold-interface.layouts.app')
@section('title','Index')
@section('content')

<section class="content">
    <h1>
        ABC
    </h1>
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
            <label for="canal">Canal</label>
            <br>
            <select name="canal" id="canal" class="form-control" required>
                <option  value="">Seleccione</option>
                @foreach ($canales as $canal)
                    <option value="{!! $canal->canal !!}">{!! $canal->canal !!}</option>
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
