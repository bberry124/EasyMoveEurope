<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlogPost;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;


class BlogPostController extends Controller
{
    public function index()
    {
        $posts = BlogPost::latest()->paginate(1000);
        return view('admin.blogs.index', compact('posts'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.blogs.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
            'cat_id' => 'required',
            'header_description' => 'required',
            'header_tags' => 'required',
        ]);
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('blogs', 'public');
            $validatedData['image'] = $imagePath;
        }
        try {
            $slug = Str::slug($request->title);
            $slugCount = BlogPost::where('slug', $slug)->count();
            if ($slugCount > 0) {
                $slug .= '-' . ($slugCount + 1);
            }
            BlogPost::create([
                'title' => $request->input('title'),
                'slug' => $slug,
                'description' => $request->input('description'),
                'image' => $imagePath,
                'cat_id' => $request->input('cat_id'),
                'status' => $request->input('status'),
                'header_description' => $request->input('header_description'),
                'header_tags' => $request->input('header_tags'),
            ]);
            return redirect()->route('admin.blogs.index')->with('success', 'Blog post created successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while saving the blog.');
        }
    }

    public function edit($slug)
    {
        $blog = BlogPost::findOrFail($slug); // Retrieve the blog post by ID
        $categories = Category::all();
        return view('admin.blogs.edit', compact('blog','categories'));
    }

    public function update(Request $request, $slug)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'status' => 'required',
            'cat_id' => 'required',
            'header_description' => 'required',
            'header_tags' => 'required',
        ]);

        $blog = BlogPost::findOrFail($slug);

        $blog->title = $request->input('title');
        $blog->description = $request->input('description');
        $blog->status = $request->input('status');
        $blog->cat_id = $request->input('cat_id');
        $blog->header_description = $request->input('header_description');
        $blog->header_tags = $request->input('header_tags');

        if ($request->hasFile('image')) {
            // Delete the old image if exists
            if ($blog->image) {
                Storage::delete($blog->image);
            }
    
            // Store the new image
            $imagePath = $request->file('image')->store('blogs', 'public');
            $blog->image = $imagePath;
        }

        $blog->save();
        return redirect()->route('admin.blogs.index', ['slug' => $blog->slug])
            ->with('success', 'Blog post updated successfully.');
    }

    public function destroy($id)
    {
        $blog = BlogPost::findOrFail($id);
        $blog->delete();
        return redirect()->route('admin.blogs.index')->with('success', 'Blog post deleted successfully.');
    }
}
