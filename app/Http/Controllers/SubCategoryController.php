<?php

namespace App\Http\Controllers;
use App\Models\UserLogs;
use App\Models\SubCategory;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubCategoryController extends Controller
{
    public function index(Request $request,Category $category)
    {

        $subCategories = $this->filter($request)->orderBy('id', 'desc')->paginate(10);
        return view('subcategories.index', compact('subCategories'));

    }
    private function filter(Request $request)
    {
        $query = SubCategory::query();

        if ($request->has('title')) {
            $query->where('title', 'like', $request->input('title') . '%');
        }

        if ($request->has('description')) {
            $query->where('description', 'like', $request->input('description') . '%');
        }


        return $query;
    }


    public function create(Category $category)
    {
        $categories = Category::all();
        return view('subcategories.create', compact('categories'));
    }

    public function store(Request $request, Category $category)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'category_id' => 'required',
        ]);

        $treatmentplan = new SubCategory();
        $treatmentplan->title = $request->input('title');
        $treatmentplan->description = $request->input('description');
        $treatmentplan->created_by = Auth::id();
        $treatmentplan->category_id = $request->input('category_id');
        $treatmentplan->save();

        return redirect()->route('subcategories.edit', ['subcategory' => $treatmentplan->id])
                         ->with('success', 'SubCategory created successfully.');
    }


    public function show(Category $category, SubCategory $subcategory)
    {
        return view('subcategories.show', compact('category', 'subcategory'));
    }

    public function edit(SubCategory $subcategory)
    {

        $categories = Category::all();

        return view('subcategories.edit', compact('subcategory', 'categories'));
    }

    public function update(Request $request, SubCategory $subcategory)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'category_id' => 'required',
            'status' => 'required|in:1,0',
        ]);

        // Update the existing $subcategory instance with validated data
        $subcategory->title = $validatedData['title'];
        $subcategory->description = $request->input('description'); // If description is optional
        $subcategory->category_id = $validatedData['category_id'];
        $subcategory->status = $validatedData['status'];
        $subcategory->updated_by = auth()->id();

        $subcategory->save(); // Save the updated data


        return redirect()->route('subcategories.edit', ['subcategory' => $subcategory->id])
            ->with('success', 'SubCategory updated successfully.');
    }



    public function destroy(SubCategory $subcategory)
    {
        $subcategory->delete();
        return redirect()->route('subcategories.index')->with('success', 'Subcategory deleted successfully.');
    }



}
