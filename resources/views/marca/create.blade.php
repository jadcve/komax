@extends('scaffold-interface.layouts.app')
@section('title','Create')
@section('content')

<section class="content">
    <h1>
        Create marca
    </h1>
    <a href="{!!url('marca')!!}" class = 'btn btn-danger'><i class="fa fa-home"></i> Marca Index</a>
    <br>
    <form method = 'POST' action = '{!!url("marca")!!}'>
        <input type = 'hidden' name = '_token' value = '{{Session::token()}}'>
        <div class="form-group">
            <label for="canal">canal</label>
            <input id="canal" name = "canal" type="text" class="form-control">
        </div>
        <div class="form-group">
            <label for="marca">marca</label>
            <input id="marca" name = "marca" type="text" class="form-control">
        </div>
        <button class = 'btn btn-success' type ='submit'> <i class="fa fa-floppy-o"></i> Save</button>
    </form>
</section>
@endsection