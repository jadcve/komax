@extends('scaffold-interface.layouts.app')
@section('title','Index')
@section('content')

<section class="content">
    <h1>Cálculo para Obtener los Despachos Sugeridos</h1>
    <br>
    {!! Form::open(['url' => 'sugerido_distribucion_1', 'method'=>'POST', 'class'=>'form-inline']) !!}
        
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
