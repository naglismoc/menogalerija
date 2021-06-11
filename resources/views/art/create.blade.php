@extends('layouts.app')

@section('content')
<div class="container">
   <div class="row justify-content-center">
       <div class="col-md-8">
           <div class="card">
               <div class="card-header">PAVADINIMAS</div>

               <div class="card-body">
              
    <form action="{{route('art.store')}}" method="post" enctype="multipart/form-data">
        @csrf
        pavadinimas
        <input type="text" name="title" value="{{old('title')}}"> <br>
        aprašas
        <textarea name="description" rows="4" cols="50">{{old('description')}}</textarea>
       
        <label><b>Įkelkite <span style="color: red;"> nuotraukas </span> čia</b></label>
        <input type="file" id="fileToUpload" name="photo" style="display: none">
        <div onclick="document.getElementById('fileToUpload').click()" class="btn btn-primary" style="padding: 0.075rem 0.5rem;">Spausk čia</div><br>
        <small id="fileText" class="form-text text-muted"></small>

        <select id="category_id" name="category_id[]"multiple="multiple">
            @foreach ($categories as $category)
            @if(old('category_id') != null)
                @if(in_array($category->id, old('category_id')))
                        <option value="{{$category->id}}" selected>{{$category->name}}</option>
                @else
                    <option value="{{$category->id}}">{{$category->name}}</option>
                @endif
            @else
                <option value="{{$category->id}}">{{$category->name}}</option>
            @endif
                {{-- <label for=""></label>
                <input type="checkbox"  name="category_id" value="{{$category->name}}"> --}}
            @endforeach
        </select>
        <input class="btn btn-primary" type="submit" value="Išsaugoti">
    </form>

               </div>
           </div>
       </div>
   </div>
</div>
@endsection

