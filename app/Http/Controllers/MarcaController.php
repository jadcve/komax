<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Marca;
use Amranidev\Ajaxis\Ajaxis;
use URL;

/**
 * Class MarcaController.
 *
 * @author  The scaffold-interface created at 2018-09-04 02:54:33pm
 * @link  https://github.com/amranidev/scaffold-interface
 */
class MarcaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Index - marca';
        $marcas = Marca::paginate(6);
        return view('marca.index',compact('marcas','title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Create - marca';
        
        return view('marca.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param    \Illuminate\Http\Request  $request
     * @return  \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $marca = new Marca();

        
        $marca->canal = $request->canal;

        
        $marca->marca = $request->marca;

        
        
        $marca->save();

        $pusher = App::make('pusher');

        //default pusher notification.
        //by default channel=test-channel,event=test-event
        //Here is a pusher notification example when you create a new resource in storage.
        //you can modify anything you want or use it wherever.
        $pusher->trigger('test-channel',
                         'test-event',
                        ['message' => 'A new marca has been created !!']);

        return redirect('marca');
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
        $title = 'Show - marca';

        if($request->ajax())
        {
            return URL::to('marca/'.$id);
        }

        $marca = Marca::findOrfail($id);
        return view('marca.show',compact('title','marca'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param    \Illuminate\Http\Request  $request
     * @param    int  $id
     * @return  \Illuminate\Http\Response
     */
    public function edit($id,Request $request)
    {
        $title = 'Edit - marca';
        if($request->ajax())
        {
            return URL::to('marca/'. $id . '/edit');
        }

        
        $marca = Marca::findOrfail($id);
        return view('marca.edit',compact('title','marca'  ));
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
        $marca = Marca::findOrfail($id);
    	
        $marca->canal = $request->canal;
        
        $marca->marca = $request->marca;
        
        
        $marca->save();

        return redirect('marca');
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
        $msg = Ajaxis::BtDeleting('Warning!!','Would you like to remove This?','/marca/'. $id . '/delete');

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
     	$marca = Marca::findOrfail($id);
     	$marca->delete();
        return URL::to('marca');
    }
}
