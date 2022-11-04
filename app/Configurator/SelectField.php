<?php

namespace App\Configurator;

class SelectField extends ConfiguratorField
{
    protected static string $view = 'select';

    protected  string $default;

    public function __construct(string $label,int $id, array $values){
        $this->setLabel($label);
        $this->setId($id);
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
