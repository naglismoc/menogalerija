<?php

namespace App\Http\Controllers;

use App\Models\Art;
use App\Models\Category;
use App\Models\ArtCategory;
use Illuminate\Http\Request;
use Auth;

class ArtController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::All();
        $art = Art::all();
        return view('art.index',["art" => $art,"categories" => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::All();
        return view('art.create',["categories" => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $art = Art::create([
            'title' => $request->title,
            'description' => $request->description,
            'status' => 0,
            'user_id' => Auth::user()->id,
        ]); 

        ArtCategory::create([
            'art_id' => $art->id,
            'category_id' => $request->category_id, 
        ]);

        return redirect()->route('art.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Art  $art
     * @return \Illuminate\Http\Response
     */
    public function show(Art $art)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Art  $art
     * @return \Illuminate\Http\Response
     */
    public function edit(Art $art)
    {
        return view('art.edit',['art' => $art]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Art  $art
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Art $art)
    {
        $art->name = $request->name;
        $art->save();
        return redirect()->route('art.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Art  $art
     * @return \Illuminate\Http\Response
     */
    public function destroy(Art $art)
    {
        $art->delete();
        return redirect()->route('art.index');
    }
}
