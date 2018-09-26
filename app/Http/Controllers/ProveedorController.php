<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Proveedor;
use Amranidev\Ajaxis\Ajaxis;
use URL;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use App\Convert_to_csv;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Class ProveedorController.
 *
 * @author  The scaffold-interface created at 2018-08-22 05:19:09pm
 * @link  https://github.com/amranidev/scaffold-interface
 */
class ProveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Index - proveedor';
        $proveedors = Proveedor::with('user')->orderBy('id')->paginate(10);
        return view('proveedor.index',compact('proveedors','title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Create - proveedor';
        
        return view('proveedor.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param    \Illuminate\Http\Request  $request
     * @return  \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $proveedor = new Proveedor();

        
        $proveedor->codigo_proveedor = strtoupper($request->codigo_proveedor);

        
        $proveedor->descripcion_proveedor = $request->descripcion_proveedor;

        
        $proveedor->lead_time_proveedor = $request->lead_time_proveedor;

        
        $proveedor->tiempo_entrega_proveedor = $request->tiempo_entrega_proveedor;

        $proveedor->user_id = Auth::user()->id;
        
        $proveedor->save();

        $pusher = App::make('pusher');

        //default pusher notification.
        //by default channel=test-channel,event=test-event
        //Here is a pusher notification example when you create a new resource in storage.
        //you can modify anything you want or use it wherever.
        $pusher->trigger('test-channel',
                         'test-event',
                        ['message' => 'Se ha creado el proveedor !!']);

        return redirect('proveedor');
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
        $title = 'Show - proveedor';

        if($request->ajax())
        {
            return URL::to('proveedor/'.$id);
        }

        $proveedor = Proveedor::findOrfail($id);
        return view('proveedor.show',compact('title','proveedor'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param    \Illuminate\Http\Request  $request
     * @param    int  $id
     * @return  \Illuminate\Http\Response
     */
    public function edit($id,Request $request)
    {
        $title = 'Edit - proveedor';
        if($request->ajax())
        {
            return URL::to('proveedor/'. $id . '/edit');
        }

        
        $proveedor = Proveedor::findOrfail($id);
        return view('proveedor.edit',compact('title','proveedor'  ));
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
        $proveedor = Proveedor::findOrfail($id);
    	
        $proveedor->codigo_proveedor = strtoupper($request->codigo_proveedor);
        
        $proveedor->descripcion_proveedor = $request->descripcion_proveedor;
        
        $proveedor->lead_time_proveedor = $request->lead_time_proveedor;
        
        $proveedor->tiempo_entrega_proveedor = $request->tiempo_entrega_proveedor;
        
        $proveedor->user_id = Auth::user()->id;
        
        $proveedor->save();

        return redirect('proveedor');
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
            $path = $request->file('up_csv')->storeAs('public/uploads/proveedor', $archivo);
        } else {
            $message = 'Formato de archivo no permitido. Solo cargar archivos de extención csv';
            return view('proveedor.fail',compact('message'));
        }
        // abre el archivo
        $file = fopen("../storage\app\public\uploads\proveedor\\".$archivo, 'r');
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
        //arreglo con los headers de proveedor
         $headersRequeridos = (array_search('"', $headersEncontrados) === false) ? array('codigo_proveedor', 'descripcion_proveedor', 'lead_time_proveedor', 'tiempo_entrega_proveedor') : array('"codigo_proveedor"', 'descripcion_proveedor', 'lead_time_proveedor', 'tiempo_entrega_proveedor');

        if ($headersEncontrados == $headersRequeridos) {
        }
        else{
            $message = 'Los headers del archivo que intenta cargar no coinciden. <br>
                La estructura del csv debe ser la siguiente:<br></h2><h4>'.implode(', ', $headersRequeridos).'</h4><br>
                <h2>Y la del archivo que intenta cargar es:</h2><br><h4>'.$lineaUno.'</h4>';
            //elimina el csv
            Storage::delete('public/uploads/proveedor/'.$archivo);
            return view('proveedor.fail',compact('message'));
         }
        //lee el csv
        Excel::load("storage\app\public\uploads\proveedor\\".$archivo, function($reader) {
            //recorre el csv
            $fila = 1;
            foreach ($reader->get() as $proveedores) {
                $fila ++;
                if (trim($proveedores->codigo_proveedor) == "" or is_null($proveedores->codigo_proveedor)){
                    $GLOBALS['validar'] = true;
                    $GLOBALS['columna'] .= ' codigo_proveedor <span style="color:#1b5f9a;">fila: '.$fila.'</span><br>';
                }
                if (trim($proveedores->descripcion_proveedor) == "" or is_null($proveedores->descripcion_proveedor)){
                    $GLOBALS['validar'] = true;
                    $GLOBALS['columna'] .= ' descripcion_proveedor <span style="color:#1b5f9a;">fila: '.$fila.'</span><br>';
                }
                if (trim($proveedores->lead_time_proveedor) == "" or is_null($proveedores->lead_time_proveedor) or !is_numeric($proveedores->lead_time_proveedor)){
                    $GLOBALS['validar'] = true;
                    $GLOBALS['columna'] .= ' lead_time_proveedor <span style="color:#1b5f9a;">fila: '.$fila.'</span><br>';
                    
                }
                if (trim($proveedores->tiempo_entrega_proveedor) == "" or is_null($proveedores->tiempo_entrega_proveedor) or !is_numeric($proveedores->tiempo_entrega_proveedor)){
                    $GLOBALS['validar'] = true;
                    $GLOBALS['columna'] .= ' tiempo_entrega_proveedor <span style="color:#1b5f9a;">fila: '.$fila.'</span><br>';
                }
            }
        });
        if ($validar){
            $message = 'La información que intenta cargar de Proveedores tiene datos que no son validos en:<br><span style="font-size: 1.5vw;"><strong>'.$columna.'</strong></span><br><span style="color: red; font-weight:bold;">Verifique la información.</span>';
            //elimina el csv
            Storage::delete('public/uploads/proveedor/'.$archivo);
            return view('proveedor.fail',compact('message'));
        }
        else{
            return view('proveedor.warning', compact('archivo'));
        }
    }

    public function import(Request $request){
        $archivo = $request->archivo;
        //montar los datos el la bd
        //lee el csv
        Excel::load("storage\app\public\uploads\proveedor\\".$archivo, function($reader) {
            //elimina los regiustros existenetes
            Proveedor::truncate();
            //recorre el csv
            foreach ($reader->get() as $proveedores) {
                //agrega los datos del csv a la bd
                Proveedor::create([
                    'codigo_proveedor' => strtoupper($proveedores->codigo_proveedor),
                    'descripcion_proveedor' => $proveedores->descripcion_proveedor,
                    'lead_time_proveedor' => $proveedores->lead_time_proveedor,
                    'tiempo_entrega_proveedor' => $proveedores->tiempo_entrega_proveedor,
                    'user_id' => Auth::user()->id
                ]);
            }
        });
        //elimina el csv
        Storage::delete('public/uploads/proveedor/'.$archivo);
    //     // return Book::all();
        return redirect('proveedor');
    }

    // private function convert_to_csv($input_array, $output_file_name, $delimiter){

    // }

    public function download(){
        
        $datos = Proveedor::all();

        $contenidoCsv = [];
        //headers del csv
        array_push($contenidoCsv, array('codigo_proveedor', 'descripcion_proveedor', 'lead_time_proveedor', 'tiempo_entrega_proveedor'));
        //agrego los datos al array
        foreach ($datos as $registro) {
            array_push($contenidoCsv, array($registro->codigo_proveedor, $registro->descripcion_proveedor, $registro->lead_time_proveedor, $registro->tiempo_entrega_proveedor));
        }
        //fecha para crear el nombre
        $fecha = date('Ymdhis');
        $nombreCsv = "proveedor_".$fecha.'.csv';

        //llama al metodo para crear el csv
        Convert_to_csv::create($contenidoCsv, $nombreCsv, ',');

        return view('proveedor/download');
    }

    public function search(Request $request){
        $request->busqueda = strtoupper($request->busqueda);
        $result = DB::select( DB::raw("SELECT
        proveedors.id,
        proveedors.codigo_proveedor,
        proveedors.descripcion_proveedor,
        proveedors.lead_time_proveedor,
        proveedors.tiempo_entrega_proveedor,
        proveedors.updated_at,
        users.name
    FROM
        proveedors INNER JOIN users ON (proveedors.user_id = users.id) 
    WHERE
        CAST(descripcion_proveedor AS VARCHAR(100)) ilike '%".$request->busqueda."%' or CAST(codigo_proveedor AS VARCHAR(100)) ilike '%".$request->busqueda."%' or CAST(lead_time_proveedor AS VARCHAR(100)) ilike '%".$request->busqueda."%' or CAST(tiempo_entrega_proveedor AS VARCHAR(100)) ilike '%".$request->busqueda."%' or users.name ilike '%".$request->busqueda."%' or CAST(proveedors.updated_at AS VARCHAR(100)) like '%".$request->busqueda."%' ") );
        // $result = $this->arrayPaginator($result, $request);
        return response()->json($result);
    }
    // public function arrayPaginator($array, $request)
    // {
    //     $page = Input::get('page', 1);
    //     $perPage = 10;
    //     $offset = ($page * $perPage) - $perPage;

    //     return new LengthAwarePaginator(array_slice($array, $offset, $perPage, true), count($array), $perPage, $page,
    //         ['path' => $request->url(), 'query' => $request->query()]);
    // }
    /**
     * Delete confirmation message by Ajaxis.
     *
     * @link      https://github.com/amranidev/ajaxis
     * @param    \Illuminate\Http\Request  $request
     * @return  String
     */
    public function DeleteMsg($id,Request $request)
    {
        $msg = Ajaxis::BtDeleting('Precaución!!','¿Desea eliminar de forma permanente el proveedor! ?','/proveedor/'. $id . '/delete');

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
     	$proveedor = Proveedor::findOrfail($id);
     	$proveedor->delete();
        return URL::to('proveedor');
    }
}
