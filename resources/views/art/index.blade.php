@extends('layouts.app')

@section('content')
<table>
    <tr>
        <th>Pavadinimas</th>
        <th>Aprašas</th>
        <th>Kategorijos</th>
        <th>Redaguoti</th>
        <th>Šalinti</th>
    </tr>
  

@foreach ($art as $artUnit)
<tr>
    <td><h2>{{$artUnit->title}}</h2></td>
    <td>{{$artUnit->description}}</td>
    <td>{{  $artUnit->categoryNames()  }}</td>
    <td><a class="btn btn-primary" href="{{route('art.edit',$artUnit)}}">redaguoti</a></td>
    <td>
        <form action="{{route('art.destroy',$artUnit)}}" method="post">
            @csrf
            <input  class="btn btn-danger" type="submit" value="trinti">
        </form>
    </td>
  </tr>
@endforeach



@endsection