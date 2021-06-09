<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use App\Models\User;
class Art extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title',
        'description',
        'status',
        'user_id',
    ];
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'art_categories');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function photos()
    {
        return $this->hasMany(Image::class, 'art_id', 'id');
    }
   




    public function categoryNames(){
        $arr = [];
        foreach ($this->categories->sortBy('name')  as $key => $category) {
            $arr[] = $category->name;
        } 
        return implode(", ",$arr);
    }
    public function categoryNamesArr(){
        $arr = [];
        foreach ($this->categories as $key => $category) {
            $arr[] = $category->name;
        } 
        return $arr;
    }
    public function categoryIdsArr(){
        $arr = [];
        foreach ($this->categories as $key => $category) {
            $arr[] = $category->id;
        } 
        return $arr;
    }

    public function photo()
    {
       $photoName = Image::where('art_id', $this->id)->first();
    //    dd($photoName );
    if($photoName){
        $photoName = $photoName->name;
        // dd(public_path("images/artGallery").'/'.$photoName);
        // $photoName ='<img src="'.public_path("images/artGallery").'/'.$photoName.'" alt="">';
    }
    
    return $photoName;
    }
  
}
