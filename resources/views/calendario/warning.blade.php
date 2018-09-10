@extends('scaffold-interface.layouts.app')
@section('title','Proveedores')
@section('content')

<section class="content">
    <h1>
        <i class="fa fa-exclamation-triangle"aria-hidden="true"></i> Precaución
    </h1>
    <div class="row">
        <div class="col-xs-12">
            <h2 style="color:red;"> Esta acción reemplazará los datos de forma irreversible.<br>
                ¿Está seguro de realizar esta acción?
           </h2>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-xs-6"><a href='{!!url("calendario")!!}' class = 'btn btn-primary'><i class="fa fa-home"></i> Lista de Proveedores</a></div>
        <div class="col-xs-6 pull-right">
            {{-- <a href='{!!url("import")!!}' class = 'btn btn-success'><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Sí. Estoy seguro.</a> --}}
            <form style="display:inline-block;" method = 'POST' action = '{!!url("calendario/import")!!}' enctype="multipart/form-data">
                <div class="form-group">
                        <input type="hidden" name="archivo" value="{!!$archivo!!}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <button type="submit" class="btn btn-success"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Sí. Estoy seguro.</a></button>
                </div>
            </form>
        </div>
    </div>
    
    <br><br>
</section>
@endsection