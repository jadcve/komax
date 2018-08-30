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
            <th>ABC</th>


        </thead>
        <tbody>
            @foreach($temp as $t)
            <tr>
                <td>{!!$t->cod_art!!}</td>
                <td>{!!$t->netamount!!}</td>
                <td>{!!$t->canal!!}</td>
                <td>{!!$t->qty!!}</td>
                <td>{!!$t->calc!!}</td>
                <td>{!!$t->acum !!}</td>
                <td>{!!$t->abc !!}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</section>
@endsection
