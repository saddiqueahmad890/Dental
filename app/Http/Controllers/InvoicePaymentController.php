<?php

namespace App\Http\Controllers;

use App\Models\InvoicePayment;
use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoicePaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'invoice_id' => 'required|exists:invoices,id',
            'paid_amount' => 'required|numeric|min:0',
        ]);

        $invoiceId = $request->input('invoice_id');
        $paidAmount = $request->input('paid_amount');
        $remainingBalance = $this->getRemainingBalance($invoiceId);

        if ($paidAmount > $remainingBalance) {
            return response()->json(['error' => 'Paid amount exceeds remaining balance.'], 400);
        }

        $invoicePayment = new InvoicePayment([
            'invoice_id' => $invoiceId,
            'paid_amount' => $paidAmount,
            'payment_type' => $request->input('payment_type'),
            'insurance_id' => $request->input('insurance_id'),
            'comments' => $request->input('comments'),
        ]);

        $invoicePayment->save();


        $invoice = Invoice::find($invoicePayment->invoice_id);
        $invoice->paid += $invoicePayment->paid_amount;
        $invoice->due -= $invoicePayment->paid_amount;
        $invoice->save();

        if ($_SERVER['SERVER_NAME'] !== 'localhost' && $invoice) {
            $invoiceItemsTable = '
            <table style="width: 600px; border-collapse: collapse; font-family: Arial, sans-serif;">
                <thead>
                    <tr>
                        <th style="border: 1px solid #000; padding: 8px;">Sr.NO</th>
                        <th style="border: 1px solid #000; padding: 8px;">Procedure Title</th>
                        <th style="border: 1px solid #000; padding: 8px;">Procedure Price</th>
                    </tr>
                </thead>
                <tbody>';

            $srNo = 1;
            foreach ($invoice->invoiceItems as $invoiceItem) {
                $procedureTitle = $invoiceItem->patienttreatmentplanprocedures->procedure->title ?? $invoiceItem->title;
                $invoiceItemsTable .= '
                <tr>
                    <td style="border: 1px solid #000; padding: 8px; text-align: center;">' . $srNo . '</td>
                    <td style="border: 1px solid #000; padding: 8px;">' . $procedureTitle . '</td>
                    <td style="border: 1px solid #000; padding: 8px; text-align: right;">' . $invoiceItem->total . '</td>
                </tr>';
                $srNo++;
            }

            $invoiceItemsTable .= '
                </tbody>
            </table>';

            // Add the current payment details in another HTML table
            $paymentDetails = '
            <table style="width: 600px; border-collapse: collapse; margin-top: 20px; font-family: Arial, sans-serif;">
                <thead>
                    <tr>
                        <th style="border: 1px solid #000; padding: 8px;">Sr.NO</th>
                        <th style="border: 1px solid #000; padding: 8px;">Paid Amount</th>
                        <th style="border: 1px solid #000; padding: 8px;">Due Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="border: 1px solid #000; padding: 8px; text-align: center;">1</td>
                        <td style="border: 1px solid #000; padding: 8px; text-align: right;">' . $invoicePayment->paid_amount . '</td>
                        <td style="border: 1px solid #000; padding: 8px; text-align: right;">' . $invoice->due . '</td>
                    </tr>
                </tbody>
            </table>';

            // Prepare the HTML email content
            $messageBodyForPatient = '
            <p style="font-family: Arial, sans-serif;">Hi, ' . $invoice->user->name . ',</p>
            <p style="font-family: Arial, sans-serif;">Your Invoice is Generated with Invoice Number: ' . $invoice->invoice_number . ' Against the Treatment Plan Number: ' . ($invoice->patienttreatmentplan->treatment_plan_number ?? "TPL") . ' Formulated By Doctor ' . $invoice->doctor->name . '. Your Grand Total is: ' . $invoice->grand_total . ', Dated As: ' . $invoice->invoice_date . '</p>
            <h3 style="font-family: Arial, sans-serif;">Invoice Details:</h3>
            ' . $invoiceItemsTable . '
            <p style="font-family: Arial, sans-serif;"><strong>Total:</strong> ' . $invoice->grand_total . '</p>
            <h3 style="font-family: Arial, sans-serif;">Payment Details:</h3>
            ' . $paymentDetails;

            $subjectForPatient = "Invoice Generated successfully - With Invoice Number: " . $invoice->invoice_number;

            $messageBodyForAdmin = '
            <p style="font-family: Arial, sans-serif;">A new Invoice created for Patient Named ' . $invoice->user->name . ' with Doctor ' . $invoice->doctor->name . ' has been created with Invoice Number: ' . $invoice->invoice_number . '.</p>
            <h3 style="font-family: Arial, sans-serif;">Invoice Details:</h3>
            ' . $invoiceItemsTable . '
            <p style="font-family: Arial, sans-serif;"><strong>Total:</strong> ' . $invoice->grand_total . '</p>
            <h3 style="font-family: Arial, sans-serif;">Payment Details:</h3>
            ' . $paymentDetails;

            $subjectForAdmin = "A new Invoice Added to System";
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            $headers .= 'From: <no-reply@example.com>' . "\r\n"; // Replace with your desired sender email

            mail($invoice->user->email, $subjectForPatient, $messageBodyForPatient, $headers);
            mail("umerfayyaz633@gmail.com", $subjectForAdmin, $messageBodyForAdmin, $headers);

        }



        return response()->json(['success' => 'Payment recorded successfully.', 'invoicePayment'=>$invoicePayment]);
    }


    private function getRemainingBalance($invoiceId)
    {
        $invoice = Invoice::find($invoiceId);
        $totalPaid = $invoice->invoicePayments()->sum('paid_amount');
        return $invoice->grand_total - $totalPaid;
    }

    public function remainingBalance($invoiceId)
    {
        $remainingBalance = $this->getRemainingBalance($invoiceId);
        return response()->json(['remaining_balance' => $remainingBalance]);
    }

    public function fetchPaidAmount($id)
    {   $invoice=Invoice::find($id);
        $paidAmount = InvoicePayment::where('invoice_id', $id)->sum('paid_amount');
        $due_amount=$invoice->grand_total-$paidAmount;
        return response()->json(['paid_amount' => $paidAmount,'due_amount'=>$due_amount]);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\InvoicePayment  $invoicePayment
     * @return \Illuminate\Http\Response
     */
    public function show(InvoicePayment $invoicePayment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\InvoicePayment  $invoicePayment
     * @return \Illuminate\Http\Response
     */
    public function edit(InvoicePayment $invoicePayment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\InvoicePayment  $invoicePayment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InvoicePayment $invoicePayment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\InvoicePayment  $invoicePayment
     * @return \Illuminate\Http\Response
     */
    public function destroy(InvoicePayment $invoicePayment)
    {
        //
    }
}
