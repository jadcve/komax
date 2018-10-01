<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Bodega;
use App\User;
use Amranidev\Ajaxis\Ajaxis;
use URL;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use App\Convert_to_csv;
use Illuminate\Support\Facades\DB;

/**
 * Class BodegaController.
 *
 * @author  The scaffold-interface created at 2018-08-22 05:20:21pm
 * @link  https://github.com/amranidev/scaffold-interface
 */
class BodegaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Index - bodega';
        
        $bodegas = Bodega::with('user')->orderBy('id')->paginate(10);

        return view('bodega.index',compact('bodegas','title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Create - bodega';

        $agrupaciones1 = Bodega::distinct()->get(['agrupacion1'])->sortBy('agrupacion1');
        $ciudades = Bodega::distinct()->get(['ciudad'])->sortBy('ciudad');
        $comunas = Bodega::distinct()->selectRaw("coalesce(comuna,'') as comuna")->get()->sortBy('comuna');
        $regiones = Bodega::distinct()->get(['region'])->sortBy('region');
        
        return view('bodega.create',compact('agrupaciones1', 'ciudades', 'comunas', 'regiones'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param    \Illuminate\Http\Request  $request
     * @return  \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $bodega = new Bodega();
        
        $bodega->cod_bodega = strtoupper($request->cod_bodega);

        $bodega->bodega = strtoupper($request->bodega);

        if (strlen(trim($request->agrupacion1)) >= 1){
            $bodega->agrupacion1 = $request->agrupacion1;
        }
        else{
            if (!Bodega::where('agrupacion1', '=', strtoupper($request->nuevo_agrupacion1))->exists()){
                $bodega->agrupacion1 = strtoupper(trim($request->nuevo_agrupacion1));
            }
            else{
                $result = Bodega::where('agrupacion1', 'ilike', "%".$request->nuevo_agrupacion1."%")->distinct('agrupacion1')->get(['agrupacion1']);
                $bodega->agrupacion1 = $result[0]->agrupacion1;
            }
        }

        if (strlen(trim($request->ciudad)) >= 1){
            $bodega->ciudad = $request->ciudad;
        }
        else{
            if (!Bodega::where('ciudad', '=', strtoupper($request->nueva_ciudad))->exists()){
                $bodega->ciudad = ucwords(trim($request->nueva_ciudad));
            }
            else{
                $result = Bodega::where('ciudad', 'ilike', "%".$request->nueva_ciudad."%")->distinct('ciudad')->get(['ciudad']);
                $bodega->ciudad = $result[0]->ciudad;
            }
        }
        
        if (strlen(trim($request->comuna)) >= 1){
            $bodega->comuna = $request->comuna;
        }
        else{
            if (!Bodega::where('comuna', '=', strtoupper($request->nueva_comuna))->exists()){
                $bodega->comuna = ucwords(trim($request->nueva_comuna));
            }
            else{
                $result = Bodega::where('comuna', 'ilike', "%".$request->nueva_comuna."%")->distinct('comuna')->get(['comuna']);
                $bodega->comuna = $result[0]->comuna;
            }
        }
        
        if (strlen(trim($request->region)) >= 1){
            $bodega->region = $request->region;
        }
        else{
            if (!Bodega::where('region', '=', strtoupper($request->nueva_region))->exists()){
                $bodega->region = ucwords(trim($request->nueva_region));
            }
            else{
                $result = Bodega::where('region', 'ilike', "%".$request->nueva_region."%")->distinct('region')->get(['region']);
                $bodega->region = $result[0]->region;
            }
        }
        
        $bodega->latitude = $request->latitude;

        
        $bodega->longitud = $request->longitud;

        
        $bodega->direccion = ucfirst($request->direccion);

        $bodega->user_id = Auth::user()->id;
        
        $bodega->save();

        // $pusher = App::make('pusher');

        //default pusher notification.
        //by default channel=test-channel,event=test-event
        //Here is a pusher notification example when you create a new resource in storage.
        //you can modify anything you want or use it wherever.
        // $pusher->trigger('test-channel',
        //                  'test-event',
        //                 ['message' => 'Se ha creado una nueva bodega !!']);

        return redirect('bodega');
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
        $title = 'Show - bodega';

        if($request->ajax())
        {
            return URL::to('bodega/'.$id);
        }

        $bodega = Bodega::findOrfail($id);
        return view('bodega.show',compact('title','bodega'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param    \Illuminate\Http\Request  $request
     * @param    int  $id
     * @return  \Illuminate\Http\Response
     */
    public function edit($id,Request $request)
    {
        $title = 'Edit - bodega';
        if($request->ajax())
        {
            return URL::to('bodega/'. $id . '/edit');
        }

        $agrupaciones1 = Bodega::distinct()->groupBy('agrupacion1')->get(['agrupacion1'])->sortBy('agrupacion1');
        $ciudades = Bodega::distinct()->groupBy('ciudad')->get(['ciudad'])->sortBy('ciudad');
        $comunas = Bodega::distinct()->groupBy('comuna')->selectRaw("coalesce(comuna,'') as comuna")->get()->sortBy('comuna');
        $regiones = Bodega::distinct()->groupBy('region')->get(['region'])->sortBy('region');

        $bodega = Bodega::findOrfail($id);
        return view('bodega.edit',compact('title','bodega', 'agrupaciones1', 'ciudades', 'comunas', 'regiones'));
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
        $bodega = Bodega::findOrfail($id);
    	
        $bodega->cod_bodega = strtoupper($request->cod_bodega);
        
        $bodega->bodega = strtoupper($request->bodega);
        
        if (strlen(trim($request->agrupacion1)) >= 1){
            $bodega->agrupacion1 = $request->agrupacion1;
        }
        else{
            if (!Bodega::where('agrupacion1', '=', strtoupper($request->nuevo_agrupacion1))->exists()){
                $bodega->agrupacion1 = strtoupper(trim($request->nuevo_agrupacion1));
            }
            else{
                $result = Bodega::where('agrupacion1', 'ilike', "%".$request->nuevo_agrupacion1."%")->distinct('agrupacion1')->get(['agrupacion1']);
                $bodega->agrupacion1 = $result[0]->agrupacion1;
            }
        }

        if (strlen(trim($request->ciudad)) >= 1){
            $bodega->ciudad = $request->ciudad;
        }
        else{
            if (!Bodega::where('ciudad', '=', strtoupper($request->nueva_ciudad))->exists()){
                $bodega->ciudad = ucwords(trim($request->nueva_ciudad));
            }
            else{
                $result = bodega::where('ciudad', 'ilike', "%".$request->nueva_ciudad."%")->distinct('ciudad')->get(['ciudad']);
                $bodega->ciudad = $result[0]->ciudad;
            }
        }
        
        if (strlen(trim($request->comuna)) >= 1){
            $bodega->comuna = $request->comuna;
        }
        else{
            if (!Bodega::where('comuna', '=', strtoupper($request->nueva_comuna))->exists()){
                $bodega->comuna = ucwords(trim($request->nueva_comuna));
            }
            else{
                $result = Bodega::where('comuna', 'ilike', "%".$request->nueva_comuna."%")->distinct('comuna')->get(['comuna']);
                $bodega->comuna = $result[0]->comuna;
            }
        }
        
        if (strlen(trim($request->region)) >= 1){
            $bodega->region = $request->region;
        }
        else{
            if (!Bodega::where('region', '=', strtoupper($request->nueva_region))->exists()){
                $bodega->region = ucwords(trim($request->nueva_region));
            }
            else{
                $result = Bodega::where('region', 'ilike', "%".$request->nueva_region."%")->distinct('region')->get(['region']);
                $bodega->region = $result[0]->region;
            }
        }
        
        $bodega->latitude = $request->latitude;
        
        $bodega->longitud = $request->longitud;
        
        $bodega->direccion = ucfirst($request->direccion);
        
        $bodega->user_id = Auth::user()->id;
        
        $bodega->save();

        return redirect('bodega');
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
            $path = $request->file('up_csv')->storeAs('public/uploads/bodega', $archivo);
        } else {
            $message = 'Formato de archivo no permitido. Solo cargar archivos de extención csv';
            return view('bodega.fail',compact('message'));
        }

        //  abre el archivo
         $file = fopen("../storage\app\public\uploads\\bodega\\".$archivo, 'r');
         //tomo la primera linea
         $lineaUno = fgets($file);
         //cierra el archivo
         fclose($file);
         //extrae los headers del string de la primera linea
         $headersEncontrados = str_getcsv($lineaUno, ',', '"');
        //elimina los espacios en blanco y simbolos de los elementos del array
         array_walk($headersEncontrados, function (&$value){
            $replase_simbols = array("\\", "¨", "º", "-", "~", "#", "@", "|", "!", "\"", "·", "$", "%", "&", "/", "(", ")", "?", "'", "¡", "¿", "[", "^", "<code>", "]", "+", "}", "{", "¨", "´", ">", "< ", ";", ",", ":", ".", " ");
             $value = mb_convert_encoding($value, 'utf-8','ASCII');
             $value = mb_convert_encoding($value, 'ASCII','utf-8');
             $value = trim(str_replace($replase_simbols, '', $value));
         });

        $headersRequeridos = (array_search('"', $headersEncontrados) === false) ? array('cod_bodega', 'bodega', 'agrupacion1', 'ciudad', 'comuna', 'region', 'latitude', 'longitud', 'direccion') : array('"cod_bodega"', 'bodega', 'agrupacion1', 'ciudad', 'comuna', 'region', 'latitude', 'longitud', 'direccion');

         if ($headersEncontrados == $headersRequeridos) {
         }
         else{
             $message = 'Los headers del archivo que intenta cargar no coinciden. <br>
                 La estructura del csv debe ser la siguiente:<br></h2><h4>'.implode(', ', $headersRequeridos).'</h4><br>
                 <h2>Y la del archivo que intenta cargar es:</h2><br><h4>'.$lineaUno.'</h4>';
             //elimina el csv
             Storage::delete('public/uploads/bodega/'.$archivo);
             return view('bodega.fail',compact('message'));
          }
        //lee el csv
        Excel::load("storage\app\public\uploads\\bodega\\".$archivo, function($reader) {
            //recorre el csv
            $fila = 1;
            foreach ($reader->get() as $bodegas) {
                $fila ++;
                // if (trim($bodegas->cod_bodega) == "" or is_null($bodegas->cod_bodega)){
                //     $GLOBALS['validar'] = true;
                //     $GLOBALS['columna'] .= ' cod_bodega <span style="color:#1b5f9a;">fila: '.$fila.'</span><br>';
                // }
                if (trim($bodegas->bodega) == "" or is_null($bodegas->bodega)){
                    $GLOBALS['validar'] = true;
                    $GLOBALS['columna'] .= ' bodega <span style="color:#1b5f9a;">fila: '.$fila.'</span><br>';
                }
                if (trim($bodegas->agrupacion1) == "" or is_null($bodegas->agrupacion1)){
                    $GLOBALS['validar'] = true;
                    $GLOBALS['columna'] .= ' agrupacion1 <span style="color:#1b5f9a;">fila: '.$fila.'</span><br>';
                }
                if (trim($bodegas->ciudad) == "" or is_null($bodegas->ciudad)){
                    $GLOBALS['validar'] = true;
                    $GLOBALS['columna'] .= ' ciudad <span style="color:#1b5f9a;">fila: '.$fila.'</span><br>';
                }
                if (trim($bodegas->region) == "" or is_null($bodegas->region)){
                    $GLOBALS['validar'] = true;
                    $GLOBALS['columna'] .= ' region <span style="color:#1b5f9a;">fila: '.$fila.'</span><br>';
                }
                if (trim($bodegas->latitude) == "" or is_null($bodegas->latitude) or !is_numeric($bodegas->latitude)){
                    $GLOBALS['validar'] = true;
                    $GLOBALS['columna'] .= ' latitude <span style="color:#1b5f9a;">fila: '.$fila.'</span><br>';
                }
                if (trim($bodegas->longitud) == "" or is_null($bodegas->longitud) or !is_numeric($bodegas->longitud)){
                    $GLOBALS['validar'] = true;
                    $GLOBALS['columna'] .= ' longitud <span style="color:#1b5f9a;">fila: '.$fila.'</span><br>';
                }
                if (trim($bodegas->direccion) == "" or is_null($bodegas->direccion)){
                    $GLOBALS['validar'] = true;
                    $GLOBALS['columna'] .= ' direccion <span style="color:#1b5f9a;">fila: '.$fila.'</span><br>';
                }
            }
        });
        if ($validar){
            $message = 'La información que intenta cargar de bodegas tiene datos que no son validos en:<br><span style="font-size: 1.5vw;"><strong>'.$columna.'</strong></span><br><span style="color: red; font-weight:bold;">Verifique la información.</span>';
            Storage::delete('public/uploads/bodega/'.$archivo);
            return view('bodega.fail',compact('message'));
        }
        else{
            return view('bodega.warning', compact('archivo'));
        }
    }

    public function import(Request $request){
        $archivo = $request->archivo;
        //montar los datos el la bd
        //lee el csv
        Excel::load("storage\app\public\uploads\\bodega\\".$archivo, function($reader) {
            //elimina los regiustros existenetes
            Bodega::truncate();
            //recorre el csv
            foreach ($reader->get() as $bodegas) {
                //agrega los datos del csv a la bd
                Bodega::create([
                    'cod_bodega' => strtoupper($bodegas->cod_bodega),
                    'bodega' => strtoupper($bodegas->bodega),
                    'agrupacion1' => strtoupper($bodegas->agrupacion1),
                    'ciudad' => ucwords($bodegas->ciudad),
                    'comuna' => ucwords($bodegas->comuna),
                    'region' => ucwords($bodegas->region),
                    'latitude' => $bodegas->latitude,
                    'longitud' => $bodegas->longitud,
                    'direccion' => ucfirst($bodegas->direccion),
                    'user_id' => Auth::user()->id
                ]);
            }
        });
        //elimina el csv
        Storage::delete('public/uploads/bodega/'.$archivo);
    //     // return Book::all();
        return redirect('bodega');
    }

    public function download(){
        
        $datos = Bodega::all();

        $contenidoCsv = [];
        //headers del csv
        array_push($contenidoCsv, array('cod_bodega', 'bodega', 'agrupacion1', 'ciudad','comuna', 'region', 'latitude', 'longitud', 'direccion'));
        //agrego los datos al array
        foreach ($datos as $registro) {
            array_push($contenidoCsv, array($registro->cod_bodega, $registro->bodega, $registro->agrupacion1, $registro->ciudad, $registro->comuna, $registro->region, $registro->latitude, $registro->longitud, $registro->direccion));
        }
        //fecha para crear el nombre
        $fecha = date('Ymdhis');
        $nombreCsv = "bodegas_".$fecha.'.csv';

        //llama al metodo para crear el csv
        Convert_to_csv::create($contenidoCsv, $nombreCsv, ',');

        return view('bodega/download');
    }

    public function search(Request $request){
        $request->busqueda = strtoupper($request->busqueda);
        $result = DB::select( DB::raw("SELECT
        bodegas.id,
        bodegas.cod_bodega,
        bodegas.bodega,
        bodegas.agrupacion1,
        bodegas.ciudad,
        bodegas.comuna,
        bodegas.region,
        bodegas.latitude,
        bodegas.longitud,
        bodegas.direccion,
        bodegas.updated_at,
        users.name
    FROM
        bodegas INNER JOIN users ON (bodegas.user_id = users.id) 
    WHERE
        CAST(bodega AS VARCHAR(100)) ilike '%".$request->busqueda."%' or CAST(cod_bodega AS VARCHAR(100)) ilike '%".$request->busqueda."%' or CAST(agrupacion1 AS VARCHAR(100)) ilike '%".$request->busqueda."%' or CAST(ciudad AS VARCHAR(100)) ilike '%".$request->busqueda."%' or CAST(comuna AS VARCHAR(100)) ilike '%".$request->busqueda."%' or CAST(region AS VARCHAR(100)) ilike '%".$request->busqueda."%' or CAST(latitude AS VARCHAR(100)) ilike '%".$request->busqueda."%' or CAST(longitud AS VARCHAR(100)) ilike '%".$request->busqueda."%' or CAST(direccion AS VARCHAR(100)) ilike '%".$request->busqueda."%' or users.name ilike '%".$request->busqueda."%' or CAST(bodegas.updated_at AS VARCHAR(100)) like '%".$request->busqueda."%' ") );

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
        $msg = Ajaxis::BtDeleting('Precaución!!',"¿Desea eliminar de forma permanente la bodega! ?" ,'/bodega/'. $id . '/delete');

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
     	$bodega = Bodega::findOrfail($id);
     	$bodega->delete();
        return URL::to('bodega');
    }
}
