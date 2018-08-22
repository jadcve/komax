@extends('scaffold-interface.layouts.app')
@section('title','Edit')
@section('content')

<section class="content">
    <h1>
        Edit tienda
    </h1>
    <a href="{!!url('tienda')!!}" class = 'btn btn-primary'><i class="fa fa-home"></i> Tienda Index</a>
    <br>
    <form method = 'POST' action = '{!! url("tienda")!!}/{!!$tienda->
        id!!}/update'> 
        <input type = 'hidden' name = '_token' value = '{{Session::token()}}'>
        <div class="form-group">
            <label for="cod_tienda">cod_tienda</label>
            <input id="cod_tienda" name = "cod_tienda" type="text" class="form-control" value="{!!$tienda->
            cod_tienda!!}"> 
        </div>
        <div class="form-group">
            <label for="bodega">bodega</label>
            <input id="bodega" name = "bodega" type="text" class="form-control" value="{!!$tienda->
            bodega!!}"> 
        </div>
        <div class="form-group">
            <label for="canal">canal</label>
            <input id="canal" name = "canal" type="text" class="form-control" value="{!!$tienda->
            canal!!}"> 
        </div>
        <div class="form-group">
            <label for="ciudad">ciudad</label>
            <input id="ciudad" name = "ciudad" type="text" class="form-control" value="{!!$tienda->
            ciudad!!}"> 
        </div>
        <div class="form-group">
            <label for="comuna">comuna</label>
            <input id="comuna" name = "comuna" type="text" class="form-control" value="{!!$tienda->
            comuna!!}"> 
        </div>
        <div class="form-group">
            <label for="region">region</label>
            <input id="region" name = "region" type="text" class="form-control" value="{!!$tienda->
            region!!}"> 
        </div>
        <div class="form-group">
            <label for="latitude">latitude</label>
            <input id="latitude" name = "latitude" type="text" class="form-control" value="{!!$tienda->
            latitude!!}"> 
        </div>
        <div class="form-group">
            <label for="longitud">longitud</label>
            <input id="longitud" name = "longitud" type="text" class="form-control" value="{!!$tienda->
            longitud!!}"> 
        </div>
        <div class="form-group">
            <label for="direccion">direccion</label>
            <input id="direccion" name = "direccion" type="text" class="form-control" value="{!!$tienda->
            direccion!!}"> 
        </div>
        <button class = 'btn btn-success' type ='submit'><i class="fa fa-floppy-o"></i> Update</button>
    </form>
</section>
@endsection