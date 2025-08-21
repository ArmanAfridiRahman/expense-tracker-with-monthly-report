<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Services\ExpenseService;
use App\Http\Requests\ExpenseRequest;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ExpenseCollection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class ExpenseController extends Controller
{
    public function __construct(private ExpenseService $service) {}

    /**
     * Summary of index
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        $expenses = $this->service->expenseList();
        return view('user.expenses.index', compact('expenses'));
    }

    /**
     * Summary of store
     * @param \App\Http\Requests\ExpenseRequest $request
     * @return RedirectResponse
     */
    public function store(ExpenseRequest $request): RedirectResponse
    {
        $this->service->store($request->validated());
        return back()->with('success', 'Expense added successfully!');
    }

    /**
     * Summary of grouped
     * @return \Illuminate\Contracts\View\View
     */
    public function grouped(): View
    {
        $categories = $this->service->monthlySummaryWithExpenses();

        return view('user.expenses.grouped', [
            'categories' => new CategoryCollection($categories),
            'total'      => $categories->sum('total'),
        ]);
    }
}
