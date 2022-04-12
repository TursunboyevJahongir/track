<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function set($locale){
        app()->setLocale($locale);
        session()->put('locale',$locale);
        \Session::save();
        return back();
    }
}
