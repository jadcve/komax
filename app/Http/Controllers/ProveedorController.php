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
            die("Formato de archivo no permitido. Solo cargar archivos de extención csv");
        }
        //lee el csv
        Excel::load("storage\app\public\uploads\proveedor\\".$archivo, function($reader) {
            //recorre el csv
            foreach ($reader->get() as $proveedores) {
                if ($proveedores->codigo_proveedor == "" or is_null($proveedores->codigo_proveedor)){
                    $GLOBALS['validar'] = true;
                }
                if ($proveedores->descripcion_proveedor == "" or is_null($proveedores->descripcion_proveedor)){
                    $GLOBALS['validar'] = true;
                }
                if ($proveedores->lead_time_proveedor == "" or is_null($proveedores->lead_time_proveedor) or !is_numeric($proveedores->lead_time_proveedor)){
                    $GLOBALS['validar'] = true;
                }
                if ($proveedores->tiempo_entrega_proveedor == "" or is_null($proveedores->tiempo_entrega_proveedor) or !is_numeric($proveedores->tiempo_entrega_proveedor)){
                    $GLOBALS['validar'] = true;
                }
            }
        });
        if ($validar){
            $message = 'La información que intenta cargar de Proveedores tiene datos que no son validos.<br>Verifique la información. ';
            return view('proveedor.fail',compact('message'));
        }
        else{
            return view('proveedor.warning', compact('archivo'));
        }
    }

    public function import(Request $request){
        //montar los datos el la bd
        //lee el csv
        Excel::load("storage\app\public\uploads\proveedor\\".$request->archivo, function($reader) {
            //elimina los regiustros existenetes
            Proveedor::truncate();
            //recorre el csv
            foreach ($reader->get() as $proveedores) {
                // if (!Proveedor::where('name', '=', $proveedores->title)->where('author', '=', $proveedores->author)->where('year', '=', $proveedores->publication_year)->exists()){
                // $proveedor = new User;
                // $proveedor->codigo_proveedor = strtoupper($proveedores->codigo_proveedor);
                // $proveedor->descripcion_proveedor = $proveedores->descripcion_proveedor;
                // $proveedor->lead_time_proveedor = $proveedores->lead_time_proveedor;
                // $proveedor->tiempo_entrega_proveedor = $proveedores->tiempo_entrega_proveedor;
                // $proveedor->user_id = Auth::user()->id;
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
        Storage::delete('public/uploads/proveedor/'.$request->archivo);
    //     // return Book::all();
        return redirect('proveedor');
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
