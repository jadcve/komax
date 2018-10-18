@extends('scaffold-interface.layouts.app')
@section('title','Calculos')
@section('content')

<section class="content">
    <h1>
        prueba
    </h1>
   

    <table id="tabla" class = "table table-striped table-bordered table-hover" style = 'background:#fff'>
        <thead>
            <th>C1</th>
            <th>C2</th>
            <th>C3</th> 
            
        </thead>
        <tbody>
            @php
                $registros = 0;
            @endphp
            @foreach($semana_11 as $t)
            @php
                if ($registros == 200){
                    break;
                }
                $registros++;
            @endphp
            <tr>
                <td>{!!$t->bodega!!}</td>
                <td>{!!$t->sku!!}</td>
                <td>{!!$t->cantidad!!}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</section>
@endsection
