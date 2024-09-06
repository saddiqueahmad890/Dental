<?php

namespace App\Http\Controllers;

use App\Models\UserLogs;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class CategoryController extends Controller
{

    public function index(Request $request)
    {



        $categories = $this->filter($request)->orderBy('id', 'desc')->paginate(10);
        return view('categories.index', compact('categories'));
    }


    private function filter(Request $request)
    {
        $query = Category::query();

        if ($request->has('title')) {
            $query->where('title', 'like', $request->input('title') . '%');
        }

        if ($request->has('description')) {
            $query->where('description', 'like', $request->input('description') . '%');
        }


        return $query;
    }


    public function create()
    {
        return view('categories.create');
    }



    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
        ]);

        $category = new Category();
        $category->title = $request->input('title');
        $category->description = $request->input('description');
        $category->created_by = Auth::id();
        $category->save();

        return redirect()->route('categories.edit', $category->id)
            ->with('success', 'Category created successfully.');
    }



    public function show(Category $category)
    {
        return view('categories.show', compact('category'));
    }


    public function edit(Category $category)

    {
        return view('categories.edit', compact('category'));
    }


    public function update(Request $request, Category $category)
    {
        $this->validation($request);

        $data = $request->all();
        $data['updated_by'] = auth()->id();


        $category->update($data);

        return redirect()->route('categories.edit', $category->id)
            ->with('success', 'Category updated successfully.');
    }


    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
    }

    private function validation(Request $request, $id = 0)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
    }
}
