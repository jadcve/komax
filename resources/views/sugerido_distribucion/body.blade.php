@extends('scaffold-interface.layouts.app')
@section('title','Calculos')
@section('content')

<section class="content">
    <h1>
        Envio Sugerido
    </h1>
    <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
        <a href="{!!url('sugerido_distribucion')!!}" class = 'btn btn-primary pull-left'><i class="fa fa-home"></i> Sugerido</a>
    </div>
    <br/>
    <div class="row">
            <div class="col-xs-12 col-md-4">
                <form style="display:inline-block; padding-right: 5px;" method = 'POST' action = '{!!url("sugerido_distribucion/download")!!}'>
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

    <table id="tabla" class = "table table-striped table-bordered table-hover" style = 'background:#fff'>
        <thead>
            <th>campo1</th>
            <th>campo2</th>
            <th>campo2</th>


        </thead>
        <tbody>
            @php
                $registros = 0;
            @endphp
            @foreach($prueba as $t)
            @php
                if ($registros == 2000){
                    break;
                }
                $registros++;
            @endphp
            <tr>
                <td>{!!$t->bodega!!}</td>
                <td>{!!$t->agrupacion1!!}</td>
                <td>{!!$t->sku!!}</td>
                
            </tr>
            @endforeach
        </tbody>
    </table>
</section>
@endsection
