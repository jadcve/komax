@extends('scaffold-interface.layouts.app')
@section('title','Index')
@section('content')

<section class="content">
    <h1>
        ABC
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
                    <div class="form-group">
                      <label for="canal">Canal</label>
                        <select name="canal" id="canal" class="form-control">
                            <option  value="">Seleccione</option>
                            @foreach ($canales as $canal)
                                <option value="{!! $canal->canal !!}">{!! $canal->canal !!}</option>
                            @endforeach
                        </select>
                    </div>
                    {{-- <label>Select Country:</label>
                        {!! Form::select('canal',[''=>'Seleccione']+$canales,null,['class'=>'form-control']) !!}--}}
                </div> 
                <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
                    <div class="form-group">
                        <label>Marca</label>
                        <select name="marca" id="marca" multiple class="form-control">
                        </select>
                        {{-- {!! Form::select('marca',[''=>'Seleccione'],null,['class'=>'form-control']) !!} --}}
                    </div>
                    {{-- {!! Form::label('marca', 'Marca'); !!}
                    {!! Form::text('marca', null, ['class'=>'form-control'])!!} --}}
                </div>

                <div class="col-lg-1 col-sm-1col-md-1 col-xs-12">
                    {!! Form::label('a', 'Clasificación A'); !!}
                    {!! Form::text('a', null, ['class'=>'form-control'])!!}
                </div>

                <div class="col-lg-1 col-sm-1 col-md-1 col-xs-12">
                    {!! Form::label('b', 'Clasificación B'); !!}
                    {!! Form::text('b', null, ['class'=>'form-control'])!!}
                </div>


                    <span class="input-group-btn"><button type="submit" class="btn btn-primary">Buscar</button></span>

            </div>
        </div>
        {!! Form::close() !!}


</section>
@endsection
