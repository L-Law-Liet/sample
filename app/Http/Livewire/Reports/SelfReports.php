<?php

namespace App\Http\Livewire\Reports;

use App\Models\Product;
use App\Models\ProductStatus;
use App\Services\ReportService;
use Carbon\Carbon;
use Facade\FlareClient\Report;
use Livewire\Component;

class SelfReports extends Component
{
    public array $ths = [];
    public string $filter = 'none';

    public array $ranges = ['Daily', 'Monthly', 'Yearly'];
    public int $range = 0;
    public int $total = 0;

    public array $auditedList = ['Both', 'No', 'Yes'];
    public int $audited = 0;

    public string $dateStart = '';
    public string $dateEnd = '';

    public function mount()
    {
        $this->ths = ProductStatus::report()->pluck('name')->toArray();

        $this->setLang();
    }

    public function render()
    {


        $date = $this->getReportService()->getRange($this->range);
        $products = $this->getReportService()->getSelfReportProducts($this->dateEnd, $this->dateStart, $this->audited, $date);
        $temp = clone $products;
        $this->total = $temp->where('product_status_id', ProductStatus::REPAIRED)
            ->get()->sum('problem_type.payout');

        $products = $products->get();
        $request = [
            'total' => $this->total,
            'range' => $this->range,
            'audited' => $this->audited,
            'dateStart' => $this->dateStart,
            'dateEnd' => $this->dateEnd,
            'ranges' => $this->ranges,
            'auditedList' => $this->auditedList,
        ];
        $this->dispatchBrowserEvent('loaded');
        return view('livewire.reports.self-reports', compact('products', 'request'));
    }

    /**
     * @return ReportService
     */
    public function getReportService(): ReportService
    {
        return resolve(ReportService::class);
    }

    public function setLang()
    {
        foreach($this->ranges as $key => $th){
            $this->ths[$key] = __('text.'.$th);
        }
        foreach($this->auditedList as $key => $th){
            $this->ths[$key] = __('text.'.$th);
        }
    }

    public function filterToggle()
    {
        ($this->filter == 'none') ? $this->filter = 'block' : $this->filter = 'none';
    }

    public function resetFilters()
    {
        $this->reset(['range', 'audited', 'dateStart', 'dateEnd']);
        $this->dispatchBrowserEvent('livewire:reset-filters');
    }
}
