<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Tran;
Use App\Temporal;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use URL;
use Carbon\Carbon;


class bodyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */





    public function body(Request $request)
    {
        $fecha = $request->fecha;
        $carbon = new \Carbon\Carbon();
        $date = $carbon->now()->format('Y-m-d');

        //$bodega = $request->bodega;
        $bodega = 'RUTA68';

        $mov_salida1 = DB::table('trans')
            -> select('bodega', 'sku')
            ->whereNotNull('bodega')
            ->where('fecha','>',$fecha);

        $stocksem = DB::table('stock')
            -> select('bodega','sku','cantidad');

        $stockcd = $stocksem
            ->where('bodega','=',$bodega);

        $tran = DB::table('gid_transito')
            ->select('bodega_hasta', 'sku', \DB::raw('sum(qty_requested-qty_received) as transito'))
            ->where(\DB::raw('qty_requested-qty_received'),'>',0)
            ->groupBy('bodega_hasta','sku');

        $diasx = $mov_salida1
            ->select('bodega','sku', \DB::raw('case when sum(qty)=0 then 0 else sum(netamount)/sum(qty) end as p1'))
            ->whereBetween('fecha',[$date, $date->subDay(16)])
            ->groupBy('bodega','sku')
            ->get();

        return view('body.body', compact('mov_salida1','stockcd','tran', 'diasx'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function diasx ($query, $start, $end)
    {

        //Aquí  la lógica usando QueryBuilder o Eloquent

    }



    public function index()
    {
        return view('body.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
