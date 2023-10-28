<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function setLanguage(Request $request, $locale)
    {
        $request->session()->put('locale', $locale);
        return redirect()->back();
    }
}
