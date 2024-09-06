<?php

namespace App\Http\Controllers;

use App\Models\DentalLabOrder;
use App\Models\DoctorDetail;
use App\Models\User;
use App\Models\PatientDetail;
use Illuminate\Http\Request;

class DentalLabOrderController extends Controller
{
    public function index()
    {

        $orders = DentalLabOrder::orderBy('id', 'desc')->paginate(10);
        return view('dental_lab_orders.index', compact('orders'));
    }

    public function create()
    {
        $patients = PatientDetail::all();
        $labs = User::role('laboratorist')->get();
        $doctors = DoctorDetail::all();
        return view('dental_lab_orders.create', compact('patients', 'doctors', 'labs'));
    }

    public function store(Request $request)
    {
        // dd($request);
        $validated = $request->validate([
            'doctor_id' => 'required|integer',
            'patient_id' => 'required|integer',
            'lab_id' => 'required|integer',
            'sending_date' => 'required|date',
            'returning_date' => 'nullable|date',

        ]);
        $lab = User::find($validated['lab_id']); // Assuming the lab is a user
        // or if you have a Lab model:
        // $lab = App\Models\Lab::find($validated['lab_id']);

        // Check if lab/user exists, then get the email

        $data = $request->all();

        $checkboxFields = [
            'zirconia_mono',
            'zirconia_layered',
            'zirconia_non_pre_veneers',
            'zirconia_veneers',
            'zirconia_crown',
            'zirconia_bridges',

            // E-MAX Section
            'e_max_milled',
            'e_max_pressed',
            'e_max_non_pre_veneers',
            'e_max_veneers',
            'e_max_crown',
            'e_max_bridges',

            // PFM Section
            'pfm_porcelain',
            'pfm_non_pres',
            'pfm_implant',
            'pfm_post_and_core',
            'pfm_crown',
            'pfm_bridges',

            // PEEK Section
            'peek_removable_partial_denture',
            'peek_fixed_prosthetic_framework',
            'peek_attachment_restorations',
            'peek_supported',
            'peek_screw',
            'peek_retained',
            'peek_implant',
            'peek_superstructures',

            // Removable Prosthetics Section
            'removable_diagnostic_wax_up',
            'removable_hybrid_denture',
            'removable_tooth_addition',
            'removable_over_denture',
            'removable_relining_hard_soft',
            'removable_veneers',
            'removable_flexible',
            'removable_crown',
            'removable_bridges',
            'removable_screw',
            'removable_implant',
            'removable_retained',

            // Items Sending Section
            'items_imp',
            'items_partial',
            'items_bite',
            'items_photo',
            'items_study_models',
            'items_shade_tab',
            'items_digital_impression',
            'items_further',

            // Removable Appliance Section
            'appliance_ortho',
            'appliance_retainer',
            'appliance_night_guard',
            'appliance_occlusal_splint',
            'appliance_sheet_press_retainer',
            'appliance_wire',
            'appliance_hyrax',
            'appliance_tpa',
            'appliance_obturator',
            'appliance_space_maintainer',
        ];

        foreach ($checkboxFields as $field) {
            $data[$field] = $request->has($field) ? 1 : 0;
        }

        DentalLabOrder::create($data);
        // $id = auth()->id(); 
        // $url = 'doctor-details.show';
        // $msg = "New Doctor Has been registered";
        // sendNotification($id, $url, $msg);


        if ($_SERVER['SERVER_NAME'] !== 'localhost') {
            $messageBodyForAdmin = "A new Lab report has been created"; // Clear text
            $subjectForAdmin = "A new Lab report notification"; // Clear text
            $messageBodyForDoctor = "Your Lab report has been completed successfully"; // Clear text
            $subjectForDoctor = "Lab report completed"; // Clear text

            mail($lab->email,
                $subjectForDoctor,
                $messageBodyForDoctor
            );
            mail("saddiqueahmad890@gmail.com", $subjectForAdmin, $messageBodyForAdmin);// for testing 
        }

        return redirect()->route('dental_lab_orders.index')->with('success', 'Dental Lab Order created successfully.');
    }




