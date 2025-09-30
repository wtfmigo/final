<?php

namespace App\Http\Controllers;

use App\Models\Income;
use Illuminate\Http\Request;

class IncomeController extends Controller
{
    /**
     * Display a listing of the resource.
     * GET /api/incomes
     */
    public function index()
    {
        return Income::orderBy('date', 'desc')->get();
    }

    /**
     * Store a newly created resource in storage.
     * POST /api/incomes
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'source' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'date'   => 'required|date',
        ]);

        return Income::create($data);
    }

    /**
     * Display the specified resource.
     * GET /api/incomes/{income}
     */
    public function show(Income $income)
    {
        return $income;
    }

    /**
     * Update the specified resource in storage.
     * PUT/PATCH /api/incomes/{income}
     */
    public function update(Request $request, Income $income)
    {
        $data = $request->validate([
            'source' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'date'   => 'required|date',
        ]);

        $income->update($data);
        return $income;
    }

    /**
     * Remove the specified resource from storage.
     * DELETE /api/incomes/{income}
     */
    public function destroy(Income $income)
    {
        $income->delete();
        return response()->noContent();
    }
}
