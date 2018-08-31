<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Nivel_servicio;
use Amranidev\Ajaxis\Ajaxis;
use URL;

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
        $nivel_servicios = Nivel_servicio::with('user')->orderBy('id', 'desc')->paginate(10);
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

        
        $nivel_servicio->letra = $request->letra;

        
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
    	
        $nivel_servicio->letra = $request->letra;
        
        $nivel_servicio->nivel_servicio = $request->nivel_servicio;
        
        $nivel_servicio->descripcion = $request->descripcion;
        
        $nivel_servicio->user_id = Auth::user()->id;
        
        $nivel_servicio->save();

        return redirect('nivel_servicio');
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
