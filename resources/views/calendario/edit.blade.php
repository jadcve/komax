@extends('scaffold-interface.layouts.app')
@section('title','Edit')
@section('content')

<section class="content">
    <h1>
        Edit calendario
    </h1>
    <a href="{!!url('calendario')!!}" class = 'btn btn-primary'><i class="fa fa-home"></i> Calendario Index</a>
    <br>
    <form method = 'POST' action = '{!! url("calendario")!!}/{!!$calendario->
        id!!}/update'> 
        <input type = 'hidden' name = '_token' value = '{{Session::token()}}'>
        <div class="form-group">
            <label for="dia_despacho">dia_despacho</label>
            <input id="dia_despacho" name = "dia_despacho" type="text" class="form-control" value="{!!$calendario->
            dia_despacho!!}"> 
        </div>
        <div class="form-group">
            <label for="lead_time">lead_time</label>
            <input id="lead_time" name = "lead_time" type="text" class="form-control" value="{!!$calendario->
            lead_time!!}"> 
        </div>
        <div class="form-group">
            <label for="tiempo_entrega">tiempo_entrega</label>
            <input id="tiempo_entrega" name = "tiempo_entrega" type="text" class="form-control" value="{!!$calendario->
            tiempo_entrega!!}"> 
        </div>
        <div class="form-group">
            <label for="tienda_id">tienda_id</label>
            <input id="tienda_id" name = "tienda_id" type="text" class="form-control" value="{!!$calendario->
            tienda_id!!}"> 
        </div>
        <button class = 'btn btn-success' type ='submit'><i class="fa fa-floppy-o"></i> Update</button>
    </form>
</section>
@endsection