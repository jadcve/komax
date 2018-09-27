@extends('scaffold-interface.layouts.app')
@section('title','Index')
@section('content')

<section class="content">
    <h1>
         
    </h1>
    {!! Form::open(['url' => 'sugerido', 'method'=>'POST']) !!}
    <div class="form-group">
        <div class="input-group">
            <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
                <div class="form-group">
                    {!! Form::label('fecha', 'Fecha'); !!}
                    <input class="form-control" id="fecha" name="fecha"    type="date" required/>
                </div>
            </div>
            <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
                <div class="form-group">
                    {!! Form::label('bodega', 'Bodega'); !!}
                    <input class="form-control" id="bodega" name="bodega"    type="text" required/>
                </div>
            </div>


            <span class="input-group-btn"><button type="submit" class="btn btn-primary">Buscar</button></span>

        </div>
    </div>
    {!! Form::close() !!}

    <div class="row">
        <div class="col-xs-12 col-md-4">
            <form style="display:inline-block; padding-right: 5px;" method = 'POST' action = '{!!url("sugerido/download")!!}'>
                <div class="form-group">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <label for="">Descargar datos</label><br>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-download" aria-hidden="true"></i> Descargar</button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
