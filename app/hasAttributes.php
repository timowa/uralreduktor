<?php

namespace App;

use App\Models\NumericalAttribute;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\StringAttribute;
use App\Models\SvgAttribute;

trait hasAttributes
{
    public static function bootHasAttributes()
    {
        static::deleting(function($model){
           $model->removeAllParams();
        });
    }

    public $attribute_relations = [
        'string'=>[
            'model'=>StringAttribute::class,
            'relation_name'=>'strAttributes'
        ],
        'num'=>[
            'model'=>NumericalAttribute::class,
            'relation_name'=>'numAttributes',
        ],
        'svg'=>[
            'model'=>SvgAttribute::class,
            'relation_name'=>'svgAttributes'
        ]
    ];

    public function attributes(){
        $res =[];
        $allAttributes = ProductAttribute::get();
        foreach ($allAttributes as $attribute){
            $values = [];
            $default = '';
            foreach ($this->attribute_relations as $attr_key => $data){
                $curAttributes =$this->{$data['relation_name']}()->where('attribute_id',$attribute->id)->get();
                if($curAttributes->isNotEmpty()){
                    foreach ($curAttributes as $curAttribute){
                        if(!is_null($curAttribute->icon)){
                            $values[] = [
                                'value'=>$curAttribute->value,
                                'icon'=>$curAttribute->icon
                            ];
                        }else{
                            $values[]=$curAttribute->value;
                        }
                        if($attribute->has_default_value && $this::class == Product::class && isset($this->other_attributes["default_$attribute->id"])){
                            $default=$curAttribute->find($this->other_attributes["default_$attribute->id"])->value;
                        }
                    }
                }
            }
            if(!empty($values)){
                $res[$attribute->id]=[
                    'name'=>$attribute->name,
                    'value'=>count($values)>1?$values:$values[0],
                    'cft'=>$attribute->configurator_field_type
            ];
                if(!empty($default)){
                    $res[$attribute->id]['default']=$default;
                }
            }

        }
        return $res;
    }
    public function showOperationAttributes(){
        $html = '<table><thead><tr><th>Атрибут</th><th>Значение</th></tr></thead><tbody>';
        foreach($this->attributes() as $name => $value){
            $html.="<tr><td>
                {$name}
            </td>
            <td >".
                implode('; ',$value)
                ."</td></tr>";
        }
        $html .='</tbody></table>';
        echo $html;

    }

    public function setParam($attribute_model,$relation_name,$value,$pivot = []){
        $related_attribute = $attribute_model::find($value);
        if(is_null($related_attribute)){
            $related_attribute = $attribute_model::create(['value'=>$value]);
        }
        $this->{$relation_name}()->attach($related_attribute,$pivot);
    }
    public function removeParams($relation_name){
        $this->{$relation_name}()->detach();
    }
    public function removeAllParams(){
        foreach ($this->attribute_relations as $relation_key => $data) {
            $this->removeParams($data['relation_name']);
        }
    }

    public function crudAttachAttributes($req){
        foreach ($this->attribute_relations as $relation_key => $data){
            $curAttributes = collect($req)->filter(function($value,$key) use($relation_key){
                return str_contains($key,$relation_key);
            });
            foreach ($curAttributes as $attribute_key => $attribute_values){
                $attribute_id = (int)str_replace("{$relation_key}_",'',$attribute_key);
                if(is_null($attribute_values)) continue;
                if(is_string($attribute_values)){
                    $this->setParam(new $data['model'](), $data['relation_name'],$attribute_values,['attribute_id'=>$attribute_id]);
                }elseif (is_array($attribute_values) || is_object($attribute_values)){
                    foreach ($attribute_values as $value){
                        $this->setParam(new $data['model'](), $data['relation_name'],$value,['attribute_id'=>$attribute_id]);
                    }
                }

            }
        }
    }
}
