<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ManfCategoryMaster extends Model
{
        use SoftDeletes;

  protected $table = "manf_category_master";
  protected $primaryKey = 'id';
    protected $softDelete = true;
  


 //public  function subcategory(){

   // return $this->hasMany('App\Model\ManfCategoryMaster', 'parent_id');


    //$category = ManfCategoryMaster::with('')->get(); 

   // $category = ManfCategoryMaster::with('parent_id')->get();


//    }

    // public function categories()
    // {
    //     return $this->hasMany('App\Model\ManfCategoryMaster');
    // }
    // public function childrenCategories()
    // {
    //     return $this->hasMany('App\Model\ManfCategoryMaster', 'parent_id')->with('categories');
    // }


   public function parent()
    {
        return $this->belongsTo('App\Model\ManfCategoryMaster', 'parent_id');
    }

    public function child()
    {
        return $this->hasMany('App\Model\ManfCategoryMaster', 'parent_id');
    }

    public function children()
    {
       return $this->child()->with('children');
    }


}
