@extends('scaffold-interface.layouts.app')
@section('title','Index')
@section('content')

<section class="content">
    <h1>
        Transaccional
    </h1>
    <form method = 'GET' action = '{!!url("tran")!!}'>
        <div class="form-group">
            <div class="input-group">
                <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
                    <div class="form-group">
                        <label class="control-label" for="date">Fecha  inicial</label>
                        <input class="form-control" id="fechaInicial" name="fechaInicial"    type="date"/>
                    </div>
                </div>
                <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
                    <div class="form-group">
                        <label class="control-label" for="date">Fecha fin</label>
                        <input class="form-control" id="fechaFinal" name="fechaFinal"   type="date"/>
                    </div>
                </div>

                <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">

                    <label class="control-label" >Canal</label>
                    {!! Form::text('canal', null, ['class'=>'form-control'])!!}
                </div>

                <span class="input-group-btn"><button type="submit" class="btn btn-primary">Buscar</button></span>
            </div>
        </div>
    </form>
    <br>

    <table class = "table table-striped table-bordered table-hover" style = 'background:#fff'>
        <thead>


            <th>Código Articulo</th>
            <th>Monto Neto</th>
            <th>Canal</th>
            <th>Cantidad</th>
            <th>%</th>
            <th>Total</th>


        </thead>
        <tbody>
            @foreach($trans as $tran)
            <tr>

                <td>{!!$tran->cod_art!!}</td>
                <td>{!!$tran->netamount!!}</td>
                <td>{!!$tran->canal!!}</td>
                <td>{!!$tran->qty!!}</td>
                <td>{!!($tran->netamount/$suma)*100 !!}</td>
                <td>{!!$tran->netamount!!}</td>

            </tr>
            @endforeach
        </tbody>
    </table>
    {!! $trans->render() !!}

</section>
@endsection
