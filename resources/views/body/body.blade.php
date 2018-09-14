@extends('scaffold-interface.layouts.app')
@section('title','pruebas')
@section('content')

<section class="content">
    <h1>
        ABC
    </h1>
    <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
        <a href="{!!url('body')!!}" class = 'btn btn-primary pull-right'><i class="fa fa-home"></i> ABC</a>
    </div>
    <br/>
    <br/>
    <br/>

    <table class = "table table-striped table-bordered table-hover" style = 'background:#fff'>
        <thead>



            <th>Bodega</th>
            <th>Sku</th>
            <th>Cantidad</th>


        </thead>
        <tbody>

            @foreach($diasx1 as $t)
            <tr>
                <td>{!!$t->bodega!!}</td>
                <td>{!!$t->sku!!}</td>
                <td>{!!$t->p1!!}</td>

            </tr>
            @endforeach
        </tbody>
    </table>
</section>
@endsection
