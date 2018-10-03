<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Calendario;
use Amranidev\Ajaxis\Ajaxis;
use URL;
use Illuminate\Support\Facades\Auth;
use App\Bodega;
use App\Semana;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use App\Convert_to_csv;
use Illuminate\Support\Facades\DB;

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
        $calendarios = Calendario::with('user', 'bodega', 'semana')->orderBy('id', 'desc')->paginate(5);
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
        $bodegas = Bodega::all()->sortBy('id');
        $semanas = Semana::all()->sortBy('dia_semana');
        return view('calendario.create', compact('bodegas', 'semanas'));
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

        
        $calendario->bodega_id = $request->bodega_id;

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
        $bodegas = Bodega::all()->sortBy('id');
        $semanas = Semana::all()->sortBy('dia_semana');
        return view('calendario.edit',compact('title','calendario','bodegas', 'semanas'));
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
        
        $calendario->bodega_id = $request->bodega_id;
        
        $calendario->user_id = Auth::user()->id;

        $calendario->semana_id = $request->semana;
        
        $calendario->save();

        return redirect('calendario');
    }

    public function load(Request $request){
        global $validar;
        global $columna;
        $columna = '';
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
        // abre el archivo
        $file = fopen("../storage\app\public\uploads\calendario\\".$archivo, 'r');
        //tomo la primera linea
        $lineaUno = fgets($file);
        //cierra el archivo
        fclose($file);
        //extrae los headers del csv
        $headersEncontrados = str_getcsv($lineaUno, ',', '"');
        //elimina los espacios en blanco y simbolos de los elementos del array
        array_walk($headersEncontrados, function (&$value){
            $replase_simbols = array("\\", "¨", "º", "-", "~", "#", "@", "|", "!", "\"", "·", "$", "%", "&", "/", "(", ")", "?", "'", "¡", "¿", "[", "^", "<code>", "]", "+", "}", "{", "¨", "´", ">", "< ", ";", ",", ":", ".", " ");
             $value = mb_convert_encoding($value, 'utf-8','ASCII');
             $value = mb_convert_encoding($value, 'ASCII','utf-8');
             $value = trim(str_replace($replase_simbols, '', $value));
         });
        //arreglo con los headers de calendario
         $headersRequeridos = (array_search('"', $headersEncontrados) === false) ? array('semana_id', 'dia_despacho', 'lead_time', 'tiempo_entrega', 'bodega_id') : array('"semana_id"', 'dia_despacho', 'lead_time', 'tiempo_entrega', 'bodega_id');

        if ($headersEncontrados == $headersRequeridos) {
        }
        else{
            $message = 'Los headers del archivo que intenta cargar no coinciden. <br>
                La estructura del csv debe ser la siguiente:<br></h2><h4>'.implode(', ', $headersRequeridos).'</h4><br>
                <h2>Y la del archivo que intenta cargar es:</h2><br><h4>'.$lineaUno.'</h4>';
            //elimina el csv
            Storage::delete('public/uploads/calendario/'.$archivo);
            return view('calendario.fail',compact('message'));
         }
        //lee el csv
        Excel::load("storage\app\public\uploads\calendario\\".$archivo, function($reader) {
            //recorre el csv
            $fila = 1;
            foreach ($reader->get() as $calendario) {
                $fila ++;
                if (trim($calendario->semana_id) == "" or is_null($calendario->semana_id) or !is_numeric($calendario->semana_id)){
                    $GLOBALS['validar'] = true;
                    $GLOBALS['columna'] .= ' semana_id <span style="color:#1b5f9a;">fila: '.$fila.'</span><br>';
                }
                if (trim($calendario->dia_despacho) == "" or is_null($calendario->dia_despacho) or !is_numeric($calendario->dia_despacho)){
                    $GLOBALS['validar'] = true;
                    $GLOBALS['columna'] .= ' dia_despacho <span style="color:#1b5f9a;">fila: '.$fila.'</span><br>';
                }
                if (trim($calendario->lead_time) == "" or is_null($calendario->lead_time) or !is_numeric($calendario->lead_time)){
                    $GLOBALS['validar'] = true;
                    $GLOBALS['columna'] .= ' lead_time <span style="color:#1b5f9a;">fila: '.$fila.'</span><br>';
                }
                if (trim($calendario->tiempo_entrega) == "" or is_null($calendario->tiempo_entrega) or !is_numeric($calendario->tiempo_entrega)){
                    $GLOBALS['validar'] = true;
                    $GLOBALS['columna'] .= ' tiempo_entrega <span style="color:#1b5f9a;">fila: '.$fila.'</span><br>';
                }
                if (trim($calendario->bodega_id) == "" or is_null($calendario->bodega_id) or !is_numeric($calendario->bodega_id)){
                    $GLOBALS['validar'] = true;
                    $GLOBALS['columna'] .= ' bodega_id <span style="color:#1b5f9a;">fila: '.$fila.'</span><br>';
                }
            }
        });
        if ($validar){
            $message = 'La información que intenta cargar de Calendario tiene datos que no son validos en:<br><span style="font-size: 1.5vw;"><strong>'.$columna.'</strong></span><br><span style="color: red; font-weight:bold;">Verifique la información.</span>';
            //elimina el csv
            Storage::delete('public/uploads/calendario/'.$archivo);
            return view('calendario.fail',compact('message'));
        }
        else{
            return view('calendario.warning', compact('archivo'));
        }
    }

    public function import(Request $request){
        $archivo = $request->archivo;
        //montar los datos el la bd
        //lee el csv
        Excel::load("storage\app\public\uploads\calendario\\".$archivo, function($reader) {
            //elimina los regiustros existenetes
            Calendario::truncate();
            //recorre el csv
            foreach ($reader->get() as $calendario) {
                //agrega los datos del csv a la bd
                Calendario::create([
                    'dia_despacho' => $calendario->dia_despacho,
                    'lead_time' => $calendario->lead_time,
                    'tiempo_entrega' => $calendario->tiempo_entrega,
                    'bodega_id' => $calendario->bodega_id,
                    'semana_id' => $calendario->semana_id,
                    'user_id' => Auth::user()->id
                ]);
            }
        });
        //elimina el csv
        Storage::delete('public/uploads/calendario/'.$archivo);
    //     // return Book::all();
        return redirect('calendario');
    }

    public function download(){
        
        $datos = Calendario::all();

        $contenidoCsv = [];
        //headers del csv
        array_push($contenidoCsv, array('semana_id', 'dia_despacho', 'lead_time', 'tiempo_entrega', 'bodega_id'));
        //agrego los datos al array
        foreach ($datos as $registro) {
            array_push($contenidoCsv, array($registro->semana_id, $registro->dia_despacho, $registro->lead_time, $registro->tiempo_entrega, $registro->bodega_id));
        }
        //fecha para crear el nombre
        $fecha = date('Ymdhis');
        $nombreCsv = "calendario_".$fecha.'.csv';

        //llama al metodo para crear el csv
        Convert_to_csv::create($contenidoCsv, $nombreCsv, ',');

        return view('calendario/download');
    }

    public function search(Request $request){
        $request->busqueda = strtoupper($request->busqueda);
        $result = DB::select( DB::raw("SELECT
            calendarios.id, 
            calendarios.lead_time,
            calendarios.dia_despacho,
            calendarios.tiempo_entrega,
            calendarios.updated_at,
            bodegas.bodega,
            semanas.dia,
            users.name
        FROM
            calendarios INNER JOIN bodegas ON (calendarios.bodega_id = bodegas.id) INNER JOIN semanas ON (calendarios.semana_id = semanas.id) INNER JOIN users ON (calendarios.user_id = users.id) 
        WHERE
            CAST(dia_despacho AS VARCHAR(100)) like '%".$request->busqueda."%' or CAST(lead_time AS VARCHAR(100)) like '%".$request->busqueda."%' or CAST(tiempo_entrega AS VARCHAR(100)) like '%".$request->busqueda."%' or semanas.dia ilike '%".$request->busqueda."%' or bodegas.bodega ilike '%".$request->busqueda."%' or users.name ilike '%".$request->busqueda."%' or CAST(calendarios.updated_at AS VARCHAR(100)) like '%".$request->busqueda."%' ") );

        return response()->json($result);
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
