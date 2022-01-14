<?php

namespace App\Http\Controllers;

use App\Models\ProductStatus;
use App\Services\ChartService;

class PagesController extends Controller
{
    private ChartService $service;

    public function __construct(ChartService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return view('auth.login');
    }

    public function dashboard()
    {
        $statuses = ProductStatus::withCount('products')->whereNull('created_at')->get();
        $yearlyChart = $this->service->getLineChart('m.Y');
        $monthlyChart = $this->service->getLineChart('d.m');
        $pieChart = $this->service->getPieChart();
        return view('dashboard',
        compact('statuses', 'yearlyChart', 'monthlyChart', 'pieChart'));
    }

    public function setLang($lang)
    {
        session(['lang' => $lang]);
        return redirect()->back();
    }
}
