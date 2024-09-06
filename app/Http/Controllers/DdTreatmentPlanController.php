<?php

namespace App\Http\Controllers;

use App\Models\UserLogs;
use App\Models\DdTreatmentPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Exports\GenericExport;
use Maatwebsite\Excel\Facades\Excel;


class DdTreatmentPlanController extends Controller
{
    public function index(Request $request)
    {
        if ($request->export) {
            return $this->doExport($request);
        }

        $ddTreatmentPlans = $this->filter($request)->orderBy('id', 'desc')->paginate(10);
        return view('dd-treatment-plan.index', compact('ddTreatmentPlans'));
    }
    private function doExport(Request $request)
    {
        // Retrieve all data without filters
        $ddTreatmentPlans = DdTreatmentPlan::get();

        // Prepare data for export
        $data = $ddTreatmentPlans->map(function ($Treatment) {
            return [
                $Treatment->id,
                $Treatment->title,
                $Treatment->description,
                $Treatment->status == '1' ? 'Active' : 'Inactive',
                $Treatment->created_at,
                $Treatment->updated_at,
            ];
        })->toArray();

        // Define headers for the export
        $headers = ['ID', 'Title', 'Description', 'Status', 'Created At', 'Updated At'];

        return Excel::download(new GenericExport($data, $headers), 'ddTreatmentPlans.xlsx');
    }


    private function filter(Request $request)
    {
        $query = DdTreatmentPlan::query();

        if ($request->has('title')) {
            $query->where('title', 'like', '%' . $request->input('title') . '%');
        }

        if ($request->has('description')) {
            $query->where('description', 'like', '%' . $request->input('description') . '%');
        }

        return $query;
    }
    public function create()
    {
        return view('dd-treatment-plan.create');
    }

    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'title' => 'required|max:255',
        ]);
        $treatmentplan = new DdTreatmentPlan();
        $treatmentplan->title = $request->input('title');
        $treatmentplan->description = $request->input('description');
        $treatmentplan->created_by = Auth::id();
        $treatmentplan->save();
        $treatment = $treatmentplan->id;

        $ddTreatmentPlan = $treatmentplan->id;

        // Redirect to the index route with a success message
        return redirect()->route('dd-treatment-plans.edit', $ddTreatmentPlan)
            ->with('success', 'Treatment Plan created successfully.');
    }

    public function edit(DdTreatmentPlan  $ddTreatmentPlan)
    {


        return view('dd-treatment-plan.edit', compact('ddTreatmentPlan'));
    }


    public function show(DdTreatmentPlan  $ddTreatmentPlan)
    {

        return view('dd-treatment-plan.show', compact('ddTreatmentPlan'));
    }

    public function update(Request $request, DdTreatmentPlan   $ddTreatmentPlan)
    {
        $request->validate([
            'title' => 'required|max:255',

        ]);
        $data = $request->all();
        $data['updated_by'] = auth()->id();

        $ddTreatmentPlan->update($data);


        return redirect()->route('dd-treatment-plans.edit', $ddTreatmentPlan)
            ->with('success', 'Treatment Plan updated successfully.');
    }




    public function destroy(DdTreatmentPlan $ddTreatmentPlan)
    {
        if ($ddTreatmentPlan) {
            $ddTreatmentPlan->delete();
            return redirect()->route('dd-treatment-plans.index')
            ->with('success', 'Treatment Plan deleted successfully.');
        } else {
            return redirect()->route('dd-treatment-plans.index')
            ->with('error', 'Treatment Plan not found.');
        }
    }


}
