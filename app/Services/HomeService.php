<?php

namespace App\Services;

use App\Models\Expense;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeService
{
     /**
      * Summary of getDashboardData
      * @param \Illuminate\Http\Request $request
      * @return \Illuminate\Contracts\View\View
      */
     public function getDashboardData(Request $request): View
     {
          $user = Auth::user();
          $categories = Category::withCount([
                                   'expenses as expenses_count' => fn($q) =>
                                        $q->where('user_id', $user->id)
                                             ->when($request->input('year'), fn($q) => $q->whereYear('date', $request->input('year')))
                                             ->when($request->input('month'), fn($q) => $q->whereMonth('date', $request->input('month')))
                                   ])->withSum(['expenses as total' => fn($q) =>
                                             $q->where('user_id', $user->id)
                                                  ->when($request->input('year'), fn($q) => $q->whereYear('date', $request->input('year')))
                                                  ->when($request->input('month'), fn($q) => $q->whereMonth('date', $request->input('month')))
                                        ], 'amount')->orderBy('name')
                                                                 ->get();
                                 

          $chartData = $this->getChartData([
               'year'         => $request->input('year', Carbon::now()->year),
               'month'        => $request->input('month'),
               'category_id'  => $request->input('category_id'),
          ]);

          return view('user.dashboard', [
               'categories' => $categories,
               'chartData'  => $chartData,
          ]);
     }

     /**
      * Summary of getChartData
      * @param array $filters
      * @return array
      */
     public function getChartData(array $filters = []): array
     {
          $query = Expense::query()->where('user_id', Auth::id());

          $year = Arr::get($filters, 'year', Carbon::now()->year);
          $query->whereYear('date', $year);

          if ($month = Arr::get($filters, 'month')) {
               $query->whereMonth('date', $month);
          }

          if ($categoryId = Arr::get($filters, 'category_id')) {
               $query->where('category_id', $categoryId);
          }

          $data = $query->clone()->with('category')
                              ->selectRaw('category_id, SUM(amount) as total')
                              ->groupBy('category_id')
                              ->get()
                              ->mapWithKeys(fn($e) => [$e->category->name => $e->total]);

          $allCategories = Category::pluck('name');
          $allCategories->each(function($name) use (&$data) {
               if (!isset($data[$name])) {
                    $data[$name] = 0;
               }
          });

          return $data->sortKeys()->toArray();
     }
}
