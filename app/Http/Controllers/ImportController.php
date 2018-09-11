<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class ImportController extends Controller
{
    public function import(Request $request){
        $extension = $request->file('up_csv')->getClientOriginalExtension();
        
        if($extension == 'csv'){
            
            $path = $request->file('up_csv')->storeAs('public/uploads', $_FILES["up_csv"]["name"]);
        } else {
            die("Formato de archivo no permitido. Solo cargar archivos de extención csv");
        }

    	Excel::load("storage\app\public\uploads\\".$_FILES["up_csv"]["name"], function($reader) {
 
        foreach ($reader->get() as $book) {
            if (!Book::where('name', '=', $book->title)->where('author', '=', $book->author)->where('year', '=', $book->publication_year)->exists()){
                Book::create([
                    'name' => $book->title,
                    'author' =>$book->author,
                    'year' =>$book->publication_year
                ]);
            }
        }
        });
        Storage::delete('public/uploads/'.$_FILES["up_csv"]["name"]);
        // return Book::all();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
