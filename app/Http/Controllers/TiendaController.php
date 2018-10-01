<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Tienda;
use App\User;
use Amranidev\Ajaxis\Ajaxis;
use URL;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use App\Convert_to_csv;
use Illuminate\Support\Facades\DB;

/**
 * Class TiendaController.
 *
 * @author  The scaffold-interface created at 2018-08-22 05:20:21pm
 * @link  https://github.com/amranidev/scaffold-interface
 */
class TiendaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Index - tienda';
        
        $tiendas = Tienda::with('user')->orderBy('id')->paginate(10);

        return view('tienda.index',compact('tiendas','title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Create - tienda';

        $agrupaciones1 = Tienda::distinct()->get(['agrupacion1'])->sortBy('agrupacion1');
        $ciudades = Tienda::distinct()->get(['ciudad'])->sortBy('ciudad');
        $comunas = Tienda::distinct()->selectRaw("coalesce(comuna,'') as comuna")->get()->sortBy('comuna');
        $regiones = Tienda::distinct()->get(['region'])->sortBy('region');
        
        return view('tienda.create',compact('agrupaciones1', 'ciudades', 'comunas', 'regiones'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param    \Illuminate\Http\Request  $request
     * @return  \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tienda = new Tienda();
        
        $tienda->cod_tienda = strtoupper($request->cod_tienda);

        $tienda->bodega = strtoupper($request->bodega);

        if (strlen(trim($request->agrupacion1)) >= 1){
            $tienda->agrupacion1 = $request->agrupacion1;
        }
        else{
            if (!Tienda::where('agrupacion1', '=', strtoupper($request->nuevo_agrupacion1))->exists()){
                $tienda->agrupacion1 = strtoupper(trim($request->nuevo_agrupacion1));
            }
            else{
                $result = Tienda::where('agrupacion1', 'ilike', "%".$request->nuevo_agrupacion1."%")->distinct('agrupacion1')->get(['agrupacion1']);
                echo $tienda->agrupacion1 = $result[0]->agrupacion1;
            }
        }

        if (strlen(trim($request->ciudad)) >= 1){
            $tienda->ciudad = $request->ciudad;
        }
        else{
            if (!Tienda::where('ciudad', '=', strtoupper($request->nueva_ciudad))->exists()){
                $tienda->ciudad = ucwords(trim($request->nueva_ciudad));
            }
            else{
                $result = Tienda::where('ciudad', 'ilike', "%".$request->nueva_ciudad."%")->distinct('ciudad')->get(['ciudad']);
                echo $tienda->ciudad = $result[0]->ciudad;
            }
        }
        
        if (strlen(trim($request->comuna)) >= 1){
            $tienda->comuna = $request->comuna;
        }
        else{
            if (!Tienda::where('comuna', '=', strtoupper($request->nueva_comuna))->exists()){
                $tienda->comuna = ucwords(trim($request->nueva_comuna));
            }
            else{
                $result = Tienda::where('comuna', 'ilike', "%".$request->nueva_comuna."%")->distinct('comuna')->get(['comuna']);
                echo $tienda->comuna = $result[0]->comuna;
            }
        }
        
        if (strlen(trim($request->region)) >= 1){
            $tienda->region = $request->region;
        }
        else{
            if (!Tienda::where('region', '=', strtoupper($request->nueva_region))->exists()){
                $tienda->region = ucwords(trim($request->nueva_region));
            }
            else{
                $result = Tienda::where('region', 'ilike', "%".$request->nueva_region."%")->distinct('region')->get(['region']);
                echo $tienda->region = $result[0]->region;
            }
        }
        
        $tienda->latitude = $request->latitude;

        
        $tienda->longitud = $request->longitud;

        
        $tienda->direccion = ucfirst($request->direccion);

        $tienda->user_id = Auth::user()->id;
        
        $tienda->save();

        // $pusher = App::make('pusher');

        //default pusher notification.
        //by default channel=test-channel,event=test-event
        //Here is a pusher notification example when you create a new resource in storage.
        //you can modify anything you want or use it wherever.
        // $pusher->trigger('test-channel',
        //                  'test-event',
        //                 ['message' => 'Se ha creado una nueva bodega !!']);

        return redirect('tienda');
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
        $title = 'Show - tienda';

        if($request->ajax())
        {
            return URL::to('tienda/'.$id);
        }

        $tienda = Tienda::findOrfail($id);
        return view('tienda.show',compact('title','tienda'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param    \Illuminate\Http\Request  $request
     * @param    int  $id
     * @return  \Illuminate\Http\Response
     */
    public function edit($id,Request $request)
    {
        $title = 'Edit - tienda';
        if($request->ajax())
        {
            return URL::to('tienda/'. $id . '/edit');
        }

        $agrupaciones1 = Tienda::distinct()->groupBy('agrupacion1')->get(['agrupacion1'])->sortBy('agrupacion1');
        $ciudades = Tienda::distinct()->groupBy('ciudad')->get(['ciudad'])->sortBy('ciudad');
        $comunas = Tienda::distinct()->groupBy('comuna')->selectRaw("coalesce(comuna,'') as comuna")->get()->sortBy('comuna');
        $regiones = Tienda::distinct()->groupBy('region')->get(['region'])->sortBy('region');

        $tienda = Tienda::findOrfail($id);
        return view('tienda.edit',compact('title','tienda', 'agrupaciones1', 'ciudades', 'comunas', 'regiones'));
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
        $tienda = Tienda::findOrfail($id);
    	
        $tienda->cod_tienda = strtoupper($request->cod_tienda);
        
        $tienda->bodega = strtoupper($request->bodega);
        
        if (strlen(trim($request->agrupacion1)) >= 1){
            $tienda->agrupacion1 = $request->agrupacion1;
        }
        else{
            if (!Tienda::where('agrupacion1', '=', strtoupper($request->nuevo_agrupacion1))->exists()){
                $tienda->agrupacion1 = strtoupper(trim($request->nuevo_agrupacion1));
            }
            else{
                $result = Tienda::where('agrupacion1', 'ilike', "%".$request->nuevo_agrupacion1."%")->distinct('agrupacion1')->get(['agrupacion1']);
                echo $tienda->agrupacion1 = $result[0]->agrupacion1;
            }
        }

        if (strlen(trim($request->ciudad)) >= 1){
            $tienda->ciudad = $request->ciudad;
        }
        else{
            if (!Tienda::where('ciudad', '=', strtoupper($request->nueva_ciudad))->exists()){
                $tienda->ciudad = ucwords(trim($request->nueva_ciudad));
            }
            else{
                $result = Tienda::where('ciudad', 'ilike', "%".$request->nueva_ciudad."%")->distinct('ciudad')->get(['ciudad']);
                echo $tienda->ciudad = $result[0]->ciudad;
            }
        }
        
        if (strlen(trim($request->comuna)) >= 1){
            $tienda->comuna = $request->comuna;
        }
        else{
            if (!Tienda::where('comuna', '=', strtoupper($request->nueva_comuna))->exists()){
                $tienda->comuna = ucwords(trim($request->nueva_comuna));
            }
            else{
                $result = Tienda::where('comuna', 'ilike', "%".$request->nueva_comuna."%")->distinct('comuna')->get(['comuna']);
                echo $tienda->comuna = $result[0]->comuna;
            }
        }
        
        if (strlen(trim($request->region)) >= 1){
            $tienda->region = $request->region;
        }
        else{
            if (!Tienda::where('region', '=', strtoupper($request->nueva_region))->exists()){
                $tienda->region = ucwords(trim($request->nueva_region));
            }
            else{
                $result = Tienda::where('region', 'ilike', "%".$request->nueva_region."%")->distinct('region')->get(['region']);
                echo $tienda->region = $result[0]->region;
            }
        }
        
        $tienda->latitude = $request->latitude;
        
        $tienda->longitud = $request->longitud;
        
        $tienda->direccion = ucfirst($request->direccion);
        
        $tienda->user_id = Auth::user()->id;
        
        $tienda->save();

        // return redirect('tienda');
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
            $path = $request->file('up_csv')->storeAs('public/uploads/tienda', $archivo);
        } else {
            $message = 'Formato de archivo no permitido. Solo cargar archivos de extención csv';
            return view('tienda.fail',compact('message'));
        }

        //  abre el archivo
         $file = fopen("../storage\app\public\uploads\\tienda\\".$archivo, 'r');
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

        $headersRequeridos = (array_search('"', $headersEncontrados) === false) ? array('cod_tienda', 'bodega', 'agrupacion1', 'ciudad', 'comuna', 'region', 'latitude', 'longitud', 'direccion') : array('"cod_tienda"', 'bodega', 'agrupacion1', 'ciudad', 'comuna', 'region', 'latitude', 'longitud', 'direccion');

         if ($headersEncontrados == $headersRequeridos) {
         }
         else{
             $message = 'Los headers del archivo que intenta cargar no coinciden. <br>
                 La estructura del csv debe ser la siguiente:<br></h2><h4>'.implode(', ', $headersRequeridos).'</h4><br>
                 <h2>Y la del archivo que intenta cargar es:</h2><br><h4>'.$lineaUno.'</h4>';
             //elimina el csv
             Storage::delete('public/uploads/tienda/'.$archivo);
             return view('tienda.fail',compact('message'));
          }
        //lee el csv
        Excel::load("storage\app\public\uploads\\tienda\\".$archivo, function($reader) {
            //recorre el csv
            $fila = 1;
            foreach ($reader->get() as $tiendas) {
                $fila ++;
                // if (trim($tiendas->cod_tienda) == "" or is_null($tiendas->cod_tienda)){
                //     $GLOBALS['validar'] = true;
                //     $GLOBALS['columna'] .= ' cod_tienda <span style="color:#1b5f9a;">fila: '.$fila.'</span><br>';
                // }
                if (trim($tiendas->bodega) == "" or is_null($tiendas->bodega)){
                    $GLOBALS['validar'] = true;
                    $GLOBALS['columna'] .= ' bodega <span style="color:#1b5f9a;">fila: '.$fila.'</span><br>';
                }
                if (trim($tiendas->agrupacion1) == "" or is_null($tiendas->agrupacion1)){
                    $GLOBALS['validar'] = true;
                    $GLOBALS['columna'] .= ' agrupacion1 <span style="color:#1b5f9a;">fila: '.$fila.'</span><br>';
                }
                if (trim($tiendas->ciudad) == "" or is_null($tiendas->ciudad)){
                    $GLOBALS['validar'] = true;
                    $GLOBALS['columna'] .= ' ciudad <span style="color:#1b5f9a;">fila: '.$fila.'</span><br>';
                }
                if (trim($tiendas->region) == "" or is_null($tiendas->region)){
                    $GLOBALS['validar'] = true;
                    $GLOBALS['columna'] .= ' region <span style="color:#1b5f9a;">fila: '.$fila.'</span><br>';
                }
                if (trim($tiendas->latitude) == "" or is_null($tiendas->latitude) or !is_numeric($tiendas->latitude)){
                    $GLOBALS['validar'] = true;
                    $GLOBALS['columna'] .= ' latitude <span style="color:#1b5f9a;">fila: '.$fila.'</span><br>';
                }
                if (trim($tiendas->longitud) == "" or is_null($tiendas->longitud) or !is_numeric($tiendas->longitud)){
                    $GLOBALS['validar'] = true;
                    $GLOBALS['columna'] .= ' longitud <span style="color:#1b5f9a;">fila: '.$fila.'</span><br>';
                }
                if (trim($tiendas->direccion) == "" or is_null($tiendas->direccion)){
                    $GLOBALS['validar'] = true;
                    $GLOBALS['columna'] .= ' direccion <span style="color:#1b5f9a;">fila: '.$fila.'</span><br>';
                }
            }
        });
        if ($validar){
            $message = 'La información que intenta cargar de Tiendas tiene datos que no son validos en:<br><span style="font-size: 1.5vw;"><strong>'.$columna.'</strong></span><br><span style="color: red; font-weight:bold;">Verifique la información.</span>';
            Storage::delete('public/uploads/tienda/'.$archivo);
            return view('tienda.fail',compact('message'));
        }
        else{
            return view('tienda.warning', compact('archivo'));
        }
    }

    public function import(Request $request){
        $archivo = $request->archivo;
        //montar los datos el la bd
        //lee el csv
        Excel::load("storage\app\public\uploads\\tienda\\".$archivo, function($reader) {
            //elimina los regiustros existenetes
            Tienda::truncate();
            //recorre el csv
            foreach ($reader->get() as $tiendas) {
                //agrega los datos del csv a la bd
                Tienda::create([
                    'cod_tienda' => strtoupper($tiendas->cod_tienda),
                    'bodega' => strtoupper($tiendas->bodega),
                    'agrupacion1' => strtoupper($tiendas->agrupacion1),
                    'ciudad' => ucwords($tiendas->ciudad),
                    'comuna' => ucwords($tiendas->comuna),
                    'region' => ucwords($tiendas->region),
                    'latitude' => $tiendas->latitude,
                    'longitud' => $tiendas->longitud,
                    'direccion' => ucfirst($tiendas->direccion),
                    'user_id' => Auth::user()->id
                ]);
            }
        });
        //elimina el csv
        Storage::delete('public/uploads/tienda/'.$archivo);
    //     // return Book::all();
        return redirect('tienda');
    }

    public function download(){
        
        $datos = Tienda::all();

        $contenidoCsv = [];
        //headers del csv
        array_push($contenidoCsv, array('cod_tienda', 'bodega', 'agrupacion1', 'ciudad','comuna', 'region', 'latitude', 'longitud', 'direccion'));
        //agrego los datos al array
        foreach ($datos as $registro) {
            array_push($contenidoCsv, array($registro->cod_tienda, $registro->bodega, $registro->agrupacion1, $registro->ciudad, $registro->comuna, $registro->region, $registro->latitude, $registro->longitud, $registro->direccion));
        }
        //fecha para crear el nombre
        $fecha = date('Ymdhis');
        $nombreCsv = "tiendas_".$fecha.'.csv';

        //llama al metodo para crear el csv
        Convert_to_csv::create($contenidoCsv, $nombreCsv, ',');

        return view('tienda/download');
    }

    public function search(Request $request){
        $request->busqueda = strtoupper($request->busqueda);
        $result = DB::select( DB::raw("SELECT
        tiendas.id,
        tiendas.cod_tienda,
        tiendas.bodega,
        tiendas.agrupacion1,
        tiendas.ciudad,
        tiendas.comuna,
        tiendas.region,
        tiendas.latitude,
        tiendas.longitud,
        tiendas.direccion,
        tiendas.updated_at,
        users.name
    FROM
        tiendas INNER JOIN users ON (tiendas.user_id = users.id) 
    WHERE
        CAST(bodega AS VARCHAR(100)) ilike '%".$request->busqueda."%' or CAST(cod_tienda AS VARCHAR(100)) ilike '%".$request->busqueda."%' or CAST(agrupacion1 AS VARCHAR(100)) ilike '%".$request->busqueda."%' or CAST(ciudad AS VARCHAR(100)) ilike '%".$request->busqueda."%' or CAST(comuna AS VARCHAR(100)) ilike '%".$request->busqueda."%' or CAST(region AS VARCHAR(100)) ilike '%".$request->busqueda."%' or CAST(latitude AS VARCHAR(100)) ilike '%".$request->busqueda."%' or CAST(longitud AS VARCHAR(100)) ilike '%".$request->busqueda."%' or CAST(direccion AS VARCHAR(100)) ilike '%".$request->busqueda."%' or users.name ilike '%".$request->busqueda."%' or CAST(tiendas.updated_at AS VARCHAR(100)) like '%".$request->busqueda."%' ") );

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
        $msg = Ajaxis::BtDeleting('Precaución!!',"¿Desea eliminar de forma permanente la tienda! ?" ,'/tienda/'. $id . '/delete');

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
     	$tienda = Tienda::findOrfail($id);
     	$tienda->delete();
        return URL::to('tienda');
    }
}
