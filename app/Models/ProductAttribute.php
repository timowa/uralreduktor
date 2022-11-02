<?php

namespace App\Models;

use App\hasAttributes;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Backpack\CRUD\app\Models\Traits\SpatieTranslatable\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class ProductAttribute extends Model
{
    use CrudTrait;
    use hasAttributes;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'product_attributes';
    // protected $primaryKey = 'id';
     public $timestamps = false;
    protected $guarded = ['id'];

    // protected $hidden = [];
    // protected $dates = [];
//    protected $casts = [
//        'values'=>'array'
//    ];
    protected $with = ['strAttributes','numAttributes','svgAttributes'];


    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public static function boot() {
        parent::boot();
        static::created(function () {
            $srtAttributes = StringAttribute::doesntHave('attribute')->get();
            $strArray = [];
            if($srtAttributes->isNotEmpty()){
                foreach ($srtAttributes as $attribute){
                    $strArray[] = $attribute->id;
                    $attribute->delete();
                }
            }
            $numAttributes = NumericalAttribute::doesntHave('attribute')->get();
            $numArray = [];
            if($numAttributes->isNotEmpty()){
                foreach ($numAttributes as $attribute){
                    $numArray[] = $attribute->id;
                    $attribute->delete();
                }
            }
            $svgAttributes = SvgAttribute::doesntHave('attribute')->get();
            $svgArray = [];
            if($svgAttributes->isNotEmpty()){
                foreach ($svgAttributes as $attribute){
                    $svgArray[] = $attribute->id;
                    $attribute->delete();
                }
            }
            Log::info('Атрибут создан, строковые сироты были удалены:'.Arr::join($strArray,', ').'. Числовые сироты были удалены: '.Arr::join($numArray,', ').'. Svg сироты были удалены: '.Arr::join($svgArray,', '));
        });
    }
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function categories(){
        return $this->belongsToMany(ProductAttribute::class,'attribute_category','attribute_id','category_id');
    }
    public function strAttributes(){
        return $this->morphedByMany(StringAttribute::class,'attributable','attributable','attribute_id');
    }
    public function numAttributes(){
        return $this->morphedByMany(NumericalAttribute::class,'attributable','attributable','attribute_id');
    }
    public function svgAttributes(){
        return $this->morphedByMany(SvgAttribute::class,'attributable','attributable','attribute_id');
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
