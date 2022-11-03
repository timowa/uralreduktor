<?php

namespace App\Configurator;

use Illuminate\Foundation\Application;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Illuminate\Support\Stringable;
use Illuminate\View\Factory;
use function Termwind\render;

class ConfiguratorField
{
    protected string $label;

    protected string $field;

    protected array $values = [];

    protected array $attributes = [];

    protected static string $view = 'input';

    protected static string $type = 'radio';

    public function __construct(string $label,string $field, array $values){
        $this->setLabel($label);
        $this->setField($field);
        $this->setValues($values);
    }

    public static function make(...$arguments):static
    {
        return new static(...$arguments);
    }

    public function setLabel( string $label):static
    {
        $this->label = $label;

        return $this;
    }

    public function setField( string $field):static
    {
        $this->field = $field;
        return $this;
    }

    public function setValues( array $values):static
    {
        $this->values = $values;
        return $this;
    }

    public function setAttributes( array $attributes):static
    {
        $this->attributes = $attributes;
        return $this;
    }


    public function values():Collection
    {
        return collect($this->values);
    }

    public function attribute(string $name):string
    {
        return $this->attributes[$name]??'';
    }
    public function field():string
    {
        return $this->field;
    }
    public function type():string
    {
        return static::$type;
    }
    public function view():string
    {
        return static::$view;
    }

    public function name():string
    {
        return (string) $this->label;
    }

    public function id(string $value = null):string
    {
        return (string) str($this->field())
            ->prepend('conf_')
            ->when($value, fn(Stringable $str) => $str->append("_$value"));
    }

    public function render(): Factory|View|Application
    {
        return view('configurator.'.$this->view(),['field'=>$this]);
    }
}
