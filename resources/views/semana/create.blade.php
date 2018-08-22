@extends('scaffold-interface.layouts.app')
@section('title','Create')
@section('content')

<section class="content">
    <h1>
        Create semana
    </h1>
    <a href="{!!url('semana')!!}" class = 'btn btn-danger'><i class="fa fa-home"></i> Semana Index</a>
    <br>
    <form method = 'POST' action = '{!!url("semana")!!}'>
        <input type = 'hidden' name = '_token' value = '{{Session::token()}}'>
        <div class="form-group">
            <label for="dia_semana">dia_semana</label>
            <input id="dia_semana" name = "dia_semana" type="text" class="form-control">
        </div>
        <div class="form-group">
            <label for="dia">dia</label>
            <input id="dia" name = "dia" type="text" class="form-control">
        </div>
        <div class="form-group">
            <label for="calendario_id">calendario_id</label>
            <input id="calendario_id" name = "calendario_id" type="text" class="form-control">
        </div>
        <button class = 'btn btn-success' type ='submit'> <i class="fa fa-floppy-o"></i> Save</button>
    </form>
</section>
@endsection