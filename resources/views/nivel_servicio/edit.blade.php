@extends('scaffold-interface.layouts.app')
@section('title','Nivel de Servicio')
@section('content')

<section class="content">
    <h1>
          Editar  Nivel de Servicio
    </h1>
    <a href="{!!url('nivel_servicio')!!}" class = 'btn btn-primary pull-right'><i class="fa fa-home"></i> Lista de  Niveles de Servicio</a>
    <br>
    <div class="row">
        <div class="col-xs-12 col-md-6 col-md-offset-3">
            <form method = 'POST' action = '{!! url("nivel_servicio")!!}/{!!$nivel_servicio->
                id!!}/update'> 
                <input type = 'hidden' name = '_token' value = '{{Session::token()}}'>
                <div class="form-group">
                    <label for="letra">Clasificación</label>
                    <input id="letra" name = "letra" type="text" class="form-control" value="{!!$nivel_servicio->
                    letra!!}"> 
                </div>
                <div class="form-group">
                    <label for="nivel_servicio">Nivel de Servicio</label>
                    <input id="nivel_servicio" name = "nivel_servicio" type="text" class="form-control" value="{!!$nivel_servicio->nivel_servicio!!}" required placeholder="Nivel de Servicio"> 
                </div>
                <div class="form-group">
                    <label for="descripcion">Descripción</label>
                    <input id="descripcion" name = "descripcion" type="text" class="form-control" value="{!!$nivel_servicio->descripcion!!}" placeholder="Descripción"> 
                </div>
                <button class = 'btn btn-success' type ='submit'><i class="fa fa-floppy-o"></i> Guardar</button>
            </form>
        </div>
    </div>
</section>
@endsection