<?php

namespace App\Models;

use App\Filters\QueryFilter;
use App\hasAttributes;
use App\NotifyTrans;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Backpack\CRUD\app\Models\Traits\SpatieTranslatable\HasTranslations;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ProductSeries extends Model
{
    use CrudTrait;
    use hasAttributes;


    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'product_series';
    // protected $primaryKey = 'id';
     public $timestamps = false;
    protected $guarded = ['id'];

    protected $translatable =['name'];
    protected $fillable = ['name','category_id','slug','attributes_order_card','attributes_order_configurator'];
    protected $casts = [
        'attributes_order_card'=>'array',
        'attributes_order_configurator'=>'array'
    ];

    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function products(){
        return $this->hasMany(Product::class,'series_id');
    }
    public function category(){
        return $this->belongsTo(ProductCategory::class,'category_id');
    }
    public function strAttributes(){
        return $this->morphedByMany(StringAttribute::class,'seriesable','attribute_value_series','series_id');
    }
    public function numAttributes(){
        return $this->morphedByMany(NumericalAttribute::class,'seriesable','attribute_value_series','series_id');
    }
    public function svgAttributes(){
        return $this->morphedByMany(SvgAttribute::class,'seriesable','attribute_value_series','series_id');
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

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */

    public function setAttributesAttribute($value){
        $newValue = [];
        foreach ($value as $key => $item){
            if(!is_null($item))$newValue[$key]=$item;
        }
        $this->attributes['_attributes']=json_encode($newValue);
    }
}
