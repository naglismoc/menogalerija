@extends('layouts.app')

@section('content')
    <form action="{{route('category.store')}}" method="post">
        @csrf
    <input type="text" name="name">
    <input class="btn btn-primary" type="submit" value="Išsaugoti">
    </form>
@endsection