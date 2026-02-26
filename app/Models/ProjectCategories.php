<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectCategories extends Model
{
    use HasFactory;

    protected $fillable= ['cat_name','parent_cat_id','cat_description'];


    public function parentCategory(){

        if($this->parent_cat_id){
            return self::find($this->parent_cat_id);
        }
        else{
            return false;
        }
    }
}
