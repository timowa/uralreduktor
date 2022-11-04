<?php

namespace App\Http\Controllers;

use App\Filters\CatalogFilter;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductCategory;
use App\Models\ProductSeries;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class PageController extends Controller
{
    protected $filterOptions = [
        1=>[
            'id'=>8,
            'name'=>'',
            'min'=>0,
            'max'=>0,
            'type'=>'radio',
            'options'=>array(),
            'slug'=>''
        ],
        2=>[
            'id'=>2,
            'name'=>'',
            'min'=>0,
            'max'=>0,
            'type'=>'radio',
            'options'=>array(),
            'slug'=>''
        ],
        3=>[
            'id'=>3,
            'name'=>'',
            'min'=>0,
            'max'=>0,
            'type'=>'range',
            'slug'=>''
        ],
        4=>[
            'id'=>1,
            'name'=>'',
            'min'=>0,
            'max'=>0,
            'type'=>'range',
            'slug'=>''
        ]
    ];
    function createFilter($collection){
        $filter = $this->filterOptions;
        foreach ($filter as &$item){
            $item['name']=ProductAttribute::find($item['id'])->name;
            $item['slug']=ProductAttribute::find($item['id'])->slug;
            if ($item['type']=='radio'){
                $item['options']=ProductAttribute::find($item['id'])->strAttributes->pluck('value','id')->toArray();
            }else{
            $min = 10000;$max = 0;
            foreach ($collection->get() as $one){
                if(!$one->numAttributes()->where('attribute_id',$item['id'])->exists()) continue;
                $minAttr = $one->numAttributes()->where('attribute_id',$item['id'])->orderBy('value','asc')->first()->value;
                if($minAttr<$min)$min=$minAttr;
                $maxAttr = $one->numAttributes()->where('attribute_id',$item['id'])->orderBy('value','desc')->first()->value;
                if($maxAttr>$max)$max=$maxAttr;
            }
            $item['min'] = $min;
            $item['max'] = $max;
            }
        }
        return $filter;
    }
    public function catalog(CatalogFilter $filter){
        $search= '/catalog';
        $search1= '/catalog';
        $meta=collect(DB::table('meta_pages')->where('meta_url','LIKE',"%{$search}%")->orWhere('meta_url','LIKE',"%{$search1}%")->get()[0]);
        $series = ProductSeries::all();
        $products = Product::filter($filter);
        $pageFilter = $this->createFilter($products);
        $products= $products->paginate(12);
        return view('catalog',compact('meta','products','series','pageFilter'));
    }
    public function single($catSlug,$pSlug){
        $meta=collect(DB::table('meta_pages')->where('meta_url','LIKE',"%{$_SERVER['REQUEST_URI']}%")->orWhere('meta_url','LIKE',"%{$_SERVER['REQUEST_URI']}%")->get());
        $category = ProductCategory::where('slug',$catSlug)->first();
        $product = Product::where('slug',$pSlug)->first();
        $quest = collect()->paginate(3);
        abort_if(is_null($category) || is_null($product) || $product->category->slug != $catSlug,404);
        return view('single',compact('meta','product','quest','category'));
    }
    public function parser(){
        return view('parser');

    }
    //single

}
