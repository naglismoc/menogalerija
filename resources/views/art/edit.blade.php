@extends('layouts.app')

@section('content')
    <form action="{{route('art.update',$art)}}" method="post">
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
    <input class="btn btn-primary" type="submit" value="Išsaugoti">
    </form>
@endsection