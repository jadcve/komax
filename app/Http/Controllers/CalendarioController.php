<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Calendario;
use Amranidev\Ajaxis\Ajaxis;
use URL;

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
        $calendarios = Calendario::paginate(6);
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
        
        return view('calendario.create');
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

        
        $calendario->tienda_id = $request->tienda_id;

        
        
        $calendario->save();

        $pusher = App::make('pusher');

        //default pusher notification.
        //by default channel=test-channel,event=test-event
        //Here is a pusher notification example when you create a new resource in storage.
        //you can modify anything you want or use it wherever.
        $pusher->trigger('test-channel',
                         'test-event',
                        ['message' => 'A new calendario has been created !!']);

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
        return view('calendario.edit',compact('title','calendario'  ));
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
        
        $calendario->tienda_id = $request->tienda_id;
        
        
        $calendario->save();

        return redirect('calendario');
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
        $msg = Ajaxis::BtDeleting('Warning!!','Would you like to remove This?','/calendario/'. $id . '/delete');

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
