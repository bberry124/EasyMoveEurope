<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Models\BlogPost;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
class HomeController extends Controller
{
    public function languageChange($lang)
    {
        $locale = $lang;

        if (!in_array($locale, ["de", "it", "fr", "es", "pt", "pl", "ro", 'en'])) {
            return redirect()->back();
        }

        request()->session()->put('locale', $locale);
        
        return redirect()->back();
    }
    
    public function single_blog($slug)
    {
        $blog = BlogPost::where('slug', $slug)->first();
        if (!$blog) {
            return response()->json(['message' => 'Blog not found'], 404);
        }
        $categories = Category::where('status', 1)->get();
        $categoryId = $blog->cat_id;
        $categoryName = Category::where('id', $categoryId)->value('name');
        $nextBlog = BlogPost::where('id', '>', $blog->id)->orderBy('id', 'asc')->first();
        $previousBlog = BlogPost::where('id', '<', $blog->id)->orderBy('id', 'desc')->first();
        return view('single_blog', compact('blog', 'nextBlog', 'previousBlog','categories','categoryName'));
    }
}
