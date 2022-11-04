<?php

namespace App\Filters;

use App\Models\ProductAttribute;

class CatalogFilter extends QueryFilter
{
    public function filterByAttribute($value = null){
        $slug = $value['slug'];
        $value = $value['value'];
        $attribute=ProductAttribute::where('slug',$slug)->first();
        if ($attribute->attribute_type == 'num' || $attribute->field_type == 'select2_multiple'){
            return $this->builder->when($value, function($query) use($value,$slug ,$attribute){
                $value = urldecode($value);
                $query->whereHas('numAttributes', function($q) use($value,$slug ,$attribute){

                    $value = explode(';',$value);

                    $q->where('attribute_id',$attribute->id)->whereBetween('value',[(int)$value[0],(int)$value[1]]);
                });

            });
        }else{
            $return = '';

            switch ($attribute->attribute_type){
                case('num'):
                    $return = $this->builder->when($value, function($query) use($value,$slug,$attribute){
                        $value = urldecode($value);
                        $query->whereHas('numAttributes', function($q) use($value,$slug ,$attribute){
                            $q->where('attribute_id',$attribute->id)->where('value',$value);
                        });
                    });

                    break;
                case('string') :

                    $return = $this->builder->when($value, function($query) use($value,$slug,$attribute){
                        $value = urldecode($value);
                        $query->whereHas('strAttributes', function($q) use($value,$slug ,$attribute){
                            $q->where('attribute_id',$attribute->id)->where('value',$value);
                        });
                    });

                    break;
                case('svg') :
                    $return = $this->builder->when($value, function($query) use($value,$slug,$attribute){
                        $value = urldecode($value);
                        $query->whereHas('svgAttributes', function($q) use($value,$slug ,$attribute){
                            $q->where('attribute_id',$attribute->id)->where('value',$value);
                        });
                    });
                    break;
             }
             return $return;
        }

    }
}
