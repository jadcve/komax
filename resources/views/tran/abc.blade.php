@extends('scaffold-interface.layouts.app')
@section('title','ABC')
@section('content')

<section class="content">
    <h1>
        ABC
    </h1>

    <table class = "table table-striped table-bordered table-hover" style = 'background:#fff'>
        <thead>


            <th>Código Articulo</th>
            <th>Monto Neto</th>
            <th>Canal</th>
            <th>Cantidad</th>
            <th>%</th>
            <th>Acumulado</th>


        </thead>
        <tbody>
        {!!$x=0!!}
            @foreach($trans as $tran)
            <tr>
                <td>{!!$tran->cod_art!!}</td>
                <td>{!!$tran->netamount!!}</td>
                <td>{!!$tran->canal!!}</td>
                <td>{!!$tran->qty!!}</td>
                <td>{!!$tran->calc!!}</td>
                <td>{!!$x += $tran->calc !!}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</section>
@endsection
