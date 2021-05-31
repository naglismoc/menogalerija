<?php

namespace App\Http\Controllers;

use App\Models\Art;
use App\Models\ArtCategory;
use App\Models\Category;
use Auth;
use Illuminate\Http\Request;

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
        return view('art.index', ["art" => $art, "categories" => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::All();
        return view('art.create', ["categories" => $categories]);
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
//  dd($request->category_id);
        for ($i = 0; $i < count($request->category_id); $i++) {
            $cat_id = $request->category_id[$i];
            ArtCategory::create([
                'art_id' => $art->id,
                'category_id' => $cat_id,
            ]);

        }

        return redirect()->route('art.index')->with('success_message', 'Sekmingai įkelta.');
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
        $categories = Category::All();
        return view('art.edit', ['art' => $art, "categories" => $categories]);
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
        // vertes kurios buvo pasirinktos ir liko
        // naujai pasirinktos vertes (irasyti)
        // vertes kuriu nebeliko.
        // atnaujint art objekta
 
        $catIdsArr = $art->categoryIdsArr();
        $catIdsDBArr = [];
        foreach ($request->category_id as $cat) {
            $catIdsDBArr[] = $cat;
        }


        foreach ($catIdsArr as $cat) {
            if (in_array($cat, $catIdsDBArr)) {
                if (($key = array_search($cat, $catIdsDBArr)) !== false) {
                    unset($catIdsDBArr[$key]);
                }
            }
        }

        foreach ($request->category_id as $cat) {
            if (in_array($cat, $catIdsArr)) {
                if (($key = array_search($cat, $catIdsArr)) !== false) {
                    unset($catIdsArr[$key]);
                }
            }
        }
        
        foreach ($catIdsArr as $key => $cat) {
            ArtCategory::where("category_id",$cat)->where("art_id", $art->id)->delete();
        }
        if(!in_array("0",$catIdsDBArr)){
            foreach ($catIdsDBArr as $key => $cat) {
                ArtCategory::create([
                    'art_id' => $art->id,
                    'category_id' => $catIdsDBArr[$key],
                ]);
            }
        }

        $art->title = $request->title;
        $art->description = $request->description;
        $art->save();

        return redirect()->route('art.index')->with('success_message', 'Sekmingai atnaujinta.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Art  $art
     * @return \Illuminate\Http\Response
     */
    public function destroy(Art $art)
    {


        foreach ($art->categoryIdsArr() as $key => $cat) {
            ArtCategory::where("category_id",$cat)->where("art_id", $art->id)->delete();
        }
        $art->delete();
        return redirect()->route('art.index')->with('success_message', 'Sekmingai ištrinta.');
    }
}
