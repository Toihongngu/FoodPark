<?php
// create slug unique
if (!function_exists('generateUniqueSlug')) {
    function generateUniqueSlug($model, $name)
    {
        $modelClass = "App\\Models\\$model";

        if(!class_exists($modelClass)){
            throw new \InvalidArgumentException("Model $model not found.");
        }

        $slug = \Str::slug($name);
        $count =2;
        while ($modelClass::where('slug',$slug)->exists()){
            $slug =\Str::slug($name).'-'.$count;
            $count++;
        }
        return $slug;
    }
}


if(!function_exists('currencyPosition')){
    function currencyPosition($price){
if(config('settings.site_currency_icon_position')=== 'left'){
    return config('settings.site_currency_icon').$price;
}else{
    return $price.config('settings.site_currency_icon');
}
    }
}



















