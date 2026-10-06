<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\Dashboard\DashboardService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct(
        private readonly DashboardService $dashboardService
    ) {
    }

    public function index(Request $request)
    {
        $data = $this->dashboardService->getDashboardData(
            from: $request->input('from'),
            to: $request->input('to')
        );

        return view('dashboard.index', $data);
    }
}