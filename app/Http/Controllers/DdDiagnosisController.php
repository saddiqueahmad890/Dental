<?php

namespace App\Http\Controllers;

use App\Models\DdDiagnosis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Exports\GenericExport;
use Maatwebsite\Excel\Facades\Excel;

class DdDiagnosisController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('export') && $request->export) {
            return $this->doExport($request);
        }

        $ddDiagnoses = DdDiagnosis::query();

        if ($request->has('name') && !empty($request->name)) {
            $ddDiagnoses->where('name', 'like', '%' . $request->name . '%');
        }

        $ddDiagnoses = $ddDiagnoses->orderBy('id', 'desc')->paginate(10);

        return view('dd-diagnoses.index', compact('ddDiagnoses'));
    }
    private function doExport(Request $request)
    {



        $ddDiagnoses = DdDiagnosis::get();

        // Prepare data for export
        $data = $ddDiagnoses->map(function ($diagnosis) {
            return [
                $diagnosis->id,
                $diagnosis->name,
                $diagnosis->created_at,
                $diagnosis->updated_at,
            ];
        })->toArray();

        // Define headers for the export
        $headers = ['ID', 'Name', 'Created At', 'Updated At'];

        return Excel::download(new GenericExport($data, $headers), 'DdDiagnoses.xlsx');
    }


    public function create()
    {
        return view('dd-diagnoses.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255|unique:dd_diagnoses,name',
        ]);
        $data = $request->all();
        $data['created_by'] = Auth::id();

        $ddDiagnosis = DdDiagnosis::create($data);

        return redirect()->route('dd-diagnoses.edit', $ddDiagnosis->id)
            ->with('success', 'Diagnosis created successfully.');
    }

    public function edit(DdDiagnosis $ddDiagnosis)
    {
        return view('dd-diagnoses.edit', compact('ddDiagnosis'));
    }

    public function update(Request $request, DdDiagnosis $ddDiagnosis)
    {
        $this->validate($request, [
            'name' => 'required|max:255|unique:dd_diagnoses,name,' . $ddDiagnosis->id,
            'status' => 'required|integer|in:0,1',
        ]);
        $data = $request->all();
        $data['updated_by'] = Auth::id();

        $ddDiagnosis->update($data);

        return redirect()->route('dd-diagnoses.index')
            ->with('success', 'Diagnosis updated successfully.');
    }

    public function destroy(DdDiagnosis $ddDiagnosis)
    {
        $ddDiagnosis->delete();

        return redirect()->route('dd-diagnoses.index')
            ->with('success', 'Diagnosis deleted successfully.');
    }
}
