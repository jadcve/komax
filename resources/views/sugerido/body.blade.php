@extends('scaffold-interface.layouts.app')
@section('title','Calculos')
@section('content')

<section class="content">

    <h1>
        Envio Sugerido
    </h1>

    <div class="row">
        <div class="col-xs-12 col-md-4">
                <div class="form-group">
                    <a href="{!!url('sugerido')!!}" class = 'btn btn-primary pull-right'><i class="fa fa-home"></i> Sugerido</a>
                </div>
        </div>
    </div>


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


    <br/>
    <br/>
    <br/>

<form role="form">
  <fieldset disabled>
    <div class="form-group">
      <label for="disabledTextInput">Campo deshabilitado</label>
      <input type="text" id="campoDeshabilitado" class="form-control" 
             placeholder="Campo deshabilitado">
    </div>
    <div class="form-group">
      <label for="listaDeshabilitada">Lista deshabilitada</label>
      <select id="listaDeshabilitada" class="form-control">
        <option>Lista deshabilitada</option>
      </select>
    </div>
    <div class="checkbox">
      <label>
        <input type="checkbox"> No puedes pinchar esta opción
      </label>
    </div>
    <button type="submit" class="btn btn-primary">Enviar</button>
  </fieldset>
</form>

</section>
@endsection
