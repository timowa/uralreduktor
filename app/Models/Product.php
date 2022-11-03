<?php

namespace App\Models;

use App\Filters\QueryFilter;
use App\hasAttributes;
use App\NotifyTrans;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Backpack\CRUD\app\Models\Traits\SpatieTranslatable\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class Product extends Model
{
    use CrudTrait;
    use HasFactory;
    use hasAttributes;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'products';
    public $dashboardTabs = [
        'Название'=>'name',
        'Серия'=>[
            'column'=>'series_id',
            'entity'=>'series',
            'type'=>'relationship'
        ]
    ];
    // protected $primaryKey = 'id';
     public $timestamps = false;
     protected $guarded = ['id'];
     protected $fillable = ['description','product_characteristics','dimensions','images','name','slug','series_id','other_attributes'];
    protected $noImage = 'uploads/products/no-image.png';
     // protected $hidden = [];
     protected $fakeColumns = ['other_attributes'];
    protected $casts = [
        'images'=>'array',
        'other_attributes'=>'array',
        'dimensions'=>'object',
    ];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    public function replicate(array $except = null) {

        return parent::replicate(['slug']);
    }

    public function productsFromSeries(){
        return $this->series->products->whereNotIn('id',$this->id);
    }
    public function firstImage(){
        if(isset($this->images[0]))
            return $this->images[0];
        else
            return  $this->noImage;
    }
    public function getSvg($path){
        echo file_get_contents(asset('storage/'.$path));
    }
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function series(){
        return $this->belongsTo(ProductSeries::class,'series_id');
    }
    public function category(){
        return $this->hasOneThrough(ProductCategory::class,ProductSeries::class,'id','id','series_id','category_id');
    }
    public function strAttributes(){
        return $this->morphedByMany(StringAttribute::class,'productable','attribute_value_product','product_id');
    }
    public function numAttributes(){
        return $this->morphedByMany(NumericalAttribute::class,'productable','attribute_value_product','product_id');
    }
    public function svgAttributes(){
        return $this->morphedByMany(SvgAttribute::class,'productable','attribute_value_product','product_id');
    }
    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */
    public function scopeFilter(Builder $builder, QueryFilter $filter){
        return $filter->apply($builder);
    }
    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */
//    public function getImagesAttribute($value){
//        if(!is_back_page() && is_null($value)) return [$this->noImage];
//    }
    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */


}
