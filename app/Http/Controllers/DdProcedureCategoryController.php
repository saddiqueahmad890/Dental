<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DdProcedureCategory;
use Illuminate\Support\Facades\Auth;
use App\Models\UserLogs;

class DdProcedureCategoryController extends Controller
{
    public function index(Request $request)
    {
        $ddProcedureCategories = $this->filter($request)->orderBy('id', 'desc')->paginate(10);
        return view('dd-procedure-category.index', compact('ddProcedureCategories'));
    }
    private function filter(Request $request)
    {
        $query = DdProcedureCategory::query();

        if ($request->has('title') && $request->title) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        return $query;
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('dd-procedure-category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validation($request);


        $ProcedureCategory = $request->only(['title', 'description']);
        $ProcedureCategory['created_by'] = Auth::id();

        $procedurecatgories = new DdProcedureCategory($ProcedureCategory);
        $procedurecatgories->save();
        $ddProcedureCategory = $procedurecatgories->id;
        return   redirect()->route('dd-procedure-categories.edit', $ddProcedureCategory)->with('success', trans(' Prcedure category created successfully'));
    }
    public function show(DdProcedureCategory  $ddProcedureCategory)
    {
        return view('dd-procedure-category.show', compact('ddProcedureCategory'));
    }



    public function edit(DdProcedureCategory  $ddProcedureCategory)
    {
        return view('dd-procedure-category.edit', compact('ddProcedureCategory'));
    }


    public function update(Request $request, DdProcedureCategory  $ddProcedureCategory)

    {
        $this->validation($request);
        $data = $request->all();
        $data['updated_by'] = Auth::id();
        $ddProcedureCategory->update($data);

        return   redirect()->route('dd-procedure-categories.edit', $ddProcedureCategory)->with('success', trans(' Prcedure category updated successfully'));
    }



    public function destroy(DdProcedureCategory  $ddProcedureCategory)
    {
        $ddProcedureCategory->delete();
        return redirect()->route('dd-procedure-categories.index')->with('success', trans('procedure category Deleted Successfully'));
    }



    private function validation(Request $request)
    {
        $request->validate([
            'title' => ['required'],
            // Adjust max length as needed

        ]);
    }
}
