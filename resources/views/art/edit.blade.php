@extends('layouts.app')

@section('content')
    <form action="{{route('art.update',$art)}}" method="post">
        @csrf
        pavadinimas
    <input type="text" name="title" value="{{$art->title}}">
    aprašas
    <textarea name="description" rows="4" cols="50" value="">{{$art->description}}</textarea>
    <input class="btn btn-primary" type="submit" value="Išsaugoti">
    </form>
@endsection