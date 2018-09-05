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
use App\Tienda;
use App\Marca;

/**
 * Class TranController.
 *
 * @author  The scaffold-interface created at 2018-08-23 04:31:37pm
 * @link  https://github.com/amranidev/scaffold-interface
 */
class TranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function calculo(Request $request)
    {
        $fecha_inicio = $request->fechaInicial;
        $fecha_fin = $request->fechaFinal;
        $canal = $request->canal;
        $marca = $request->marca;
        $a = $request->a;
        $b = $request->b;
        $c = $request->c;


        $suma = DB::table('trans')
            ->whereBetween('fecha',[$fecha_inicio,$fecha_fin])
            ->where('canal','=',$canal)
            ->where('marca','=',$marca)
            ->sum('netamount');


        $trans = DB::table('trans')
            ->select('cod_art','canal','marca', \DB::raw('SUM(netamount) as netamount'),\DB::raw('SUM(qty) as qty'), \DB::raw(('SUM(netamount)*100 / ' . $suma) . ' as calc'))
            ->groupBy('cod_art', 'canal', 'marca' )
            ->orderBy('netamount','desc')
            ->whereBetween('fecha',[$fecha_inicio,$fecha_fin])
            ->where('canal','=',$canal)
            ->where('marca','=',$marca)
            ->get();

        DB::table('temporals')->truncate();
        $suma=0;

        foreach($trans as $t){
            $temp = new Temporal();
            $temp->cod_art = $t->cod_art;
            $temp->netamount = $t->netamount;
            $temp->canal = $t->canal;
            $temp->marca = $t->marca;
            $temp->qty = $t->qty;
            $temp->calc = $t->calc;
            $suma += $t->calc;
            $temp->acum = $suma;
            if($suma < $a)
                $temp->abc = 'A';
            elseif($suma > $a and $suma < $b)
                $temp->abc = 'B';
            else
                $temp->abc = 'C';
            $temp->save();
        }

        $temp =  DB::table('temporals')->get();

        return view('tran.abc',compact('trans','temp'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function index()
    {
        // $tiendas = Tran::with('tiendas');
        $canales = Tienda::distinct()->get(['canal'])->sortBy('canal');

        return view('tran.index', compact('canales'));
    }

    public function selectAjax(Request $request)
    {
        if($request->ajax()){
            $marcas = Marca::where('canal', $request->canal)->get(['marca'])->sortBy('marca');
            return response()->json($marcas);
        }
    }
}
