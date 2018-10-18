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
class ProveedorController1 extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function index()
    {   
        $title = 'Index - proveedor';
        $proveedors = Proveedor::with('user')->orderBy('id')->paginate(5);
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
        // $datos = fgetcsv($file);

        if ($file) {
            $num_lineas = 0;
            while ($linea = fgets($file)) {
                   $num_lineas++; 
            }
            echo $num_lineas.'<br>';
            fclose($file);
        //extrae los headers del csv
        $headersEncontrados = str_getcsv($lineaUno, ';', '"');
        //elimina los espacios en blanco y simbolos de los elementos del array
        array_walk($headersEncontrados, function (&$value){
            $replase_simbols = array("\\", "¨", "º", "-", "~", "#", "@", "|", "!", "\"", "·", "$", "%", "&", "/", "(", ")", "?", "'", "¡", "¿", "[", "^", "<code>", "]", "+", "}", "{", "¨", "´", ">", "< ", ";", ",", ":", ".", " ");
             $value = mb_convert_encoding($value, 'utf-8','ASCII');
             $value = mb_convert_encoding($value, 'ASCII','utf-8');
             $value = trim(str_replace($replase_simbols, '', $value));
         });
        //  var_dump($headersEncontrados);
         $totalHeadrers = count($headersEncontrados);
         echo 'totalHeadrers '.$totalHeadrers;
        //arreglo con los headers de proveedor
        // var_dump($headersEncontrados);
         $headersRequeridos = (array_search('"', $headersEncontrados) === false) ? array('SHIPPING_GROUP','ESTADO_ORDEN','ESTADO_SG','CLIENTE','RUT','LOCAL','TARJETA','RETIRO_EN_TIENDA','FECHA_VENTA','VENTANA_ENTREGA','COMUNA','CIUDAD','REGION','EMAIL','FECHA_ENTREGA','PLU','ITEM','DESCRIPCION','CANTIDAD','TIPO_PLU','TIPO_INVENTARIO','TIPO_ITEM','CATEGORIA','PRECIO','CANAL_DE_VENTA','PESO_VOLUMETRICO','WEIGHABLE','PICKING_STORE_ID','PICKING_STORE_NAME','ZONE_NAME','SHIP_VIA') : array('"SHIPPING_GROUP"','ESTADO_ORDEN','ESTADO_SG','CLIENTE','RUT','LOCAL','TARJETA','RETIRO_EN_TIENDA','FECHA_VENTA','VENTANA_ENTREGA','COMUNA','CIUDAD','REGION','EMAIL','FECHA_ENTREGA','PLU','ITEM','DESCRIPCION','CANTIDAD','TIPO_PLU','TIPO_INVENTARIO','TIPO_ITEM','CATEGORIA','PRECIO','CANAL_DE_VENTA','PESO_VOLUMETRICO','WEIGHABLE','PICKING_STORE_ID','PICKING_STORE_NAME','ZONE_NAME','SHIP_VIA');

        if ($headersEncontrados == $headersRequeridos) {
        }
        else{
            $message = 'Los headers del archivo que intenta cargar no coinciden. <br>
                La estructura del csv debe ser la siguiente:<br></h2><h4>'.implode('; ', $headersRequeridos).'</h4><br>
                <h2>Y la del archivo que intenta cargar es:</h2><br><h4>'.$lineaUno.'</h4>';
            //elimina el csv
            Storage::delete('public/uploads/proveedor/'.$archivo);
            return view('proveedor.fail',compact('message'));
         }
        //  \Config::set('excel::csv.delimiter', ';');
        //lee el csv
        
        // Excel::filter('chunk')->load("storage\app\public\uploads\proveedor\\".$archivo)->chunk(250, function($reader) {
//         foreach($results as $row)
//         {
//             // do stuff
//         }
// });
        // Excel::load("storage\app\public\uploads\proveedor\\".$archivo, function($reader) {
            //recorre el csv
            // unset($proveedores);
            
            // foreach ($reader->get() as $proveedores) {
                // $reader->skipRows(10)->takeRows(10)->dump();
            // foreach ($reader->skipRows(10)->takeRows(10)->toArray() as $proveedores) {
            //     // var_dump($proveedores);
            //     echo memory_get_usage(true).'<br>';
            //     echo $fila ++;
            //     echo '<br>';
            // }
            $file = fopen("../storage\app\public\uploads\proveedor\\".$archivo, 'r');
            $lineaUno = fgets($file);
            $fila = 1;
            
            while (($datos = fgetcsv($file, 0, ";")) !== FALSE) {
                // echo '<br>fila '.$fila.'<br>';
                // // $datos = fgetcsv($file);
                // echo 'Vardump datos<br>';
                // var_dump($datos);
                // echo '-----------------------------<br>';
                // echo 'Vardump headersEncontrados<br>';
                // var_dump($headersEncontrados);
                // echo '-----------------------------<br>';
                // // echo $bufer.'<br>';
                // var_dump(count($headersEncontrados) != count($datos));
                // echo '<br><br>pre headersEncontrados '.count($headersEncontrados).'<br>';
                //     echo 'pre datos '.count($datos).'<br><br>';

                if (count($headersEncontrados) != count($datos)) $GLOBALS['columna'] .= 'Número de campos no coincide: <span style="color:#1b5f9a;">fila: '.$fila.'</span><br>';
                
                $key = 0;
                foreach ($datos as $columnas) {
                    $headersEncontrados[$key];
                    // echo $headersEncontrados[$key].': - '.$columnas.' - <br>';
                    // validacion
                    if (trim($columnas) == "" or is_null($columnas)){
                        // echo '<br>'.$columnas.' ---------------------- <br>';
                        $GLOBALS['validar'] = true;
                        $GLOBALS['columna'] .= ' '.$headersEncontrados[$key].' <span style="color:#1b5f9a;">fila: '.$fila.'</span><br>';
                    }
                    $key++;
                }
                $fila ++;
                // echo '<br>';
            }
            if (!feof($file)) {
                echo "Error: fallo inesperado de fgets()\n";
            }
        }
        fclose($file);
                // if (trim($proveedores['#SHIPPING_GROUP']) == "" or is_null($proveedores['#SHIPPING_GROUP'])){
                //     echo $proveedores['#SHIPPING_GROUP'];
                //     $GLOBALS['validar'] = true;
                //     $GLOBALS['columna'] .= ' SHIPPING_GROUP <span style="color:#1b5f9a;">fila: '.$fila.'</span><br>';
                // }
                // if (trim($proveedores['ESTADO_ORDEN']) == "" or is_null($proveedores['ESTADO_ORDEN'])){
                //     echo $proveedores['ESTADO_ORDEN'];
                //     $GLOBALS['validar'] = true;
                //     $GLOBALS['columna'] .= ' ESTADO_ORDEN <span style="color:#1b5f9a;">fila: '.$fila.'</span><br>';
                // }
            //     if (trim($proveedores->ESTADO_SG) == "" or is_null($proveedores->ESTADO_SG)){
            //         $GLOBALS['validar'] = true;
            //         $GLOBALS['columna'] .= ' ESTADO_SG <span style="color:#1b5f9a;">fila: '.$fila.'</span><br>';
            //     }
            //     if (trim($proveedores->CLIENTE) == "" or is_null($proveedores->CLIENTE)){
            //         $GLOBALS['validar'] = true;
            //         $GLOBALS['columna'] .= ' CLIENTE <span style="color:#1b5f9a;">fila: '.$fila.'</span><br>';
            //     }
            //     if (trim($proveedores->RUT) == "" or is_null($proveedores->RUT)){
            //         $GLOBALS['validar'] = true;
            //         $GLOBALS['columna'] .= ' RUT <span style="color:#1b5f9a;">fila: '.$fila.'</span><br>';
            //     }
            //     if (trim($proveedores->LOCAL) == "" or is_null($proveedores->LOCAL)){
            //         $GLOBALS['validar'] = true;
            //         $GLOBALS['columna'] .= ' LOCAL <span style="color:#1b5f9a;">fila: '.$fila.'</span><br>';
            //     }
            //     if (trim($proveedores->TARJETA) == "" or is_null($proveedores->TARJETA)){
            //         $GLOBALS['validar'] = true;
            //         $GLOBALS['columna'] .= ' TARJETA <span style="color:#1b5f9a;">fila: '.$fila.'</span><br>';
            //     }
            //     if (trim($proveedores->RETIRO_EN_TIENDA) == "" or is_null($proveedores->RETIRO_EN_TIENDA)){
            //         $GLOBALS['validar'] = true;
            //         $GLOBALS['columna'] .= ' RETIRO_EN_TIENDA <span style="color:#1b5f9a;">fila: '.$fila.'</span><br>';
            //     }
            //     if (trim($proveedores->FECHA_VENTA) == "" or is_null($proveedores->FECHA_VENTA)){
            //         $GLOBALS['validar'] = true;
            //         $GLOBALS['columna'] .= ' FECHA_VENTA <span style="color:#1b5f9a;">fila: '.$fila.'</span><br>';
            //     }
            //     if (trim($proveedores->VENTANA_ENTREGA) == "" or is_null($proveedores->VENTANA_ENTREGA)){
            //         $GLOBALS['validar'] = true;
            //         $GLOBALS['columna'] .= ' VENTANA_ENTREGA <span style="color:#1b5f9a;">fila: '.$fila.'</span><br>';
            //     }
            //     if (trim($proveedores->COMUNA) == "" or is_null($proveedores->COMUNA)){
            //         $GLOBALS['validar'] = true;
            //         $GLOBALS['columna'] .= ' COMUNA <span style="color:#1b5f9a;">fila: '.$fila.'</span><br>';
            //     }
            //     if (trim($proveedores->CIUDAD) == "" or is_null($proveedores->CIUDAD)){
            //         $GLOBALS['validar'] = true;
            //         $GLOBALS['columna'] .= ' CIUDAD <span style="color:#1b5f9a;">fila: '.$fila.'</span><br>';
            //     }
            //     if (trim($proveedores->REGION) == "" or is_null($proveedores->REGION)){
            //         $GLOBALS['validar'] = true;
            //         $GLOBALS['columna'] .= ' REGION <span style="color:#1b5f9a;">fila: '.$fila.'</span><br>';
            //     }if (trim($proveedores->EMAIL) == "" or is_null($proveedores->EMAIL)){
            //         $GLOBALS['validar'] = true;
            //         $GLOBALS['columna'] .= ' EMAIL <span style="color:#1b5f9a;">fila: '.$fila.'</span><br>';
            //     }if (trim($proveedores->FECHA_ENTREGA) == "" or is_null($proveedores->FECHA_ENTREGA)){
            //         $GLOBALS['validar'] = true;
            //         $GLOBALS['columna'] .= ' FECHA_ENTREGA <span style="color:#1b5f9a;">fila: '.$fila.'</span><br>';
            //     }if (trim($proveedores->PLU) == "" or is_null($proveedores->PLU)){
            //         $GLOBALS['validar'] = true;
            //         $GLOBALS['columna'] .= ' PLU <span style="color:#1b5f9a;">fila: '.$fila.'</span><br>';
            //     }if (trim($proveedores->ITEM) == "" or is_null($proveedores->ITEM)){
            //         $GLOBALS['validar'] = true;
            //         $GLOBALS['columna'] .= ' ITEM <span style="color:#1b5f9a;">fila: '.$fila.'</span><br>';
            //     }if (trim($proveedores->DESCRIPCION) == "" or is_null($proveedores->DESCRIPCION)){
            //         $GLOBALS['validar'] = true;
            //         $GLOBALS['columna'] .= ' DESCRIPCION <span style="color:#1b5f9a;">fila: '.$fila.'</span><br>';
            //     }if (trim($proveedores->CANTIDAD) == "" or is_null($proveedores->CANTIDAD)){
            //         $GLOBALS['validar'] = true;
            //         $GLOBALS['columna'] .= ' CANTIDAD <span style="color:#1b5f9a;">fila: '.$fila.'</span><br>';
            //     }if (trim($proveedores->TIPO_PLU) == "" or is_null($proveedores->TIPO_PLU)){
            //         $GLOBALS['validar'] = true;
            //         $GLOBALS['columna'] .= ' TIPO_PLU <span style="color:#1b5f9a;">fila: '.$fila.'</span><br>';
            //     }
            //     if (trim($proveedores->TIPO_INVENTARIO) == "" or is_null($proveedores->TIPO_INVENTARIO)){
            //         $GLOBALS['validar'] = true;
            //         $GLOBALS['columna'] .= ' TIPO_INVENTARIO <span style="color:#1b5f9a;">fila: '.$fila.'</span><br>';
            //     }
            //     if (trim($proveedores->TIPO_ITEM) == "" or is_null($proveedores->TIPO_ITEM)){
            //         $GLOBALS['validar'] = true;
            //         $GLOBALS['columna'] .= ' TIPO_ITEM <span style="color:#1b5f9a;">fila: '.$fila.'</span><br>';
            //     }
            //     if (trim($proveedores->CATEGORIA) == "" or is_null($proveedores->CATEGORIA)){
            //         $GLOBALS['validar'] = true;
            //         $GLOBALS['columna'] .= ' CATEGORIA <span style="color:#1b5f9a;">fila: '.$fila.'</span><br>';
            //     }
            //     if (trim($proveedores->PRECIO) == "" or is_null($proveedores->PRECIO)){
            //         $GLOBALS['validar'] = true;
            //         $GLOBALS['columna'] .= ' PRECIO <span style="color:#1b5f9a;">fila: '.$fila.'</span><br>';
            //     }
            //     if (trim($proveedores->CANAL_DE_VENTA) == "" or is_null($proveedores->CANAL_DE_VENTA)){
            //         $GLOBALS['validar'] = true;
            //         $GLOBALS['columna'] .= ' CANAL_DE_VENTA <span style="color:#1b5f9a;">fila: '.$fila.'</span><br>';
            //     }
            //     if (trim($proveedores->PESO_VOLUMETRICO) == "" or is_null($proveedores->PESO_VOLUMETRICO)){
            //         $GLOBALS['validar'] = true;
            //         $GLOBALS['columna'] .= ' PESO_VOLUMETRICO <span style="color:#1b5f9a;">fila: '.$fila.'</span><br>';
            //     }
            //     if (trim($proveedores->WEIGHABLE) == "" or is_null($proveedores->WEIGHABLE)){
            //         $GLOBALS['validar'] = true;
            //         $GLOBALS['columna'] .= ' WEIGHABLE <span style="color:#1b5f9a;">fila: '.$fila.'</span><br>';
            //     }
            //     if (trim($proveedores->PICKING_STORE_ID) == "" or is_null($proveedores->PICKING_STORE_ID)){
            //         $GLOBALS['validar'] = true;
            //         $GLOBALS['columna'] .= ' PICKING_STORE_ID <span style="color:#1b5f9a;">fila: '.$fila.'</span><br>';
            //     }
            //     if (trim($proveedores->PICKING_STORE_NAME) == "" or is_null($proveedores->PICKING_STORE_NAME)){
            //         $GLOBALS['validar'] = true;
            //         $GLOBALS['columna'] .= ' PICKING_STORE_NAME <span style="color:#1b5f9a;">fila: '.$fila.'</span><br>';
            //     }
            //     if (trim($proveedores->ZONE_NAME) == "" or is_null($proveedores->ZONE_NAME)){
            //         $GLOBALS['validar'] = true;
            //         $GLOBALS['columna'] .= ' ZONE_NAME <span style="color:#1b5f9a;">fila: '.$fila.'</span><br>';
            //     }
            //     if (trim($proveedores->SHIP_VIA) == "" or is_null($proveedores->SHIP_VIA)){
            //         $GLOBALS['validar'] = true;
            //         $GLOBALS['columna'] .= ' SHIP_VIA <span style="color:#1b5f9a;">fila: '.$fila.'</span><br>';
            //     }
            // }
            // unset($proveedores);
        // });
        if ($validar){
            echo 'headers no ok';
            $message = 'La información que intenta cargar de Proveedores tiene datos que no son validos en:<br><span style="font-size: 1.5vw;"><strong>'.$columna.'</strong></span><br><span style="color: red; font-weight:bold;">Verifique la información.</span>';
            //elimina el csv
            Storage::delete('public/uploads/proveedor/'.$archivo);
            return view('proveedor.fail',compact('message'));
        }
        else{
            echo 'headers ok';
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
    
    public function arrayPaginator($array, $request){
        $page = Input::get('page', 1);
        $perPage = 10;
        $offset = ($page * $perPage) - $perPage;

        return new LengthAwarePaginator(array_slice($array, $offset, $perPage, true), count($array), $perPage, $page,
            ['path' => $request->url(), 'query' => $request->query()]);
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
