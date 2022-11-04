<?php

namespace App\Filters;

use App\Models\ProductAttribute;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class QueryFilter
{
    public $request;
    protected $builder;
    protected $delimiter = ',';

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function filters()
    {
        return $this->request->query();
    }

    public function apply(Builder $builder)
    {
        $this->builder = $builder;
        foreach ($this->filters() as $slug => $value) {

                if (method_exists($this, $slug)) {
                    call_user_func_array([$this, $slug], array_filter([$value]));
                }else{
                    $arrayForFilter = [
                        'slug'=>$slug,
                        'value'=>$value
                    ];
                    if (!is_null(ProductAttribute::where('slug',$slug)->first())){
                        call_user_func_array([$this, 'filterByAttribute'], array($arrayForFilter));
                    }
                }


        }

        return $this->builder;
    }

    protected function paramToArray($param)
    {
        return explode($this->delimiter, $param);
    }
}
