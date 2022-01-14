<?php

namespace App\Http\Livewire\Reports;

use App\Models\Product;
use App\Models\ProductStatus;
use App\Models\User;
use App\Services\ChartService;
use App\Services\ReportService;
use Carbon\Carbon;
use Livewire\Component;

class Index extends Component
{
    public array $ths = ['Technicians'];
    public string $filter = 'none';

    public array $ranges = ['Daily', 'Monthly', 'Yearly'];
    public int $range = 2;

    public array $auditedList = ['Both', 'No', 'Yes'];
    public int $audited = 0;

    public string $dateStart = '';
    public string $dateEnd = '';

    public array $technicians = [];
    public int $technician = 0;

    public function mount()
    {
        foreach (ProductStatus::report()->pluck('name') as $th){
            $this->ths[] = $th;
        }
        $this->ths[] = 'Total payout';

        $this->setLang();

        $this->technicians = User::active()->technicians()->pluck('name', 'id')->toArray();
    }

    public function render()
    {
        $date = $this->getReportService()->getRange($this->range);
        $users = $this->getReportService()->getReport($this->dateEnd, $this->dateStart, $this->audited, $date, $this->technician);
        // report
        $request = [
            'ths' => $this->ths,
            'range' => $this->range,
            'audited' => $this->audited,
            'dateStart' => $this->dateStart,
            'dateEnd' => $this->dateEnd,
            'ranges' => $this->ranges,
            'auditedList' => $this->auditedList,
            'technicians' => $this->technicians,
            'technician' => $this->technician,
        ];
        $this->dispatchBrowserEvent('loaded');
        return view('livewire.reports.index',
            compact('users', 'request'));
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

        $this->ths[0] = __('text.'.$this->ths[0]);
        $this->ths[count($this->ths)-1] = __('text.'.$this->ths[count($this->ths)-1]);

        foreach($this->ranges as $key => $th){
            $this->ranges[$key] = __('text.'.$th);
        }
        foreach($this->auditedList as $key => $th){
            $this->auditedList[$key] = __('text.'.$th);
        }
    }

    public function filterToggle()
    {
        ($this->filter == 'none') ? $this->filter = 'block' : $this->filter = 'none';
    }

    public function resetFilters()
    {
        $this->reset(['range', 'audited', 'dateStart', 'dateEnd', 'technician']);
        $this->dispatchBrowserEvent('livewire:reset-filters');
    }
}
