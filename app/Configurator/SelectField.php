<?php

namespace App\Configurator;

class SelectField extends ConfiguratorField
{
    protected static string $view = 'select';

    protected  string $default;

    public function __construct(string $label,string $field, array $values){
        $this->setLabel($label);
        $this->setField($field);
        $this->setValues($values);
    }

    public function default(){
        return $this->default;
    }

    public function setDefault(string $default){
        $this->default = $default;
        return $this;
    }

}
