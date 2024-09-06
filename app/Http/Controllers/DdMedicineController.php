<?php

namespace App\Http\Controllers;

use App\Models\DdMedicine;
use App\Models\DdMedicineType;
use Illuminate\Support\Facades\Auth;
use App\Models\UserLogs;
use Illuminate\Http\Request;
use App\Exports\GenericExport;
use Maatwebsite\Excel\Facades\Excel;

class DdMedicineController extends Controller
{


    public function index(Request $request)
    {
        if ($request->export) {
            return $this->doExport($request);
        }


        $ddMedicineTypes = DdMedicineType::all();
        $ddMedicines = $this->filter($request)->orderBy('id', 'desc')->paginate(10);
        return view('dd-medicine.index', compact('ddMedicines', 'ddMedicineTypes'));
    }

    private function doExport()
    {
        // Retrieve all data without filters
        $ddMedicines = DdMedicine::with('medicineType')->get();

        // Prepare data for export
        $data = $ddMedicines->map(function ($medicine) {
                return [
                    $medicine->id,
                    $medicine->name,
                    $medicine->medicineType->name ?? 'N/A',
                    $medicine->status == '1' ? 'Active' : 'Inactive',
                    $medicine->created_at,
                    $medicine->updated_at,
                ];
            })->toArray();

        // Define headers for the export
        $headers = ['ID', 'Name', 'Medicine Type', 'Status', 'Created At', 'Updated At'];

        return Excel::download(new GenericExport($data, $headers), 'DdMedicines.xlsx');
    }

    private function filter(Request $request)
    {
        $query = DdMedicine::query();

        if ($request->has('name') && $request->name) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->has('medicine_type') && $request->medicine_type) {
            $query->whereHas('medicineType', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->medicine_type . '%');
            });
        }

        return $query;
    }

    public function create()
    {
        $ddMedicineTypes = DdMedicineType::all();

        return view('dd-medicine.create', compact('ddMedicineTypes'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255|unique:dd_medicines,name',
            'description' => 'required|max:255',
            'dd_medicine_type' => 'nullable|numeric|max:255',
        ]);

        $data = $request->all();
        $data['created_by'] = Auth::id();

        $dd_medicine = DdMedicine::create($data);

        return redirect()->route('dd-medicine.edit', $dd_medicine->id)->with('success', 'Medicine created successfully.');
    }

    public function edit(DdMedicine $dd_medicine)
    {
        $ddMedicineTypes = DdMedicineType::all();
        // changing for log
        $tablename = "dd_medicines"; //table name
        $logid = $dd_medicine->id; //patientAppointment from the public function show(PatientAppointment $patientAppointment)
        $logs = UserLogs::where('table_name', $tablename)
            ->where('record_id', $logid)
            ->get();

        return view('dd-medicine.edit', compact('dd_medicine', 'ddMedicineTypes', 'logs'));
    }


    public function update(Request $request, DdMedicine $dd_medicine)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'status' => 'nullable|in:0,1',
            'description' => 'required|max:255',
            'dd_medicine_type' => 'nullable|numeric|max:255',
        ]);

        $data = $request->only(['name', 'status','description', 'dd_medicine_type']);
        $data['updated_by'] = Auth::id();

        $dd_medicine->update($data);

        return redirect()->route('dd-medicine.edit', $dd_medicine->id)->with('success', 'Medicine updated successfully.');
    }

    public function destroy(DdMedicine $dd_medicine)
    {
        $dd_medicine->delete();
        return redirect()->route('dd-medicine.index')->with('success', 'Medicine deleted successfully.');
    }
}
