<?php

namespace App\Helpers;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class TranslatableJson implements CastsAttributes
{
    public function get($model, $key, $value, $attributes)
    {
        return $value ? self::translatable($value, config('app.locale')) : null;
    }

    public function set($model, string $key, $value, array $attributes)
    {
        if(array_key_exists($key,$attributes) && $attributes[$key] != null){
            $value = $this->changeValue($key,$attributes,$value);
            return json_encode($value);
        }

        return json_encode($value);
    }

    public static function translatable($attribute, $key = null)
    {
        $arr = json_decode($attribute, true);
        return $arr[$key] ?? $arr[config('app.locale')] ?? "";
    }

    public function changeValue($key,$attributes,$value){
        $decodedText = html_entity_decode($attributes[$key]);
        $arrayTexts = json_decode($decodedText, true);
        $value = [app()->getLocale()=>$value];
        if ($arrayTexts != null)
            foreach($arrayTexts as $k => $v){
                if(!array_key_exists($k,$value))
                    $value[$k] = $v;
            }

        return $value;
    }
}
