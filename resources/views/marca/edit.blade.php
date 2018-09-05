@extends('scaffold-interface.layouts.app')
@section('title','Edit')
@section('content')

<section class="content">
    <h1>
        Edit marca
    </h1>
    <a href="{!!url('marca')!!}" class = 'btn btn-primary'><i class="fa fa-home"></i> Marca Index</a>
    <br>
    <form method = 'POST' action = '{!! url("marca")!!}/{!!$marca->
        id!!}/update'> 
        <input type = 'hidden' name = '_token' value = '{{Session::token()}}'>
        <div class="form-group">
            <label for="canal">canal</label>
            <input id="canal" name = "canal" type="text" class="form-control" value="{!!$marca->
            canal!!}"> 
        </div>
        <div class="form-group">
            <label for="marca">marca</label>
            <input id="marca" name = "marca" type="text" class="form-control" value="{!!$marca->
            marca!!}"> 
        </div>
        <button class = 'btn btn-success' type ='submit'><i class="fa fa-floppy-o"></i> Update</button>
    </form>
</section>
@endsection