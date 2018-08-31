@extends('scaffold-interface.layouts.app')
@section('title','ABC')
@section('content')

<section class="content">
    <h1>
        ABC
    </h1>
    <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
        <a href="{!!url('tran')!!}" class = 'btn btn-primary pull-right'><i class="fa fa-home"></i> ABC</a>
    </div>
    <br/>
    <br/>
    <br/>

    <table class = "table table-striped table-bordered table-hover" style = 'background:#fff'>
        <thead>


            <th>Código Articulo</th>
            <th>Monto Neto</th>
            <th>Canal</th>
            <th>Marca</th>
            <th>Cantidad</th>
            <th>% de la Venta</th>
            <th>Acumulado %</th>
            <th>ABC</th>


        </thead>
        <tbody>

            @foreach($temp as $t)
            <tr>
                <td>{!!$t->cod_art!!}</td>
                <td>{!!$t->netamount!!}</td>
                <td>{!!$t->canal!!}</td>
                <td>{!!$t->marca!!}</td>
                <td>{!!$t->qty!!}</td>
                <td>{!!round($t->calc,2);!!}</td>
                <td>{!!round($t->acum,2); !!}</td>
                <td>{!!$t->abc !!}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</section>
@endsection
