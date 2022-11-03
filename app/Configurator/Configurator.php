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
        foreach ($product->getOrderedAttributesForConfigurator() as $key => $data){
            switch ($data['cft']){
                case 'radio':
                    $fields[] = RadioField::make($data['name'],'asd',values:$data['value']);
                    break;
                case 'radio_with_svg':
                    $fields[]= RadioWithSvgField::make($data['name'],'asd',values:$data['value']);
                    break;
                case 'select':
                    $field = SelectField::make($data['name'],'asd',values:$data['value']);
                    if(isset($data['default']))
                        $field = $field->setDefault($data['default']);
                    $fields[]=$field;
                    break;
            }
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
