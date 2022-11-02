<?php

use Illuminate\Support\Str;

if(!function_exists('is_back_page')){
    function is_back_page(){
        return Str::contains(request()->url(),backpack_middleware());
    }
}
