<?php

namespace App\Http\Controllers;

use App\Models\Art;
use App\Models\User;
use App\Models\ArtCategory;
use App\Models\Category;
use App\Models\Image;
use Auth;
use Illuminate\Http\Request;
use Validator;
use Str;
use Intervention\Image\ImageManagerStatic as ImageSaver;

class ArtController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except('index');
        // $this->middleware('auth')->except('index');
        // $this->middleware('auth')->except('index');
    }


       /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cat_id=0;
        $user_id=0;
        $sort=0;
        $getInfo = "";
        if(isset($_GET['sort'])){
            $cat_id=$_GET['sort'];
        }
        if(isset($_GET['category_id'])){
            $cat_id= $_GET['category_id'];
            
        }
        
    
        if(isset($_GET['user_id']) ){
            $user_id= $_GET['user_id'];

        }


      
        $categories = Category::orderBy('name')->get();
            $art = $this->getArt('');
        $users = User::all();
        return view('art.index', ["art" => $art, "categories" => $categories, 'users' => $users,'cat_id'=>$cat_id, 'user_id'=>$user_id,'sort'=>$sort]);
    }

    // public function public()
    // {
      
    //     $categories = Category::orderBy('name')->get();
    //     $art = getArt('');
    //     return view('art.index', ["art" => $art, "categories" => $categories]);
    // }
 

    public function singleUser()
    {
      
        $categories = Category::orderBy('name')->get();
        $art =  $this->getArt('single');
        return view('art.index', ["art" => $art, "categories" => $categories,"single" => true]);
    }



 public function getArt($single)
{
    $getInfo = "";
    if(isset($_GET['sort'])){
        $getInfo.=$_GET['sort'];
    }
    if(isset($_GET['category_id'])){
        if($_GET['category_id'] != '0'){
        $getInfo.=" cat";
        }
    }
    
    if(isset($_GET['single']) || $single!=""){
        $getInfo.=" single";
    }

    if(isset($_GET['user_id']) ){
        if(($_GET['user_id']!= '0') ){
        $getInfo.=" user";
        }
    }

    switch ($getInfo) {
        
        case " cat":
            $art =  Art::whereHas('categories', function($query){
                $query->where('categories.id', $_GET['category_id']);
            })->get();
          break;
        case "down cat":
            $art =  Art::whereHas('categories', function($query){
                $query->where('categories.id', $_GET['category_id']);
            })->orderBy('title','desc')->get();
          break;
        case "up cat":
            $art =  Art::whereHas('categories', function($query){
                $query->where('categories.id', $_GET['category_id']);
            })->orderBy('title','asc')->get();
            break;
        case "down":
            $art = Art::orderBy('title','desc')->get();
            break;
        case "up":
            $art = Art::orderBy('title')->get();
            break;


        case " cat single":
            $art =  Art::where('user_id', Auth::user()->id)->whereHas('categories', function($query){
                $query->where('categories.id', $_GET['category_id']);
            })->get();
            break;
        case "down cat single":
            $art =  Art::where('user_id', Auth::user()->id)->whereHas('categories', function($query){
                $query->where('categories.id', $_GET['category_id']);
            })->orderBy('title','desc')->get();
            break;
        case "up cat single":
            $art =  Art::where('user_id', Auth::user()->id)->whereHas('categories', function($query){
                $query->where('categories.id', $_GET['category_id']);
            })->orderBy('title','asc')->get();
            break;
        case "down single":
            $art = Art::where('user_id', Auth::user()->id)->orderBy('title','desc')->get();
            break;
        case "up single":
            $art = Art::where('user_id', Auth::user()->id)->orderBy('title')->get();
            break;
        case " single":
            $art = Art::where('user_id', Auth::user()->id)->orderBy('id','desc')->get();
            break;



        
        case " cat user":
            $art =  Art::where('user_id', $_GET['user_id'])->whereHas('categories', function($query){
                $query->where('categories.id', $_GET['category_id']);
            })->get();
            break;
        case "down cat user":
            $art =  Art::where('user_id',$_GET['user_id'])->whereHas('categories', function($query){
                $query->where('categories.id', $_GET['category_id']);
            })->orderBy('title','desc')->get();
            break;
        case "up cat user":
            $art =  Art::where('user_id', $_GET['user_id'])->whereHas('categories', function($query){
                $query->where('categories.id', $_GET['category_id']);
            })->orderBy('title','asc')->get();
            break;
        case "down user":
            $art = Art::where('user_id', $_GET['user_id'])->orderBy('title','desc')->get();
            break;
        case "up user":
            $art = Art::where('user_id', $_GET['user_id'])->orderBy('title')->get();
            break;
        case " user":
            $art = Art::where('user_id', $_GET['user_id'])->orderBy('id','desc')->get();
            break;    

        case "":
            $art = Art::orderBy('id','desc')->get();
            break;
      }
      return $art;
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
        // dd($request->photo);
        $validator = Validator::Make($request->all(),
        
            [
                'title' => ['required', 'max:50'],
                // 'file' => ['required|image|mimes:jpeg,png,jpg,bmp,gif,svg|max:2048'],
            ] , 
            [
                'title.max' => 'bišky per ilgas..',
                'title.required' => 'a kur pavadinimas, a?',
                'photo.image' => 'keista nuotrauka..',
            ]
        );
        if($validator->fails()){
            $request->flash();
            return redirect()->back()->withErrors($validator);
        }

       
        $art = Art::create([
            'title' => $request->title,
            'description' => $request->description,
            'status' => 0,
            'user_id' => Auth::user()->id,
        ]);

        $request->art_id = $art->id;
        $imgController = new ImageController();
        $imgController->store($request);


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
        return view('art.show', ["art" => $art]);
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
    public function enable(Art $art)
    {
        $art->status = 1;
        $art->save();
        return redirect()->route('art.index')->with('success_message', 'Sekmingai ijungta.');
    }
    public function disable(Art $art)
    {   
        $art->status = 0;
        $art->save();
        return redirect()->route('art.index')->with('success_message', 'Sekmingai išjungta.');
    }
}
