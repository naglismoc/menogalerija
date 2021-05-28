@extends('layouts.app')

@section('content')
<table>
    <tr>
        <th>Kategorija</th>
        <th>Redaguoti</th>
        <th>Šalinti</th>
    </tr>
  

@foreach ($categories as $category)
<tr>
    <td><h2>{{$category->name}}</h2></td>
    <td><a class="btn btn-primary" href="{{route('category.edit',$category)}}">redaguoti</a></td>
    <td>
        <form action="{{route('category.destroy',$category)}}" method="post">
            @csrf
            <input  class="btn btn-danger" type="submit" value="trinti">
        </form>
    </td>
  </tr>
@endforeach



@endsection