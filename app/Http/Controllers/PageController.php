<?php

namespace App\Http\Controllers;

use App\App;
use App\Configurator\Configurator;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductSeries;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class PageController extends Controller
{
    public function catalog(){
        $search= '/catalog';
        $search1= '/catalog';
        $meta=collect(DB::table('meta_pages')->where('meta_url','LIKE',"%{$search}%")->orWhere('meta_url','LIKE',"%{$search1}%")->get()[0]);
        $series = ProductSeries::all();
        $products = Product::paginate(12);
        return view('catalog',compact('meta','products','series'));
    }
    public function single($catSlug,$pSlug){
        $meta=collect(DB::table('meta_pages')->where('meta_url','LIKE',"%{$_SERVER['REQUEST_URI']}%")->orWhere('meta_url','LIKE',"%{$_SERVER['REQUEST_URI']}%")->get());
        $category = ProductCategory::where('slug',$catSlug)->first();
        $product = Product::where('slug',$pSlug)->first();
        abort_if(is_null($category) || is_null($product) || $product->category->slug != $catSlug,404);
        $quest = collect()->paginate(3);
        $configurator = new Configurator($product);
        return view('single',compact('meta','product','quest','category','configurator'));

    }
    //single

}
