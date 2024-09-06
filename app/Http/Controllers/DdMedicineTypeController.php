<?php

namespace App\Http\Controllers;

use App\Models\DdMedicineType;
use Illuminate\Http\Request;
use App\Exports\GenericExport;
use Maatwebsite\Excel\Facades\Excel;

class DdMedicineTypeController extends Controller
{
    public function index(Request $request)
    {
        if ($request->export) {
            return $this->doExport($request);
        }


        $ddMedicineTypes = $this->filter($request)->orderBy('created_at', 'desc')->paginate(10);
        return view('dd-medicine-type.index', compact('ddMedicineTypes'));
    }

    private function doExport()
    {
        // Retrieve all data without filters
        $ddMedicineTypes = DdMedicineType::get();

        // Prepare data for export
        $data = $ddMedicineTypes->map(function ($medicine) {
            return [
                $medicine->id,
                $medicine->name,
                $medicine->description,
                $medicine->status == '1' ? 'Active' : 'Inactive',
                $medicine->created_at,
                $medicine->updated_at,
            ];
        })->toArray();

        // Define headers for the export
        $headers = ['ID', 'Name', 'Description', 'Status', 'Created At', 'Updated At'];

        return Excel::download(new GenericExport($data, $headers), 'ddMedicineTypes.xlsx');
    }

    private function filter(Request $request)
    {
        $query = DdMedicineType::query();

        if ($request->has('name') && $request->name) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        return $query;
    }



    public function create()
    {
        return view('dd-medicine-type.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $medicine = DdMedicineType::create([
            'name' => $request->name,
            'description' => $request->description,
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('dd-medicine-types.edit', $medicine->id)
            ->with('success', 'Medicine type created successfully.');
    }

    public function edit(DdMedicineType $ddMedicineType)
    {


        return view('dd-medicine-type.edit', compact('ddMedicineType'));
    }

    public function update(Request $request, DdMedicineType $ddMedicineType)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $ddMedicineType->update([
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status,
            'updated_by' => auth()->id(),

        ]);

        return redirect()->route('dd-medicine-types.edit', $ddMedicineType->id)
            ->with('success', 'Medicine type updated successfully.');
    }

    public function destroy(DdMedicineType $ddMedicineType)
    {
        $ddMedicineType->delete();

        return redirect()->route('dd-medicine-types.index')
            ->with('success', 'Medicine type deleted successfully.');
    }
}
