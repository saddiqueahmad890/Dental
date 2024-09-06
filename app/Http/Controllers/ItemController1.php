<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubCategory;

class ItemController1 extends Controller
{
    public function getsubcategories1(Request $request)
    {
        $categoryId = $request->get('category_id');
        // Corrected the query to fetch subcategories
        $subcategories = SubCategory::where('category_id', $categoryId)->get(['id', 'title']);

        
        return response()->json($subcategories);
    }
}

