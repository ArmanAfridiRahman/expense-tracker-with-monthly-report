<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Services\HomeService;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected HomeService $service;

    public function __construct(HomeService $service)
    {
        $this->service = $service;
    }

    /**
     * Display the dashboard page.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function dashboard(Request $request): View
    {
        return $this->service->getDashboardData($request);
    }

    /**
     * Summary of chartData
     * @param \Illuminate\Http\Request $request
     * @return JsonResponse
     */
    public function chartData(Request $request): JsonResponse
    {
        $filters = $request->only(['year', 'month', 'category_id']);
        $chartData = $this->service->getChartData($filters);

        return response()->json([
            'success' => true,
            'data'    => $chartData,
        ]);
    }
}
