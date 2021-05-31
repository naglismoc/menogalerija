<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function categoryNames(){
        $arr = [];
        foreach ($this->categories as $key => $category) {
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

  
}
