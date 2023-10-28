<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories|max:255',
            'status' => 'required',
        ]);
        Category::create([
            'name' => $request->input('name'),
            'status' => $request->input('status'),
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully.');
    }
    public function edit($id)
    {
        $category = Category::findOrFail($id); // Retrieve the category by ID
        $categories = Category::all();
        return view('admin.categories.edit', compact('category','categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:255',
            'status' => 'required',
        ]);

        $category = Category::findOrFail($id);

        $category->name = $request->input('name');
        $category->status = $request->input('status');
        $category->save();
        return redirect()->route('admin.categories.index', ['id' => $category->id])
            ->with('success', 'category updated successfully.');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'category deleted successfully.');
    }
}

?>