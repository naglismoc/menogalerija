<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as ImageSaver;
use Str;

class ImageController extends Controller
{
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
        if($request->has('photo')){
            // dd($request->file('photo'));
            $img = ImageSaver::make($request->file('photo'));
            $fileName = Str::random(5).".jpg";
            $folder = public_path("images/artGallery");
            $img->resize(1200,null, function($contraint){
                $contraint->aspectRatio();
            });
            $img->save($folder.'/'.$fileName,80,'jpg');
        }
        $image = new Image();
        $image->art_id = $request->art_id;
        $image->name = $fileName;
        $image->save();
        return redirect()->back()->with('success_message','Nuotrauka sėkmingai įkelta'); 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function show(Image $image)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function edit(Image $image)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Image $image)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function destroy(Image $image)
    {
        $folder = public_path("images\\artGallery");
        unlink( $folder.'\\'.$image->name);
        $image->delete();
        return redirect()->back()->with('success_message','Nuotrauka sėkmingai ištrinta'); 
    }
}
