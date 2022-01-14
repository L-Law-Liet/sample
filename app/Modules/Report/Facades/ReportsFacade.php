<?php


namespace App\Modules\Report\Facades;

use App\Services\ReportService;
use Barryvdh\DomPDF\Facade as PDF;

class ReportsFacade
{
    private $service;
    public function __construct(ReportService $service)
    {
        $this->service = $service;
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function selfReportsDownload(array $data)
    {
        $date = $this->service->getRange($data['range'] ?? 0);
        $data['products'] = $this->service
            ->getSelfReportProducts($data['dateEnd'], $data['dateStart'], $data['audited'], $date)
            ->get();

        $pdf = PDF::loadView('pdf.self-report', $data)->setOptions(['defaultFont' => 'sans-serif']);
        return $pdf->download('report.pdf');
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function reportsDownload(array $data)
    {
        $date = $this->service->getRange($data['range'] ?? 0);
        $data['users'] = $this->service
            ->getReport($data['dateEnd'], $data['dateStart'], $data['audited'], $date, $data['technician']);

        $pdf = PDF::loadView('pdf.report', $data)->setOptions(['defaultFont' => 'sans-serif']);
        return $pdf->download('report.pdf');
    }
}
