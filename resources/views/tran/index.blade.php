@extends('scaffold-interface.layouts.app')
@section('title','Index')
@section('content')

<section class="content">
    <h1>
        Transaccional
    </h1>

    <br>
    <table class = "table table-striped table-bordered table-hover" style = 'background:#fff'>
        <thead>
            <th>Fecha de la venta</th>
            <th>Código Articulo</th>
            <th>Canal</th>
            <th>Monto Neto</th>
            <th>Cantidad</th>

        </thead>
        <tbody>
            @foreach($trans as $tran)
            <tr>
                <td>{!!$tran->fecha!!}</td>
                <td>{!!$tran->cod_art!!}</td>
                <td>{!!$tran->canal!!}</td>
                <td>{!!$tran->netamount!!}</td>
                <td>{!!$tran->qty!!}</td>

            </tr>
            @endforeach
        </tbody>
    </table>
    {!! $trans->render() !!}

</section>
@endsection
