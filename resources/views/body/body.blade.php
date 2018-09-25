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
            <th>Codigo Articulo</th>
            <th>Overcicle</th>
            <th>Orderlevel</th>
            <th>Minimo</th>



        </thead>
        <tbody>

            @foreach($dennis as $t)
            <tr>
                <td>{!!$t->tienda!!}</td>
                <td>{!!$t->articlecode!!}</td>
                <td>{!!$t->ordercicle!!}</td>
                <td>{!!$t->orderlevel!!}</td>
                <td>{!!$t->minimo!!}</td>
                


            </tr>
            @endforeach
        </tbody>
    </table>
</section>
@endsection
