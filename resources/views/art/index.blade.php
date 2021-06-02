@extends('layouts.app')

@section('content')
<div class="container">
   <div class="row justify-content-center">
       <div class="col-md-12">
           <div class="card">
            <div class="card-header">PAVADINIMAS</div>
            <div class="col-md-12">
                {{-- <h1>{{$_GET["category_id"]}}</h1> --}}
                    <form  style="display:inline-block" action="" method="get">
                        <select id="category_id" name="category_id"  onchange="this.form.submit()">
                            @foreach ($categories as $category)
                                <option value="{{$category->id}}">{{$category->name}}</option> 
                            @endforeach
                        </select>
                    </form>
                    <a  style="display:inline-block" class="btn btn-primary" href="{{route('art.index')}}">rodyti viską</a>
        </div>
           </div>
           <div class="card">
               

               <div class="card-body">
         
                <table>
                    <tr>
                        <th style=" text-align:top;">
                            <span style="    float: left; margin: 10px 10px 0 0;">Pavadinimas</span> 
                            <div style="display: inline-block;">
                                <?php
                                $cat_id = "0";
        if(isset($_GET["category_id"])){
            $cat_id =$_GET["category_id"];
        }

                                ?>
                                <a style="display: block" href="{{route('art.index',['sort'=> 'up', "category_id"=> $cat_id])}}">▲</a>
                                <a style="display: block" href="{{route('art.index',['sort'=> 'down', "category_id"=> $cat_id])}}">▼</a>
                            </div>
                ­
                        </th>
                        <th>Aprašas</th>
                        <th>Kategorijos</th>
                        @if(Auth::user())
                        <th>Redaguoti</th>
                        <th>išjungti</th>
                        <th>Šalinti</th>
                        @endif
                    </tr>
                  
                
                @foreach ($art as $artUnit)
                <tr>
                    <td><h2>{{$artUnit->title}}</h2></td>
                    <td>{{$artUnit->description}}</td>
                    <td>{{  $artUnit->categoryNames()  }}</td>
                    @if(Auth::user())
                        <td><a class="btn btn-primary" href="{{route('art.edit',$artUnit)}}">redaguoti</a></td>
                        <td>
                            @if($artUnit->status == 1)
                            <form action="{{route('art.disable',$artUnit)}}" method="post">
                                @csrf
                                <input  class="btn btn-warning" type="submit" value="išjungti">
                            </form>
                            @else
                            <form action="{{route('art.enable',$artUnit)}}" method="post">
                                @csrf
                                <input  class="btn btn-success" type="submit" value="įjungti">
                            </form>
                            @endif
                        </td>
                        <td>
                            <form action="{{route('art.destroy',$artUnit)}}" method="post">
                                @csrf
                                <input  class="btn btn-danger" type="submit" value="trinti">
                            </form>
                        </td>
                        @endif
                  </tr>
                @endforeach
                
               </div>
           </div>
       </div>
   </div>
</div>
@endsection

<html>
    <body>
        <div>labas</div>
    </body>
</html>