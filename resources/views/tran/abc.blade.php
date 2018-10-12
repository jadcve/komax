@extends('scaffold-interface.layouts.app')
@section('title','ABC')
@section('content')

<section class="content">
    <h1>
        ABC
    </h1>
    <div class="col-xs-12">
        <a href="{!!url('tran')!!}" class = 'btn btn-primary pull-right'><i class="fa fa-home"></i> Nuevo Calcuclo ABC</a>
    </div>
    <br/>
    <br/>
    <br/>
   @if (count($temp) != 0)
   <table id="tabla" class = "table table-striped table-bordered table-hover" style = 'background:#fff'>
        <thead>


            <th>Bodega</th>
            <th>Monto Neto</th>
            <th>Código Producto</th>
            <th>Cantidad</th>
            <th>% de la Venta</th>
            <th>Acumulado %</th>
            <th>ABC</th>


        </thead>
        <tbody>
            @php
                $registros = 0;
            @endphp
            @foreach($temp as $t)
            @php
                if ($registros == 20){
                    break;
                }
                $registros++;
            @endphp
            <tr>
                <td>{!!$t->bodega!!}</td>
                <td>{!!$t->netamount!!}</td>
                <td>{!!$t->sku!!}</td>
                <td>{!!$t->qty!!}</td>
                <td>{!!round($t->calc,2);!!}</td>
                <td>{!!round($t->acum,2); !!}</td>
                <td>{!!$t->abc !!}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
   @else
       <h2>No se encontrarón resultados para esta consulta</h2>
   @endif

</section>
@endsection
