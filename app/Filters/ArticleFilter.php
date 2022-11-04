<?php

namespace App\Filters;

class ArticleFilter extends QueryFilter
{
    public function tag($slug = null){
        return $this->builder->when($slug, function($query) use($slug){
            $query->whereHas('tags', function ($q) use($slug){
                $q->where('slug',$slug);
            });
        });
    }
}
