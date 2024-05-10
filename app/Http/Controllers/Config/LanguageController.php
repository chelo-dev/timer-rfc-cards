<?php

namespace App\Http\Controllers\Config;

use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use App;

class LanguageController extends Controller
{
    public function changeLanguage($locale)
    {
        if (in_array($locale, ['en', 'es'])) {
            Session::put('locale', $locale);
            Session::save();
        }
        return redirect()->back();
    }
}
