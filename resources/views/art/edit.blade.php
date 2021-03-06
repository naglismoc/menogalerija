@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">PAVADINIMAS</div>
 
                <div class="card-body">

                    <form action="{{route('art.update',$art)}}" method="post"  enctype="multipart/form-data">
                        @csrf
                        pavadinimas
                    <input type="text" name="title" value="{{$art->title}}">
                    aprašas
                    <textarea name="description" rows="4" cols="50" value="">{{$art->description}}</textarea>
                    <select id="category_id" name="category_id[]"multiple="multiple">
                        <option value="0"> nera katerogijos</option>
                        @foreach ($categories as $category)
                            <?php 
                                $selected = "";
                            if( in_array( $category->name, $art->categoryNamesArr())  ){
                                $selected = "selected";
                            }?>
                            <option value="{{$category->id}}" {{$selected}}>{{$category->name}}</option>
                            {{-- <label for=""></label>
                            <input type="checkbox"  name="category_id" value="{{$category->name}}"> --}}
                        @endforeach
                    </select>
                
               
                   <br> <input class="btn btn-primary" type="submit" value="Išsaugoti">
                    </form>
                    <hr>
                    <form action="{{route('photo.store')}}" method="post"  enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="art_id" value="{{$art->id}}">
                        <label><b>Įkelkite <span style="color: red;"> nuotraukas </span> čia</b></label>
                        <input type="file" id="fileToUpload" name="photo" style="display: none">
                        <div onclick="document.getElementById('fileToUpload').click()" class="btn btn-primary" style="padding: 0.075rem 0.5rem;">Spausk čia</div><br>
                        <small id="fileText" class="form-text text-muted"></small>
                        <input type="hidden" id="delPhoto">
                        <input class="btn btn-primary" type="submit" value="Įkelti nuotrauką">
                    </form>
                    <hr>
                  <div class="row">
                        @foreach ($art->photos as $photo)
                        <div class="col-3">
                            <form action="{{route('photo.destroy',$photo)}}" method="post">
                                @csrf
                                <div class=" logo-container">
                                    <img class="logo" src="<?=asset("images/artGallery").'/'.$photo->name?>" alt="">
                                    <input class="del-btn" type="submit" value="X">
                                </div>
                            </form>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection