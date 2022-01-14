<?php

namespace App\Modules\Report\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Modules\Report\Facades\ReportsFacade;
use App\Modules\Category\Requests\StoreCategoryRequest;
use App\Modules\Category\Requests\UpdateCategoryRequest;
use App\Services\ReportService;
use App\Services\Service;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    private $facade;

    public function __construct(ReportsFacade $reportsFacade)
    {
        $this->facade = $reportsFacade;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function reports(Request $request)
    {
        $parameters = $request->all(['range', 'technician', 'audited', 'dateStart', 'dateEnd']);
        return view('reports.reports', $parameters);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function selfReports(Request $request)
    {
        $parameters = $request->all(['range', 'audited', 'dateStart', 'dateEnd']);
        return view('reports.self-reports', $parameters);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function selfReportsDownload(Request $request)
    {
        if (!$request->data){
            abort(404);
        }
        $data = Service::decrypt($request->data);
        return $this->facade->selfReportsDownload((array) json_decode($data));
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function reportsDownload(Request $request)
    {
        if (!$request->data){
            abort(404);
        }
        $data = Service::decrypt($request->data);
        return $this->facade->reportsDownload((array) json_decode($data));
    }
}
