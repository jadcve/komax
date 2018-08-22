@extends('scaffold-interface.layouts.app')
@section('title','Create')
@section('content')

<section class="content">
    <h1>
        Create nivel_servicio
    </h1>
    <a href="{!!url('nivel_servicio')!!}" class = 'btn btn-danger'><i class="fa fa-home"></i> Nivel_servicio Index</a>
    <br>
    <form method = 'POST' action = '{!!url("nivel_servicio")!!}'>
        <input type = 'hidden' name = '_token' value = '{{Session::token()}}'>
        <div class="form-group">
            <label for="letra">letra</label>
            <input id="letra" name = "letra" type="text" class="form-control">
        </div>
        <div class="form-group">
            <label for="nivel_servicio">nivel_servicio</label>
            <input id="nivel_servicio" name = "nivel_servicio" type="text" class="form-control">
        </div>
        <div class="form-group">
            <label for="descripcion">descripcion</label>
            <input id="descripcion" name = "descripcion" type="text" class="form-control">
        </div>
        <button class = 'btn btn-success' type ='submit'> <i class="fa fa-floppy-o"></i> Save</button>
    </form>
</section>
@endsection