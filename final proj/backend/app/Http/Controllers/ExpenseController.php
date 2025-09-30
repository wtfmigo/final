<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     * GET /api/expenses
     */
    public function index()
    {
        return Expense::orderBy('date', 'desc')->get();
    }

    /**
     * Store a newly created resource in storage.
     * POST /api/expenses
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'source' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'date'   => 'required|date',
        ]);

        return Expense::create($data);
    }

    /**
     * Display the specified resource.
     * GET /api/expenses/{id}
     */
    public function show(Expense $expense)
    {
        return $expense;
    }

    /**
     * Update the specified resource in storage.
     * PUT /api/expenses/{id}
     */
    public function update(Request $request, Expense $expense)
    {
        $data = $request->validate([
            'source' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'date'   => 'required|date',
        ]);

        $expense->update($data);
        return $expense;
    }

    /**
     * Remove the specified resource from storage.
     * DELETE /api/expenses/{id}
     */
    public function destroy(Expense $expense)
    {
        $expense->delete();
        return response()->noContent();
    }
}
