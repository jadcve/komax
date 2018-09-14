<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use URL;

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

        /**
        *  Llamado a la función que calcula el precio de los productos
        */

        $diasx = $this->diasx($mov_salida1, 8,1);
        $diasx1 = $this->diasx($mov_salida1, 16,9);
        $dias3 = $this->dias_sumatoria($mov_salida1,8,1);
        $dias4 = $this->dias_sumatoria($mov_salida1,16,9);
        $dias5 = $this->dias_sumatoria($mov_salida1,24,17);
        $dias6 = $this->dias_sumatoria($mov_salida1,32,25);
        $dias7 = $this->dias_sumatoria($mov_salida1,33,40);
        $dias8 = $this->dias_sumatoria($mov_salida1,41,48);
        $dias9 = $this->dias_sumatoria($mov_salida1,49,56);
        $dias10 = $this->dias_sumatoria($mov_salida1,57,64);
        $dias11 = $this->dias_sumatoria($mov_salida1,65,72);
        $dias12 = $this->dias_sumatoria($mov_salida1,73,80);
        $dias13 = $this->dias_sumatoria($mov_salida1,81,88);
        $dias14 = $this->dias_sumatoria($mov_salida1,89,96);


        $total = $mov_salida1
            ->select('bodega','sku',DB::raw('sum(qty) as cantidad'))
            ->groupBy('bodega','sku');

        $totalx = $mov_salida1
            ->select('sku',DB::raw('sum(qty) as cantidad'))
            ->where(\DB::raw('(case when bodega like \'%TAG%\' then \'TMAR\' when bodega like \'%TKIV%\' then \'TMAR\' when bodega like \'%TMAR%\' then \'TMAR\' end) =\'TMAR\''))
            ->get();


        return view('body.body', compact('diasx','diasx1','totalx'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function diasx($query,$d1,$d2)
    {
        $carbon = new \Carbon\Carbon();
        $date_inicial = $carbon->now();
        $date_final = $carbon->now();

         return $query
            ->select('bodega','sku', \DB::raw('case when sum(qty)=0 then 0 else sum(netamount)/sum(qty) end as p1'))
            ->whereBetween( 'fecha',[$date_inicial->subDay($d1), $date_final->subDay($d2)])
            ->groupBy('fecha','bodega','sku')
            ->get();

    }

    public function dias_sumatoria($query, $d1, $d2)
    {
        $carbon = new \Carbon\Carbon();
        $date_inicial = $carbon->now();
        $date_final = $carbon->now();

        return $query
            ->select('bodega','sku', \DB::raw('sum(qty) as cantidad'))
            ->whereBetween( 'fecha',[$date_inicial->subDay($d1), $date_final->subDay($d2)])
            ->groupBy('fecha','bodega','sku')
            ->get();
    }



    public function index()
    {
        return view('body.index');
    }

}
