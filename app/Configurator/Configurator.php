<?php

namespace App\Configurator;

use App\Models\NumericalAttribute;
use App\Models\Product;

class Configurator
{
    protected $product;

    protected $fields = [];

    public function __construct(Product $product){
        $this->product = $product;
        $fields = [];
        $count = 0;
        foreach ($product->getOrderedAttributesForConfigurator() as $key => $data){
            switch ($data['cft']){
                case 'radio':
                    $field = RadioField::make($data['name'],$key,values:$data['value'])->setIteration($count)->setClickData($data['value']);
                    break;
                case 'radio_with_svg':
                    $field= RadioWithSvgField::make($data['name'],$key,values:$data['value'])->setIteration($count)->setClickData($data['value']);
                    break;
                case 'select':
                    $field = SelectField::make($data['name'],$key,values:$data['value'])->setIteration($count);
                    if(isset($data['default']))
                        $field = $field->setDefault($data['default']);
                    break;
            }
            $fields[]=$field;
            $count++;

        }
        $this->setFields($fields);
    }
    public function setFields(array $fields){
        $this->fields = $fields;
        return $this;
    }

    public function fields():array
    {
        return $this->fields;
    }
    public function getData(){

    }
}
