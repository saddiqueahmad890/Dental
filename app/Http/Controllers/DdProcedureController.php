<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\DdProcedure;
use App\Models\DdProcedureCategory;
use App\Models\UserLogs;
class DdProcedureController extends Controller

{
    public function index(Request $request)
    {
        $i=1;
        $ddProcedures = $this->filter($request)->orderBy('created_at', 'desc')->get();
        return view('dd-procedure.index', compact('ddProcedures'));
    }

    private function filter(Request $request)
    {
        $query = DdProcedure::query();

        if ($request->has('sr_no') && $request->sr_no) {
            $query->where('sr_no', 'like', '%' . $request->sr_no . '%');
        }

        if ($request->has('procedure_code') && $request->procedure_code) {
            $query->where('procedure_code', 'like', '%' . $request->procedure_code . '%');
        }

        if ($request->has('title') && $request->title) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        return $query;
    }




    public function create()
    {
        $ddProcedureCategories = DdProcedureCategory::get();

        return view('dd-procedure.create', ['ddProcedures' => $ddProcedureCategories]);
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

        $procedureData = $request->only(['title', 'description', 'sr_no', 'procedure_code', 'dd_procedure_id', 'price']);
        $procedureData['created_by'] = Auth::id();

        $procedure = new DdProcedure($procedureData);
        $procedure->save();
        $ddProcedure=$procedure->id;

        return redirect()->route('dd-procedures.edit',$ddProcedure)->with('success', trans(' Prcedure  created successfully'));
    }
    public function show(DdProcedure  $ddProcedure)
    {
        return view('dd-procedure.show', compact('ddProcedure'));
    }



    public function edit(DdProcedure  $ddProcedure)
    {
        $ddProcedureCategories = DdProcedureCategory::get();
        return view('dd-procedure.edit', compact('ddProcedure', 'ddProcedureCategories'));
    }


    public function update(Request $request, DdProcedure  $ddProcedure)

    {
        $this->validation($request);
        $data = $request->all();
        $data['updated_by'] = Auth::id();
        $ddProcedure->update($data);

        return redirect()->route('dd-procedures.edit', $ddProcedure)->with('success', trans(' Procedure  updated successfully'));
    }



    public function destroy(DdProcedure  $ddProcedure)
    {
        $ddProcedure->delete();
        return redirect()->route('dd-procedures.index')->with('success', trans('Procedure category Deleted Successfully'));
    }
    private function validation(Request $request)
    {
        $request->validate([
            'title' => ['required'],
            'dd_procedure_id' => ['required', 'integer'],
            'sr_no' => ['required', 'integer'],
            'procedure_code' => ['required', 'string', 'alpha'], // Ensures only alphabetic characters
            'price' => ['required', 'integer'],
        ]);

    }
}
