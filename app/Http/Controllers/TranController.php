<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Tran;
use Illuminate\Support\Facades\DB;
use URL;

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


        $suma = DB::table('trans')
            ->whereBetween('fecha',[$fecha_inicio,$fecha_fin])
            ->where('canal','=',$canal)
            ->sum('netamount');


        $trans = DB::table('trans')
            ->select('cod_art','canal', \DB::raw('SUM(netamount) as netamount'),\DB::raw('SUM(qty) as qty'), \DB::raw(('SUM(netamount)*100 / ' . $suma) . ' as calc'))
            ->groupBy('cod_art', 'canal' )
            ->orderBy('netamount','desc')
            ->whereBetween('fecha',[$fecha_inicio,$fecha_fin])
            ->where('canal','=',$canal)
            ->get();


        $aux_trans = array_add($trans, 'acum', 'acum += $t->calc');
        $acum = 0;
        foreach ($trans as $t) {
          dd($aux_trans = array_add($trans, 'acum', '$acum += $t->calc'));
          //$acum += $t->calc;
        }

        return view('tran.abc',compact('trans','suma'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function index()
    {
        return view('tran.index');
    }



    public function export()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }
}
