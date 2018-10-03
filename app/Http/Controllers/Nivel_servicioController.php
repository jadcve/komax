<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Nivel_servicio;
use Amranidev\Ajaxis\Ajaxis;
use URL;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use App\Convert_to_csv;
use Illuminate\Support\Facades\DB;

/**
 * Class Nivel_servicioController.
 *
 * @author  The scaffold-interface created at 2018-08-22 06:00:55pm
 * @link  https://github.com/amranidev/scaffold-interface
 */
class Nivel_servicioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Index - nivel_servicio';
        $nivel_servicios = Nivel_servicio::with('user')->orderBy('id', 'desc')->paginate(5);
        return view('nivel_servicio.index',compact('nivel_servicios','title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Create - nivel_servicio';
        
        return view('nivel_servicio.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param    \Illuminate\Http\Request  $request
     * @return  \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $nivel_servicio = new Nivel_servicio();

        
        $nivel_servicio->letra = strtoupper($request->letra);

        
        $nivel_servicio->nivel_servicio = $request->nivel_servicio;

        
        $nivel_servicio->descripcion = $request->descripcion;

        $nivel_servicio->user_id = Auth::user()->id;
        
        $nivel_servicio->save();

        $pusher = App::make('pusher');

        //default pusher notification.
        //by default channel=test-channel,event=test-event
        //Here is a pusher notification example when you create a new resource in storage.
        //you can modify anything you want or use it wherever.
        $pusher->trigger('test-channel',
                         'test-event',
                        ['message' => 'Se ha creado un nuevo nivel de servicio !!']);

        return redirect('nivel_servicio');
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
        $title = 'Show - nivel_servicio';

        if($request->ajax())
        {
            return URL::to('nivel_servicio/'.$id);
        }

        $nivel_servicio = Nivel_servicio::findOrfail($id);
        return view('nivel_servicio.show',compact('title','nivel_servicio'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param    \Illuminate\Http\Request  $request
     * @param    int  $id
     * @return  \Illuminate\Http\Response
     */
    public function edit($id,Request $request)
    {
        $title = 'Edit - nivel_servicio';
        if($request->ajax())
        {
            return URL::to('nivel_servicio/'. $id . '/edit');
        }

        
        $nivel_servicio = Nivel_servicio::findOrfail($id);
        return view('nivel_servicio.edit',compact('title','nivel_servicio'  ));
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
        $nivel_servicio = Nivel_servicio::findOrfail($id);
    	
        $nivel_servicio->letra = strtoupper($request->letra);
        
        $nivel_servicio->nivel_servicio = $request->nivel_servicio;
        
        $nivel_servicio->descripcion = $request->descripcion;
        
        $nivel_servicio->user_id = Auth::user()->id;
        
        $nivel_servicio->save();

        return redirect('nivel_servicio');
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
            $path = $request->file('up_csv')->storeAs('public/uploads/nivel_servicio', $archivo);
        } else {
            $message = 'Formato de archivo no permitido. Solo cargar archivos de extención csv';
            return view('nivel_servicio.fail',compact('message'));
        }

        // abre el archivo
        $file = fopen("../storage\app\public\uploads\\nivel_servicio\\".$archivo, 'r');
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
        //arreglo con los headers de nivel_servicio
         $headersRequeridos = (array_search('"', $headersEncontrados) === false) ? array('letra', 'nivel_servicio', 'descripcion') : array('"letra"', 'nivel_servicio', 'descripcion');

        if ($headersEncontrados == $headersRequeridos) {
        }
        else{
            $message = 'Los headers del archivo que intenta cargar no coinciden. <br>
                La estructura del csv debe ser la siguiente:<br></h2><h4>'.implode(', ', $headersRequeridos).'</h4><br>
                <h2>Y la del archivo que intenta cargar es:</h2><br><h4>'.$lineaUno.'</h4>';
            //elimina el csv
            Storage::delete('public/uploads/nivel_servicio/'.$archivo);
            return view('nivel_servicio.fail',compact('message'));
         }
        //lee el csv
        Excel::load("storage\app\public\uploads\\nivel_servicio\\".$archivo, function($reader) {
            //recorre el csv
            $fila = 1;
            foreach ($reader->get() as $nivel) {
                $fila ++;
                if (trim($nivel->letra) == "" or is_null($nivel->letra) or !is_string($nivel->letra) or (strlen($nivel->letra) > 1)){
                    $GLOBALS['validar'] = true;
                    $GLOBALS['columna'] .= ' letra <span style="color:#1b5f9a;">fila: '.$fila.'</span><br>';
                }
                if (trim($nivel->nivel_servicio) == "" or is_null($nivel->nivel_servicio) or !is_numeric($nivel->nivel_servicio)){
                    $GLOBALS['validar'] = true;
                    $GLOBALS['columna'] .= ' nivel_servicio <span style="color:#1b5f9a;">fila: '.$fila.'</span><br>';
                }
                if (trim($nivel->descripcion) == "" or is_null($nivel->descripcion)){
                    $GLOBALS['validar'] = true;
                    $GLOBALS['columna'] .= ' descripcion <span style="color:#1b5f9a;">fila: '.$fila.'</span><br>';
                }
            }
        });
        if ($validar){
            $message = 'La información que intenta cargar de Nivel de Servicio tiene datos que no son validos en:<br><span style="font-size: 1.5vw;"><strong>'.$columna.'</strong></span><br><span style="color: red; font-weight:bold;">Verifique la información.</span>';
            //elimina el csv
            Storage::delete('public/uploads/nivel_servicio/'.$archivo);
            return view('nivel_servicio.fail',compact('message'));
        }
        else{
            return view('nivel_servicio.warning', compact('archivo'));
        }
    }

    public function import(Request $request){
        $archivo = $request->archivo;
        //montar los datos el la bd
        //lee el csv
        Excel::load("storage\app\public\uploads\\nivel_servicio\\".$archivo, function($reader) {
            //elimina los regiustros existenetes
            Nivel_servicio::truncate();
            //recorre el csv
            foreach ($reader->get() as $nivel) {
                //agrega los datos del csv a la bd
                Nivel_servicio::create([
                    'letra' => strtoupper($nivel->letra),
                    'nivel_servicio' => $nivel->nivel_servicio,
                    'descripcion' => $nivel->descripcion,
                    'user_id' => Auth::user()->id
                ]);
            }
        });
        //elimina el csv
        Storage::delete('public/uploads/nivel_servicio/'.$archivo);
    //     // return Book::all();
        return redirect('nivel_servicio');
    }

    public function download(){
        
        $datos = Nivel_servicio::all();

        $contenidoCsv = [];
        //headers del csv
        array_push($contenidoCsv, array('letra', 'nivel_servicio', 'descripcion'));
        //agrego los datos al array
        foreach ($datos as $registro) {
            array_push($contenidoCsv, array($registro->letra, $registro->nivel_servicio, $registro->descripcion));
        }
        //fecha para crear el nombre
        $fecha = date('Ymdhis');
        $nombreCsv = "nivel_servicio_".$fecha.'.csv';

        //llama al metodo para crear el csv
        Convert_to_csv::create($contenidoCsv, $nombreCsv, ',');

        return view('nivel_servicio/download');
    }

    public function search(Request $request){
        $request->busqueda = strtoupper($request->busqueda);
        $result = DB::select( DB::raw("SELECT
        nivel_servicios.id,
        nivel_servicios.letra,
        nivel_servicios.nivel_servicio,
        nivel_servicios.descripcion,
        nivel_servicios.updated_at,
        users.name
    FROM
        nivel_servicios INNER JOIN users ON (nivel_servicios.user_id = users.id) 
    WHERE
        CAST(nivel_servicio AS VARCHAR(100)) ilike '%".$request->busqueda."%' or CAST(letra AS VARCHAR(100)) ilike '%".$request->busqueda."%' or CAST(descripcion AS VARCHAR(100)) ilike '%".$request->busqueda."%' or users.name ilike '%".$request->busqueda."%' or CAST(nivel_servicios.updated_at AS VARCHAR(100)) like '%".$request->busqueda."%' ") );

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
        $msg = Ajaxis::BtDeleting('Precaución!!','¿Desea eliminar de forma permanente este registro! ?','/nivel_servicio/'. $id . '/delete');

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
     	$nivel_servicio = Nivel_servicio::findOrfail($id);
     	$nivel_servicio->delete();
        return URL::to('nivel_servicio');
    }
}
