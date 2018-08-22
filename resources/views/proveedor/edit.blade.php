@extends('scaffold-interface.layouts.app')
@section('title','Edit')
@section('content')

<section class="content">
    <h1>
        Edit proveedor
    </h1>
    <a href="{!!url('proveedor')!!}" class = 'btn btn-primary'><i class="fa fa-home"></i> Proveedor Index</a>
    <br>
    <form method = 'POST' action = '{!! url("proveedor")!!}/{!!$proveedor->
        id!!}/update'> 
        <input type = 'hidden' name = '_token' value = '{{Session::token()}}'>
        <div class="form-group">
            <label for="cod_prov">cod_prov</label>
            <input id="cod_prov" name = "cod_prov" type="text" class="form-control" value="{!!$proveedor->
            cod_prov!!}"> 
        </div>
        <div class="form-group">
            <label for="nombre_prov">nombre_prov</label>
            <input id="nombre_prov" name = "nombre_prov" type="text" class="form-control" value="{!!$proveedor->
            nombre_prov!!}"> 
        </div>
        <div class="form-group">
            <label for="leedt_prov">leedt_prov</label>
            <input id="leedt_prov" name = "leedt_prov" type="text" class="form-control" value="{!!$proveedor->
            leedt_prov!!}"> 
        </div>
        <div class="form-group">
            <label for="tentrega_prov">tentrega_prov</label>
            <input id="tentrega_prov" name = "tentrega_prov" type="text" class="form-control" value="{!!$proveedor->
            tentrega_prov!!}"> 
        </div>
        <button class = 'btn btn-success' type ='submit'><i class="fa fa-floppy-o"></i> Update</button>
    </form>
</section>
@endsection