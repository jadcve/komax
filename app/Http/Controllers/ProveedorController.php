<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Proveedor;
use Amranidev\Ajaxis\Ajaxis;
use URL;

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
        $proveedors = Proveedor::paginate(6);
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

        
        $proveedor->cod_prov = $request->cod_prov;

        
        $proveedor->nombre_prov = $request->nombre_prov;

        
        $proveedor->leedt_prov = $request->leedt_prov;

        
        $proveedor->tentrega_prov = $request->tentrega_prov;

        
        
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
    	
        $proveedor->cod_prov = $request->cod_prov;
        
        $proveedor->nombre_prov = $request->nombre_prov;
        
        $proveedor->leedt_prov = $request->leedt_prov;
        
        $proveedor->tentrega_prov = $request->tentrega_prov;
        
        
        $proveedor->save();

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
