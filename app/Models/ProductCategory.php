<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Backpack\CRUD\app\Models\Traits\SpatieTranslatable\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use CrudTrait;


    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'product_categories';
    protected $dashboardTabs = ['name','type','icon'];
     public $timestamps = false;
    protected $guarded = ['id'];


    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public function identifiableAttribute()
    {
        // process stuff here
        return 'name';
    }
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function series(){
        return $this->hasMany(ProductSeries::class,'category_id');
    }
    public function attributes(){
        return $this->belongsToMany(ProductAttribute::class,'attribute_category','category_id','attribute_id');
    }
    public function products(){
        return $this->hasManyThrough(Product::class,ProductSeries::class,'category_id','series_id');
    }
    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
