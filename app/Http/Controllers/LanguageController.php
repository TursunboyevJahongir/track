<?php

namespace App\Http\Controllers;

use App\Enums\AvailableLocalesEnum;

class LanguageController extends Controller
{
    public function set($locale){
        if (in_array($locale,AvailableLocalesEnum::toArray())){
            app()->setLocale($locale);
            session()->put('locale',$locale);
            \Session::save();
        }
        return back();
    }
}
