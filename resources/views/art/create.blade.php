@extends('layouts.app')

@section('content')
<div class="container">
   <div class="row justify-content-center">
       <div class="col-md-8">
           <div class="card">
               <div class="card-header">PAVADINIMAS</div>

               <div class="card-body">
              
    <form action="{{route('art.store')}}" method="post">
        @csrf
        pavadinimas
        <input type="text" name="title"><br>
        aprašas
        <textarea name="description" rows="4" cols="50"></textarea>
        <select id="category_id" name="category_id[]"multiple="multiple">
            @foreach ($categories as $category)
                <option value="{{$category->id}}">{{$category->name}}</option>
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

