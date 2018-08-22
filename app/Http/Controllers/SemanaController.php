<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Semana;
use Amranidev\Ajaxis\Ajaxis;
use URL;

/**
 * Class SemanaController.
 *
 * @author  The scaffold-interface created at 2018-08-22 06:02:13pm
 * @link  https://github.com/amranidev/scaffold-interface
 */
class SemanaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Index - semana';
        $semanas = Semana::paginate(6);
        return view('semana.index',compact('semanas','title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Create - semana';
        
        return view('semana.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param    \Illuminate\Http\Request  $request
     * @return  \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $semana = new Semana();

        
        $semana->dia_semana = $request->dia_semana;

        
        $semana->dia = $request->dia;

        
        $semana->calendario_id = $request->calendario_id;

        
        
        $semana->save();

        $pusher = App::make('pusher');

        //default pusher notification.
        //by default channel=test-channel,event=test-event
        //Here is a pusher notification example when you create a new resource in storage.
        //you can modify anything you want or use it wherever.
        $pusher->trigger('test-channel',
                         'test-event',
                        ['message' => 'A new semana has been created !!']);

        return redirect('semana');
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
        $title = 'Show - semana';

        if($request->ajax())
        {
            return URL::to('semana/'.$id);
        }

        $semana = Semana::findOrfail($id);
        return view('semana.show',compact('title','semana'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param    \Illuminate\Http\Request  $request
     * @param    int  $id
     * @return  \Illuminate\Http\Response
     */
    public function edit($id,Request $request)
    {
        $title = 'Edit - semana';
        if($request->ajax())
        {
            return URL::to('semana/'. $id . '/edit');
        }

        
        $semana = Semana::findOrfail($id);
        return view('semana.edit',compact('title','semana'  ));
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
        $semana = Semana::findOrfail($id);
    	
        $semana->dia_semana = $request->dia_semana;
        
        $semana->dia = $request->dia;
        
        $semana->calendario_id = $request->calendario_id;
        
        
        $semana->save();

        return redirect('semana');
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
        $msg = Ajaxis::BtDeleting('Warning!!','Would you like to remove This?','/semana/'. $id . '/delete');

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
     	$semana = Semana::findOrfail($id);
     	$semana->delete();
        return URL::to('semana');
    }
}
