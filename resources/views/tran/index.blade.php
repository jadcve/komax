@extends('scaffold-interface.layouts.app')
@section('title','Index')
@section('content')

<section class="content">
    <h1>
        Transaccional
    </h1>
    {!! Form::open(['url' => 'tran', 'method'=>'POST']) !!}
        <div class="form-group">
            <div class="input-group">
                <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
                    <div class="form-group">
                        {!! Form::label('fecha_inicial', 'Fecha Inicial'); !!}
                        <input class="form-control" id="fechaInicial" name="fechaInicial"    type="date"/>
                    </div>
                </div>
                <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
                    <div class="form-group">
                        {!! Form::label('fecha_final', 'Fecha Final'); !!}
                        <input class="form-control" id="fechaFinal" name="fechaFinal"   type="date"/>
                    </div>
                </div>

                <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
                    {!! Form::label('canal', 'Canal'); !!}
                    {!! Form::text('canal', null, ['class'=>'form-control'])!!}
                </div>

                <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
                    {!! Form::label('marca', 'Marca'); !!}
                    {!! Form::text('marca', null, ['class'=>'form-control'])!!}
                </div>
                <span class="input-group-btn"><button type="submit" class="btn btn-primary">Buscar</button></span>
            </div>
        </div>
    {!! Form::close() !!}


</section>
@endsection
