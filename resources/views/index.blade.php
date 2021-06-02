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
                    <a  style="display:inline-block" class="btn btn-primary" href="{{route('art.public')}}">rodyti viską</a>
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
                                <a style="display: block" href="{{route('art.public',['sort'=> 'up', "category_id"=> $cat_id])}}">▲</a>
                                <a style="display: block" href="{{route('art.public',['sort'=> 'down', "category_id"=> $cat_id])}}">▼</a>
                            </div>
                ­
                        </th>
                        <th>Aprašas</th>
                        <th>Kategorijos</th>
                    </tr>
                  
                
                @foreach ($art as $artUnit)
                <tr>
                    <td><h2>{{$artUnit->title}}</h2></td>
                    <td>{{$artUnit->description}}</td>
                    <td>{{  $artUnit->categoryNames()  }}</td>
                    
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