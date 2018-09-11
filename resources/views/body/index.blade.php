@extends('scaffold-interface.layouts.app')
@section('title','Index')
@section('content')

<section class="content">
    <h1>
        pruebas querys
    </h1>
    {!! Form::open(['url' => 'body', 'method'=>'POST']) !!}
    <div class="form-group">
        <div class="input-group">
            <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
                <div class="form-group">
                    {!! Form::label('fecha', 'Fecha'); !!}
                    <input class="form-control" id="fecha" name="fecha"    type="date" required/>
                </div>
            </div>


            <span class="input-group-btn"><button type="submit" class="btn btn-primary">Buscar</button></span>

        </div>
    </div>
    {!! Form::close() !!}


</section>
@endsection