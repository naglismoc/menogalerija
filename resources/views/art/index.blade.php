@extends('layouts.app')

@section('content')
<div class="container">
   <div class="row justify-content-center">
       <div class="col-md-12">
           <div class="card">
            <div class="card-header">PAVADINIMAS</div>
            <div class="col-md-12">

                <?php
               
                if(isset($_GET["category_id"])){
                    $cat_id =$_GET["category_id"];
                }else{
                        $cat_id = "0";
                    }
                if(isset($_GET["user_id"])){
                    $user_id =$_GET["user_id"];
                }else{
                    $user_id = "0";
                }
                if(isset($_GET["sort"])){
                    $sort =$_GET["sort"];
                }else{
                    $sort = "down";
                }
                ?>


                    <form  style="display:inline-block" action="" method="get">
                        <input type="hidden" name="user_id" value ={{$user_id}}>
                        <input type="hidden" name="sort" value ={{$sort}}>

                        @if(isset($single))
                        <input type="hidden" name="single" value="">
                        @endif
                        <select id="category_id" name="category_id"  onchange="this.form.submit()">
                            <option value="0">pasirinkite kategoriją:</option> 
                            @foreach ($categories as $category)
                                <option value="{{$category->id}}">{{$category->name}}</option> 
                            @endforeach
                        </select>
                    </form>
                    <form  style="display:inline-block" action="" method="get">
                        
                        <input type="hidden" name="category_id" value ={{$cat_id}}>
                        <input type="hidden" name="sort" value ={{$sort}}>
                        @if(isset($single))
                        <input type="hidden" name="single" value="">
                        @endif
                        @if(!isset($single))
                        <select id="category_id" name="user_id"  onchange="this.form.submit()">
                            <option value="0">pasirinkite autorių:</option> 
                            @foreach ($users as $user)
                                <option value="{{$user->id}}">{{$user->name}} {{$user->surname}}</option> 
                            @endforeach
                        </select>
                        @endif
                    </form>
                    @if(isset($single))
                    <a  style="display:inline-block" class="btn btn-primary" href="{{route('art.singleUser')}}">rodyti viską</a>

                    @else
                    <a  style="display:inline-block" class="btn btn-primary" href="{{route('art.index')}}">rodyti viską</a>
                    @endif
        </div>
           </div>
           <div class="card">
               

               <div class="card-body">
         
                <table>
                    <tr>
                       
                        <th style=" text-align:top;">
                            <span style="    float: left; margin: 10px 10px 0 0;">Pavadinimas</span> 
                            <div style="display: inline-block;">
           
                                @if(isset($single))

                                <a style="display: block" href="{{route('art.singleUser',['sort'=> 'up', "category_id"=> $cat_id])}}">▲</a>
                                <a style="display: block" href="{{route('art.singleUser',['sort'=> 'down', "category_id"=> $cat_id])}}">▼</a>
                                @else
                                    <a style="display: block" href="{{route('art.index',['sort'=> 'up', "category_id"=> $cat_id, "user_id"=> $user_id])}}">▲</a>
                                    <a style="display: block" href="{{route('art.index',['sort'=> 'down', "category_id"=> $cat_id, "user_id"=> $user_id])}}">▼</a>
                                @endif
                            </div>
                ­
                        </th>
                        <th>Nuotrauka</th>
                     
                        <th>Aprašas</th>
                        <th>Kategorijos</th>
                        <th>Apsilankyti</th>
                        @if(Auth::user())
                        <th>Redaguoti</th>
                        <th>išjungti</th>
                        <th>Šalinti</th>
                        @endif
                    </tr>
                  
                
            @foreach ($art as $artUnit)
         
            {{-- <img src="{{ asset('/images/artGallery/'.$artUnit->photo()) }}" alt=""> --}}
               {{-- {{ dd($artUnit->user)}} --}}
               @if(Auth::user())
                    @if($artUnit->status == 0 && $artUnit->user->id != Auth::user()->id)
                        @if(!Auth::user()->isAdministrator())
                            @continue
                        @endif
                    @endif
                @endif
                    <tr>
                      
                        <td><h2>{{$artUnit->title}}</h2></td>
                        <td>{!!$artUnit->photo()!!}</td>
                        <td>{{$artUnit->description}}</td>
                        <td>{{  $artUnit->categoryNames()  }}</td>
                        
                        <td><a class="btn btn-primary" href="{{route('art.show',$artUnit)}}">Užeiti</a></td>
                        @if(Auth::user())
                            @if($artUnit->user->id == Auth::user()->id)
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
                                        <input  class="btn btn-danger" type="submit" value="Trinti">
                                    </form>
                                </td>
                            @else
                            @if(Auth::user()->isAdministrator())
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
                                @if(Auth::user()->isSuperAdmin())
                                <td>
                                    <input type="button" class="btn btn-danger" value="Trinti"></input>
                                </td> 
                                @else
                                <td>
                                    <input type="button" class="btn btn-danger" disabled value="Trinti"></input>
                                </td> 
                                @endif
                            @else
                            
                                <td>
                                    <input type="button" class="btn btn-primary" disabled value="Redaguoti"></input>
                                </td> 
                                <td>
                                    <input type="button" class="btn btn-warning" disabled value="Išjungti"></input>
                                </td> 
                                <td>
                                    <input type="button" class="btn btn-danger" disabled value="Trinti"></input>
                                </td>
                            
                                @endif
                            @endif
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