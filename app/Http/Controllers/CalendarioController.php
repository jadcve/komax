<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Calendario;
use Amranidev\Ajaxis\Ajaxis;
use URL;
use Illuminate\Support\Facades\Auth;
use App\Tienda;
use App\Semana;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

/**
 * Class CalendarioController.
 *
 * @author  The scaffold-interface created at 2018-08-22 06:06:23pm
 * @link  https://github.com/amranidev/scaffold-interface
 */
class CalendarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Index - calendario';
        $calendarios = Calendario::with('user', 'tienda', 'semana')->orderBy('id', 'desc')->paginate(10);
        return view('calendario.index',compact('calendarios','title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Create - calendario';
        $tiendas = Tienda::all()->sortBy('id');
        $semanas = Semana::all()->sortBy('dia_semana');
        return view('calendario.create', compact('tiendas', 'semanas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param    \Illuminate\Http\Request  $request
     * @return  \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $calendario = new Calendario();

        
        $calendario->dia_despacho = $request->dia_despacho;

        
        $calendario->lead_time = $request->lead_time;

        
        $calendario->tiempo_entrega = $request->tiempo_entrega;

        
        $calendario->tienda_id = $request->tienda_id;

        $calendario->user_id = Auth::user()->id;

        $calendario->semana_id = $request->semana;
        
        $calendario->save();

        $pusher = App::make('pusher');

        //default pusher notification.
        //by default channel=test-channel,event=test-event
        //Here is a pusher notification example when you create a new resource in storage.
        //you can modify anything you want or use it wherever.
        $pusher->trigger('test-channel',
                         'test-event',
                        ['message' => 'Se ha creado el registro !!']);

        return redirect('calendario');
    }

    /**
     * Display the specified resource.
     *
     * @param    \Illuminate\Http\Request  $request
     * @param    int  $id
     * @return  \Illuminate\Http\Response
     */
    public function show($id,Request $request)
    {
        $title = 'Show - calendario';

        if($request->ajax())
        {
            return URL::to('calendario/'.$id);
        }

        $calendario = Calendario::findOrfail($id);
        return view('calendario.show',compact('title','calendario'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param    \Illuminate\Http\Request  $request
     * @param    int  $id
     * @return  \Illuminate\Http\Response
     */
    public function edit($id,Request $request)
    {
        $title = 'Edit - calendario';
        if($request->ajax())
        {
            return URL::to('calendario/'. $id . '/edit');
        }

        
        $calendario = Calendario::findOrfail($id);
        $tiendas = Tienda::all()->sortBy('id');
        $semanas = Semana::all()->sortBy('dia_semana');
        return view('calendario.edit',compact('title','calendario','tiendas', 'semanas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param    \Illuminate\Http\Request  $request
     * @param    int  $id
     * @return  \Illuminate\Http\Response
     */
    public function update($id,Request $request)
    {
        $calendario = Calendario::findOrfail($id);
    	
        $calendario->dia_despacho = $request->dia_despacho;
        
        $calendario->lead_time = $request->lead_time;
        
        $calendario->tiempo_entrega = $request->tiempo_entrega;
        
        $calendario->tienda_id = $request->tienda_id;
        
        $calendario->user_id = Auth::user()->id;

        $calendario->semana_id = $request->semana;
        
        $calendario->save();

        return redirect('calendario');
    }

    public function load(Request $request){
        global $validar;
        $validar = false;
        $archivo = $_FILES["up_csv"]["name"];
        //validar y cargar la carga masiva
        //obtiene la extencion
        $extension = $request->file('up_csv')->getClientOriginalExtension();
        //chequea la extencion
        if($extension == 'csv'){
            //monta el csv
            $path = $request->file('up_csv')->storeAs('public/uploads/calendario', $archivo);
        } else {
            $message = 'Formato de archivo no permitido. Solo cargar archivos de extención csv';
            return view('calendario.fail',compact('message'));
        }
        //lee el csv
        Excel::load("storage\app\public\uploads\calendario\\".$archivo, function($reader) {
            //recorre el csv
            foreach ($reader->get() as $calendario) {
                if ($calendario->dia_despacho == "" or is_null($calendario->dia_despacho) or !is_numeric($calendario->dia_despacho)){
                    $GLOBALS['validar'] = true;
                }
                if ($calendario->lead_time == "" or is_null($calendario->lead_time) or !is_numeric($calendario->lead_time)){
                    $GLOBALS['validar'] = true;
                }
                if ($calendario->tiempo_entrega == "" or is_null($calendario->tiempo_entrega) or !is_numeric($calendario->tiempo_entrega)){
                    $GLOBALS['validar'] = true;
                }
                if ($calendario->tienda_id == "" or is_null($calendario->tienda_id) or !is_numeric($calendario->tienda_id)){
                    $GLOBALS['validar'] = true;
                }
                if ($calendario->semana_id == "" or is_null($calendario->semana_id) or !is_numeric($calendario->semana_id)){
                    $GLOBALS['validar'] = true;
                }
            }
        });
        if ($validar){
            $message = 'La información que intenta cargar de Calendario tiene datos que no son validos.<br>Verifique la información. ';
            return view('calendario.fail',compact('message'));
        }
        else{
            return view('calendario.warning', compact('archivo'));
        }
    }

    public function import(Request $request){
        //montar los datos el la bd
        //lee el csv
        Excel::load("storage\app\public\uploads\calendario\\".$request->archivo, function($reader) {
            //elimina los regiustros existenetes
            Calendario::truncate();
            //recorre el csv
            foreach ($reader->get() as $proveedores) {
                //agrega los datos del csv a la bd
                Calendario::create([
                    'dia_despacho' => $proveedores->dia_despacho,
                    'lead_time' => $proveedores->lead_time,
                    'tiempo_entrega' => $proveedores->tiempo_entrega,
                    'tienda_id' => $proveedores->tienda_id,
                    'semana_id' => $proveedores->semana_id,
                    'user_id' => Auth::user()->id
                ]);
            }
        });
        //elimina el csv
        Storage::delete('public/uploads/calendario/'.$request->archivo);
    //     // return Book::all();
        return redirect('calendario');
    }
    /**
     * Delete confirmation message by Ajaxis.
     *
     * @link      https://github.com/amranidev/ajaxis
     * @param    \Illuminate\Http\Request  $request
     * @return  String
     */
    public function DeleteMsg($id,Request $request)
    {
        $msg = Ajaxis::BtDeleting('Precaución!!','¿Desea eliminar de forma permanente este registro! ?','/calendario/'. $id . '/delete');

        if($request->ajax())
        {
            return $msg;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param    int $id
     * @return  \Illuminate\Http\Response
     */
    public function destroy($id)
    {
     	$calendario = Calendario::findOrfail($id);
     	$calendario->delete();
        return URL::to('calendario');
    }
}
