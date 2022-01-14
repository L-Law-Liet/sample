<?php


namespace App\Services;


use App\Models\ProductStatus;
use App\Models\User;
use Carbon\Carbon;

class ReportService
{
    /**
     * @param string $dateEnd
     * @param string $dateStart
     * @param int $audited
     * @param Carbon $date
     * @return mixed
     */
    public function getSelfReportProducts(string $dateEnd, string $dateStart, int $audited, Carbon $date)
    {
        $products = auth()->user()->products()
            ->with(['problem_type', 'category', 'product_status'])
            ->where('created_at', '>=', ($dateStart) ? $dateStart : $date);
        if ($dateEnd){
            $products->where('products.created_at', '<=', $dateEnd);
        }
        if ($audited){
            $products->where('products.audited', $audited-1);
        }
        return $products;
    }

    /**
     * @param string $dateEnd
     * @param string $dateStart
     * @param int $audited
     * @param Carbon $date
     * @param int $technician
     * @return mixed
     */
    public function getReport(string $dateEnd, string $dateStart, int $audited, Carbon $date, int $technician)
    {
        $report = User::active()->technicians();
        if ($technician){
            $report->where('id', $technician);
        }
        $report = $report->get()->
        map(function ($user) use ($dateEnd, $dateStart, $audited, $date){
            $name = $user->name;
            $products = $user->products()
                ->whereDate('products.created_at', '>=', ($dateStart) ? $dateStart : $date)
                    ->whereIn('product_status_id', ProductStatus::FOR_GRAPH)
                ->leftJoin('problem_types', 'problem_types.id', 'products.problem_type_id')
                ->leftJoin('product_statuses', 'product_statuses.id', 'products.product_status_id');
                if ($dateEnd){
                    $products->whereDate('products.created_at', '<=', $dateEnd);
                }
                if ($audited){
                    $products->where('audited', $audited - 1);
                };
                $products = $products->get(['product_statuses.name', 'problem_types.payout'])
                    ->groupBy('name')->map(function ($item){
                        return [
                            'count' => $item->count(),
                            'sum' => $item->sum('payout')
                        ];
                    });
                return compact('name', 'products');
        });
        return $report;
    }

    /**
     * @param int $range
     * @return Carbon
     */
    public function getRange(int $range): Carbon
    {
        if ($range == 1) {
            return now()->subMonth();
        } else if ($range == 2) {
            return now()->subYear();
        } else {
            return now()->subDay();
        }
    }
}