    public function show(DentalLabOrder $dentalLabOrder)
    {
        $id=$dentalLabOrder->lab_id;
       
        $user = User::find($id);
        $laboratorist_name=$user->name;
        return view('dental_lab_orders.show', compact('dentalLabOrder' , 'laboratorist_name'));
    }

    public function edit(DentalLabOrder $dentalLabOrder)
    {
        $patients = PatientDetail::all();
        $labs = User::role('laboratorist')->get();
        $doctors = DoctorDetail::all();
        return view('dental_lab_orders.edit', compact('dentalLabOrder', 'patients', 'doctors', 'labs'));
    }

    public function update(Request $request, $id)
    {
        // dd($request);
        $validated = $request->validate([
            'doctor_id' => 'integer',
            'patient_id' => 'integer',
            'lab_id' => 'integer',
            'sending_date' => 'date',
            'returning_date' => 'nullable|date',
        ]);
        
        $lab = User::find($validated['lab_id']); // Assuming the lab is a user
        
        // Retrieve the existing DentalLabOrder by ID
        $dentalLabOrder = DentalLabOrder::findOrFail($id);

        $data = $request->all();

        $checkboxFields = [
            'zirconia_mono',
            'zirconia_layered',
            'zirconia_non_pre_veneers',
            'zirconia_veneers',
            'zirconia_crown',
            'zirconia_bridges',


            // E-MAX Section
            'e_max_milled',
            'e_max_pressed',
            'e_max_non_pre_veneers',
            'e_max_veneers',
            'e_max_crown',
            'e_max_bridges',

            // PFM Section
            'pfm_porcelain',
            'pfm_non_pres',
            'pfm_implant',
            'pfm_post_and_core',
            'pfm_crown',
            'pfm_bridges',

            // PEEK Section
            'peek_removable_partial_denture',
            'peek_fixed_prosthetic_framework',
            'peek_attachment_restorations',
            'peek_supported',
            'peek_screw',
            'peek_retained',
            'peek_implant',
            'peek_superstructures',

            // Removable Prosthetics Section
            'removable_diagnostic_wax_up',
            'removable_hybrid_denture',
            'removable_tooth_addition',
            'removable_over_denture',
            'removable_relining_hard_soft',
            'removable_veneers',
            'removable_flexible',
            'removable_crown',
            'removable_bridges',
            'removable_screw',
            'removable_implant',
            'removable_retained',

            // Items Sending Section
            'items_imp',
            'items_partial',
            'items_bite',
            'items_photo',
            'items_study_models',
            'items_shade_tab',
            'items_digital_impression',
            'items_further',

            // Removable Appliance Section
            'appliance_ortho',
            'appliance_retainer',
            'appliance_night_guard',
            'appliance_occlusal_splint',
            'appliance_sheet_press_retainer',
            'appliance_wire',
            'appliance_hyrax',
            'appliance_tpa',
            'appliance_obturator',
            'appliance_space_maintainer',

        ];

        foreach ($checkboxFields as $field) {
            $data[$field] = $request->has($field) ? 1 : 0;
        }

        // Update the DentalLabOrder with the new data

        $dentalLabOrder->update($data);
        if ($_SERVER['SERVER_NAME'] !== 'localhost') {
            $messageBodyForAdmin = "A new Lab report has been created"; // Clear text
            $subjectForAdmin = "A new Lab report notification"; // Clear text
            $messageBodyForDoctor = "Your Lab report has been completed successfully"; // Clear text
            $subjectForDoctor = "Lab report completed"; // Clear text

            mail(
                $lab->email,
                $subjectForDoctor,
                $messageBodyForDoctor
            );
            mail("saddiqueahmad890@gmail.com", $subjectForAdmin, $messageBodyForAdmin); // for testing 
        }


        return redirect()->route('dental_lab_orders.index')->with('success', 'Dental Lab Order updated successfully.');
    }


    public function destroy(DentalLabOrder $dentalLabOrder)
    {
        $dentalLabOrder->delete();
        return redirect()->route('dental_lab_orders.index');
    }
}
