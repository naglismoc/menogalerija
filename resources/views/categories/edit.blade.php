@extends('layouts.app')

@section('content')
    <form action="{{route('category.update',$category)}}" method="post">
        @csrf
    <input type="text" name="name" value="{{$category->name}}">
    <input class="btn btn-primary" type="submit" value="Išsaugoti">
    </form>
@endsection