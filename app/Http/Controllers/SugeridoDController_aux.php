<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use URL;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;
use App\SugeridoD;
use App\Convert_to_csv;
use App\Bodega;

class SugeridoDController_aux extends Controller
{
   
   
    public function index()
    {
        $bodegas = Bodega::distinct()->get(['bodega'])->sortBy('bodega');

        return view('sugerido_distribucion_1.index',compact('bodegas'));
    }

    public function sugerido_dist()
    {
        $stock = DB::table('stock')
            ->select('bodega', 'sku', 'cantidad');
        
        $stock_cd = DB::table('stock')
            ->select('bodega', 'sku', 'cantidad')
            ->where('bodega','=','RUTA68');
        
        $transito = DB::table('transito')
            ->select('bodega_hasta', 'sku', \DB::raw('sum(qty_requested-qty_received) as transito'))
            ->where(\DB::raw('qty_requested-qty_received'),'>',0)
            ->groupBy('bodega_hasta','sku');

        $mov_salida1 = DB::table('mov_salida1')
            ->select('bodega','sku','qty','fecha','netamount');
        

        $semana_1 = $this->dias_sumatoria($mov_salida1,8,1);
        $semana_2 = $this->dias_sumatoria($mov_salida1,16,9);
        $semana_3 = $this->dias_sumatoria($mov_salida1,24,17);
        $semana_4 = $this->dias_sumatoria($mov_salida1,32,25);
        $semana_5 = $this->dias_sumatoria($mov_salida1,33,40);
        $semana_6 = $this->dias_sumatoria($mov_salida1,41,48);
        $semana_7 = $this->dias_sumatoria($mov_salida1,49,56);
        $semana_8 = $this->dias_sumatoria($mov_salida1,57,64);
        $semana_9 = $this->dias_sumatoria($mov_salida1,65,72);
        $semana_10 = $this->dias_sumatoria($mov_salida1,73,80);
        $semana_11 = $this->dias_sumatoria($mov_salida1,81,88);
        $semana_12 = $this->dias_sumatoria($mov_salida1,89,96);


        return view('sugerido_distribucion_1.body', compact('semana_11')); 
    }

    public function dias_sumatoria($query, $dia_final, $dia_inicio)
    {
        
        $carbon = new \Carbon\Carbon();
        $dia_actual1 = $carbon->now();
        $dia_actual2 = $carbon->now();

        return $query
            ->select('bodega','sku', \DB::raw("sum(qty) as cantidad"))
            ->whereBetween( 'fecha',[$dia_actual1->subDay($dia_inicio)->format('Y-m-d'), $dia_actual2->subDay($dia_final)->format('Y-m-d')])
            //->where(\DB::raw("fecha between '".date("Y-m-d",strtotime($fecha_actual." - ".$dia_final." days")). "' and '"  . date("Y-m-d",strtotime($fecha_actual." - ".$dia_inicio." days"))."'" ))
            ->groupBy('bodega','sku')
            ->orderBy('cantidad','desc')
            ->get();
    }

}
