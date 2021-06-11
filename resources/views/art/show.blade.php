@extends('layouts.app')

@section('content')
<div class="container">
   <div class="row justify-content-center">
       <div class="col-md-8">
           <div class="card">
               <div class="card-header"><h2>{{$art->title}}</h2></div>

               <div class="card-body">
              
 
                {!!$art->photo()!!}
                <p>{{$art->description}}</p>
      


               </div>
           </div>
       </div>
   </div>
</div>
@endsection

