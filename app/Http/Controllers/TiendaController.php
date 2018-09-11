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

        $canales = Tienda::distinct()->get(['canal'])->sortBy('canal');
        $ciudades = Tienda::distinct()->get(['ciudad'])->sortBy('ciudad');
        $comunas = Tienda::distinct()->selectRaw("coalesce(comuna,'') as comuna")->get()->sortBy('comuna');
        $regiones = Tienda::distinct()->get(['region'])->sortBy('region');
        
        return view('tienda.create',compact('canales', 'ciudades', 'comunas', 'regiones'));
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

        if (strlen(trim($request->canal)) >= 1){
            $tienda->canal = $request->canal;
        }
        else{
            $tienda->canal = strtoupper(trim($request->nuevo_canal));
        }

        if (strlen(trim($request->ciudad)) >= 1){
            $tienda->ciudad = $request->ciudad;
        }
        else{
            $tienda->ciudad = ucwords(trim($request->nueva_ciudad));
        }
        
        if (strlen(trim($request->comuna)) >= 1){
            $tienda->comuna = $request->comuna;
        }
        else{
            $tienda->comuna = ucwords(trim($request->nueva_comuna));
        }
        
        if (strlen(trim($request->region)) >= 1){
            $tienda->region = $request->region;
        }
        else{
            $tienda->region = ucwords(trim($request->nueva_region));
        }
        
        $tienda->latitude = $request->latitude;

        
        $tienda->longitud = $request->longitud;

        
        $tienda->direccion = ucfirst($request->direccion);

        $tienda->user_id = Auth::user()->id;
        
        // $tienda->save();

        // $pusher = App::make('pusher');

        //default pusher notification.
        //by default channel=test-channel,event=test-event
        //Here is a pusher notification example when you create a new resource in storage.
        //you can modify anything you want or use it wherever.
        // $pusher->trigger('test-channel',
        //                  'test-event',
        //                 ['message' => 'Se ha creado una nueva bodega !!']);

        // return redirect('tienda');
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

        $canales = Tienda::distinct()->groupBy('canal')->get(['canal'])->sortBy('canal');
        $ciudades = Tienda::distinct()->groupBy('ciudad')->get(['ciudad'])->sortBy('ciudad');
        $comunas = Tienda::distinct()->groupBy('comuna')->selectRaw("coalesce(comuna,'') as comuna")->get()->sortBy('comuna');
        $regiones = Tienda::distinct()->groupBy('region')->get(['region'])->sortBy('region');

        $tienda = Tienda::findOrfail($id);
        return view('tienda.edit',compact('title','tienda', 'canales', 'ciudades', 'comunas', 'regiones'));
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
        
        $tienda->canal = strtoupper($request->canal);
        
        $tienda->ciudad = ucwords($request->ciudad);
        
        $tienda->comuna = ucwords($request->comuna);
        
        $tienda->region = ucwords($request->region);
        
        $tienda->latitude = $request->latitude;
        
        $tienda->longitud = $request->longitud;
        
        $tienda->direccion = ucfirst($request->direccion);
        
        $tienda->user_id = Auth::user()->id;
        
        $tienda->save();

        return redirect('tienda');
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
            $path = $request->file('up_csv')->storeAs('public/uploads/tienda', $archivo);
        } else {
            $message = 'Formato de archivo no permitido. Solo cargar archivos de extención csv';
            return view('tienda.fail',compact('message'));
        }
        //lee el csv
        Excel::load("storage\app\public\uploads\\tienda\\".$archivo, function($reader) {
            //recorre el csv
            foreach ($reader->get() as $tiendas) {
                // if ($tiendas->cod_tienda == "" or is_null($tiendas->cod_tienda)){
                //     $GLOBALS['validar'] = true;
                //     echo 'lat';
                // }
                if ($tiendas->bodega == "" or is_null($tiendas->bodega)){
                    $GLOBALS['validar'] = true;
                    echo 'lat';
                }
                if ($tiendas->canal == "" or is_null($tiendas->canal)){
                    $GLOBALS['validar'] = true;
                }
                if ($tiendas->ciudad == "" or is_null($tiendas->ciudad)){
                    $GLOBALS['validar'] = true;
                }
                if ($tiendas->region == "" or is_null($tiendas->region)){
                    $GLOBALS['validar'] = true;
                }
                if ($tiendas->latitude == "" or is_null($tiendas->latitude) or !is_numeric($tiendas->latitude)){
                    echo 'lat';
                    $GLOBALS['validar'] = true;
                }
                if ($tiendas->longitud == "" or is_null($tiendas->longitud) or !is_numeric($tiendas->longitud)){
                    echo 'long';
                    $GLOBALS['validar'] = true;
                }
                if ($tiendas->direccion == "" or is_null($tiendas->direccion)){
                    $GLOBALS['validar'] = true;
                }
            }
        });
        if ($validar){
            $message = 'La información que intenta cargar de Tiendas tiene datos que no son validos.<br>Verifique la información. ';
            return view('tienda.fail',compact('message'));
        }
        else{
            return view('tienda.warning', compact('archivo'));
        }
    }

    public function import(Request $request){
        //montar los datos el la bd
        //lee el csv
        Excel::load("storage\app\public\uploads\\tienda\\".$request->archivo, function($reader) {
            //elimina los regiustros existenetes
            Tienda::truncate();
            //recorre el csv
            foreach ($reader->get() as $tiendas) {
                //agrega los datos del csv a la bd
                Tienda::create([
                    'cod_tienda' => strtoupper($tiendas->cod_tienda),
                    'bodega' => strtoupper($tiendas->bodega),
                    'canal' => strtoupper($tiendas->canal),
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
        Storage::delete('public/uploads/tienda/'.$request->archivo);
    //     // return Book::all();
        return redirect('tienda');
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
