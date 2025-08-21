<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Expense;
use App\Models\Category;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Database\Eloquent\Builder;

class ExpenseService
{
     /**
      * Summary of expenseList
      * @return LengthAwarePaginator
      */
     public function expenseList(): LengthAwarePaginator
     {
          return Expense::with('category')
                              ->where('user_id', Auth::id())
                              ->when(request('year'), fn(Builder $q, $year) => $q->whereYear('date', $year))
                              ->when(request('month'), fn(Builder $q, $month) => $q->whereMonth('date', $month))
                              ->date('date')
                              ->search(['title', 'amount'])
                              ->filter(['category_id' => 'category_id'])
                              ->orderBy('date', 'desc') 
                              ->orderBy('id', 'desc')  
                              ->paginate(setting("pagination_value", 5));
     }

     /**
      * Summary of store
      * @param array $data
      * @return Expense
      */
     public function store(array $data): Expense
     {
          $now = Carbon::now();
          return Expense::create([
               'user_id'     => Auth::id(),
               'category_id' => Arr::get($data, 'category_id', 0),
               'title'       => Arr::get($data, 'title', ''),
               'amount'      => Arr::get($data,'amount', 0),
               'date'        => Arr::get($data, 'date', $now),
          ]);
     }

     /**
      * Summary of monthlySummaryWithExpenses
      * @return Collection<int, Category>
      */
     public function monthlySummaryWithExpenses(): Collection
     {
          $now = Carbon::now();
          $categories = Category::with([
                                   'expenses' => fn($q):Builder =>
                                        $q->where('user_id', Auth::id())
                                             ->whereMonth('date', $now->format('m'))
                                             ->whereYear('date', $now->format('Y'))
                                             ->orderBy('date', 'desc') 
                                             ->orderBy('id', 'desc')  
                                   ])->search(['name'])->get();

          $categories->map(fn($category) => $category->total = $category->expenses->sum('amount'));

          return $categories;
     }
}
