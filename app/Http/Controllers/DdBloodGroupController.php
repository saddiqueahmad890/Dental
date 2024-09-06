<?php

namespace App\Http\Controllers;

use App\Models\DdBloodGroup; // Update model import
use Illuminate\Http\Request;
use App\Models\UserLogs;
use App\Exports\DdBloodGroupExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\GenericExport;

class DdBloodGroupController extends Controller
{
    public function index(Request $request)
    {
        if ($request->export) {
            return $this->doExport($request);
        }

        $bloodGroups = DdBloodGroup::paginate(10);
        return view('dd-blood-group.index', compact('bloodGroups'));
    }

    private function doExport(Request $request)
    {
        $data = DdBloodGroup::all()->map(function ($bloodGroup) {
            return [
                $bloodGroup->id,
                $bloodGroup->name,
                $bloodGroup->status == 1 ? 'Active' : 'Inactive',
                $bloodGroup->created_at,
                $bloodGroup->updated_at,
            ];
        })->toArray();

        $headers = ['ID', 'Name', 'Status', 'Created At', 'Updated At'];

        return Excel::download(new GenericExport($data, $headers), 'BloodGroups.xlsx');
    }

    public function create()
    {
        return view('dd-blood-group.create'); // Update view path
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255|unique:dd_blood_groups,name',
            
        ]);
        $data = $request->all();
        $data['created_by'] = auth()->id();

        $dd_blood_group = DdBloodGroup::create($data);

        return redirect()->route('dd-blood-groups.edit', $dd_blood_group->id)->with('success', 'Blood Group created successfully.');
    }


    public function edit(DdBloodGroup $dd_blood_group)
    {
        return view('dd-blood-group.edit', compact('dd_blood_group'));
    }

    public function update(Request $request, DdBloodGroup $dd_blood_group)
    {
        $this->validate($request, [
            'name' => 'required|max:255|unique:dd_blood_groups,name,' . $dd_blood_group->id,
            'status' => 'required|in:0,1',

        ]);

        $dd_blood_group->update([
            'name' => $request->name,
            'status' => $request->status,
            'updated_by' => auth()->id(),

        ]);

        return redirect()->route('dd-blood-groups.edit', $dd_blood_group->id)->with('success', 'Blood Group updated successfully.');

    }


    public function destroy(DdBloodGroup $dd_blood_group)
    {
        $dd_blood_group->delete();
        return redirect()->route('dd-blood-groups.index')->with('success', 'Blood Group deleted successfully.');
    }
}
