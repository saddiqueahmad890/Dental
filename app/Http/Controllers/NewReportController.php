<?php

namespace App\Http\Controllers;

use App\Models\DdProcedure;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Http\Request;

class NewReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Invoice::query();

        // Check if at least one filter is applied
        $filtersApplied = false;

        // Filtering by date_from
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->input('date_from'));
            $filtersApplied = true;
        }

        // Filtering by date_to
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->input('date_to'));
            $filtersApplied = true;
        }

        // Filtering by MRN number
        if ($request->filled('mrn_number')) {
            $query->whereHas('user.patientDetails', function ($q) use ($request) {
                $q->where('mrn_number', 'like', '%' . $request->input('mrn_number') . '%');
            });
            $filtersApplied = true;
        }

        // Filtering by invoice_number
        if ($request->filled('invoice_number')) {
            $query->where('invoice_number', 'like', '%' . $request->input('invoice_number') . '%');
            $filtersApplied = true;
        }

        // Filtering by doctor
        if ($request->filled('doctor')) {
            $query->whereHas('doctor', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->input('doctor') . '%');
            });
            $filtersApplied = true;
        }

        if ($request->filled('procedure')) {
            $procedureId = $request->input('procedure');
            $query->whereHas('invoiceItems.patienttreatmentplanprocedures', function ($q) use ($procedureId) {
                $q->where('dd_procedure_id', $procedureId);
            });
            $filtersApplied = true;
        }


        // Fetch the filtered data only if filters are applied
        if ($filtersApplied) {
            $invoices = $query->get();
        } else {
            $invoices = collect(); // Return an empty collection if no filters are applied
        }

        // Fetch the filtered data only if filters are applied
        if ($filtersApplied) {
            $invoices = $query->get();
        } else {
            $invoices = collect(); // Return an empty collection if no filters are applied
        }

        $procedures = DdProcedure::all();

        return view('new-reports.index', compact('invoices', 'procedures'));
    }
}
