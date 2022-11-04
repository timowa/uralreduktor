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

    public string $TooltipName;

    public string $activateNextStepName;

    protected array $clickData = [];

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

    public function setIteration(int $iteration):static
    {
        $this->TooltipName = 'showTooltip'.$iteration;
        $this->activateNextStepName = 'activateNextStep'.$iteration;
        $this->listAttributeName = 'listAttributeName'.$iteration;
        $this->listAttributeValue = 'listAttributeValue'.$iteration;
        return $this;
    }

    public function setClickData(array $values):static
    {
        $clickData = [];
        foreach ($values as $value){
            if(is_array($value)){
                $clickData[$value['value']] = [
                    'setup'=>$value['value'],
                    $this->activateNextStepName()=>true,
                    $this->tooltipName()=>false,
                ];
            }else{
                $clickData[$value] = [
                    'setup'=>$value,
                    $this->activateNextStepName()=>true,
                    $this->tooltipName()=>false,
                ];
            }
        }
        $this->clickData = $clickData;
        return $this;
    }


    public function tooltipName():string
    {
        return $this->TooltipName;
    }

    public function activateNextStepName():string
    {
        return $this->activateNextStepName;
    }



    public function data(int $id):string
    {
        $data = $this->clickData[$id];
        $str = '';
        foreach($data as $key=>$value){
            if(!$value) $value = 'false';
            else $value = 'true';
            $str.=$key.' = '.$value.';';
        }
        $str=substr($str,0,-1);
//        $data = str_replace(',',';',str_replace(':',' = ',str_replace('"','',json_encode($data, JSON_NUMERIC_CHECK))));

        return $str;
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
