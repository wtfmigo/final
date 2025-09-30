<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     * GET /api/invoices
     */
    public function index()
    {
        // Return all invoices, newest first
        return Invoice::orderBy('invoice_date', 'desc')->get();
    }

    /**
     * Store a newly created resource in storage.
     * POST /api/invoices
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'invoice_number'     => 'required|unique:invoices',
            'client_name'        => 'required|string|max:255',
            'client_email'       => 'nullable|email',
            'client_address'     => 'nullable|string',
            'payment_conditions' => 'nullable|string',
            'currency'           => 'nullable|string|max:10',
            'invoice_date'       => 'required|date',
            'due_date'           => 'nullable|date',
            'status'             => 'required|in:Pending,Paid,Overdue',
            'subtotal'           => 'nullable|numeric|min:0',
            'tax'                => 'nullable|numeric|min:0',
            'total'              => 'required|numeric|min:0',
            'products'           => 'nullable|array',
            'additional_info'    => 'nullable|string',
        ]);

        return Invoice::create($data);
    }

    /**
     * Display the specified resource.
     * GET /api/invoices/{invoice}
     */
    public function show(Invoice $invoice)
    {
        return $invoice;
    }

    /**
     * Update the specified resource in storage.
     * PUT/PATCH /api/invoices/{invoice}
     */
    public function update(Request $request, Invoice $invoice)
    {
        $data = $request->validate([
            'invoice_number'     => 'required|unique:invoices,invoice_number,' . $invoice->id,
            'client_name'        => 'required|string|max:255',
            'client_email'       => 'nullable|email',
            'client_address'     => 'nullable|string',
            'payment_conditions' => 'nullable|string',
            'currency'           => 'nullable|string|max:10',
            'invoice_date'       => 'required|date',
            'due_date'           => 'nullable|date',
            'status'             => 'required|in:Pending,Paid,Overdue',
            'subtotal'           => 'nullable|numeric|min:0',
            'tax'                => 'nullable|numeric|min:0',
            'total'              => 'required|numeric|min:0',
            'products'           => 'nullable|array',
            'additional_info'    => 'nullable|string',
        ]);

        $invoice->update($data);
        return $invoice;
    }

    /**
     * Remove the specified resource from storage.
     * DELETE /api/invoices/{invoice}
     */
    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        return response()->json(['message' => 'Invoice deleted successfully']);
    }
}
