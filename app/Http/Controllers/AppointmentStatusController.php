<?php

namespace App\Http\Controllers;
use App\Models\UserLogs;

use App\Models\AppointmentStatus;
use Illuminate\Http\Request;



class AppointmentStatusController extends Controller
{
    public function index()
    {
        $appointmentStatuses= AppointmentStatus:: orderBy('id', 'desc')->paginate(10);
        return view('appointment-status.index', compact('appointmentStatuses'));
    }

    public function create()
    {
        return view('appointment-status.create');
    }

    public function store(Request $request)
    {
        $this->validation($request);
        $data = $request->all();
        $data['created_by'] = auth()->id();
        $appointmentStatus= AppointmentStatus::create($data);
        return redirect()->route('appointment-statuses.edit', $appointmentStatus->id)->with('success', 'Appoinment createded successfully.');
    }

    public function edit(AppointmentStatus $appointmentStatus)
    {

        return view('appointment-status.edit', compact('appointmentStatus'));
    }

    public function update(Request $request, AppointmentStatus $appointmentStatus)

    {
        $this->validation($request);
        $data = $request->all();
        $data['updated_by'] = auth()->id();
        $appointmentStatus->update($data);
        return redirect()->route('appointment-statuses.edit', $appointmentStatus->id)->with('success', 'Appoinment updated successfully.');

    }

    public function destroy(AppointmentStatus $appointmentStatus)
    {
        $appointmentStatus->delete();
        return redirect()->route('appointment-statuses.index')->with('success', 'Appoinment deleted successfully.');
    }

    private function validation(Request $request, $id = 0)
    {
        $request->validate([
            'name' => ['required', 'unique:users,name,' . $id, 'max:255'],
        ]);
    }
}






