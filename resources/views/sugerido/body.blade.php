@extends('scaffold-interface.layouts.app')
@section('title','Calculos')
@section('content')

<section class="content">
    <h1>
        Envio Sugerido
    </h1>
    <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
        <a href="{!!url('sugerido')!!}" class = 'btn btn-primary pull-right'><i class="fa fa-home"></i> Sugerido</a>
    </div>
    <br/>
    <br/>
    <br/>

    <table class = "table table-striped table-bordered table-hover" style = 'background:#fff'>
        <thead>



        
            <th>Codigo Articulo</th>
            <th>Forecast</th>
            <th>Ordercicle</th>
            <th>Mínimo</th>
            <th>Sugerido</th>
        </thead>
        <tbody>

            {{-- @foreach($sugerido as $t)
            <tr>
                <td>{!!$t->cod_art!!}</td>
                <td>{!!$t->score_m1!!}</td>
                <td>{!!$t->ordercicle!!}</td>
                <td>{!!$t->minimo!!}</td>
                <td>{!!$t->sugerido!!}</td>
                


            </tr>
            @endforeach --}}
        </tbody>
    </table>
</section>
@endsection
