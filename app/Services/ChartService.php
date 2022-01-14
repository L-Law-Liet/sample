<?php


namespace App\Services;

use App\Classes\Chart;
use App\Classes\Dataset;
use App\Models\ProductStatus;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

class ChartService
{
    public function getLineChart(string $format)
    {
        $res = $this->getProductStatuses($format);
        if ($format == 'd.m') {
            $period = now()->subMonth()->daysUntil(now());
        } else {
            $period = now()->subYear()->monthsUntil(now());
        }

        $labels = [];
        foreach ($period as $date)
            $labels[] = $date->format($format);

        $chart = new Chart();
        $chart->labels = $labels;

        foreach ($res as $r) {
            $dataset = new Dataset();
            $dataset->label = $r['key'];
            $dataset->borderColor = $r['color'];
            foreach ($labels as $label) {
                $dataset->data[] = count($r['value'][$label] ?? []);
            }
            $chart->dataset[] = $dataset;
        }
        return json_encode($chart);
    }

    public function getPieChart()
    {
        $users = $this->getTechniciansWithProducts();

        $labels = $users->pluck('name')->toArray();

        $chart = new Chart();
        $chart->labels = $labels;

        $dataset = new Dataset();
        $dataset->label = __('text. % of items repaired for each technician');
//        $sum = $users->sum('repaired_products_count');
//        foreach ($users as $user){
//            $dataset->data[] = round($user->repaired_products_count/$sum*100, 2) . '%';
//        }
        $dataset->data = $users->pluck('repaired_products_count')->toArray();

        foreach ($users as $user) {
            $color = $this->randomColor();
            $dataset->borderColor[] = $color;
            $dataset->backgroundColor[] = $color;
        }
        $chart->dataset = [$dataset];
        return json_encode($chart);
    }

    /**
     * @param string $format
     * @return mixed
     */
    public function getProductStatuses(string $format)
    {
        return ProductStatus::report()->get(['name', 'color', 'id'])
            ->map(function ($status) use ($format) {
                return $this->groupByProductCreatedAt($status, $format);
            });
    }

    /**
     * @param ProductStatus $status
     * @param string $format
     * @return array
     */
    public function groupByProductCreatedAt(ProductStatus $status, string $format): array
    {
        return ['key' => $status->name,
            'value' => $this->getProductsWithStatus($status, $format)
                ->groupBy(function ($val) use ($format) {
                    return Carbon::parse($val->created_at)->format($format);
                }),
            'color' => $status->color];
    }

    /**
     * @param ProductStatus $status
     * @param string $format
     * @return Collection
     */
    public function getProductsWithStatus(ProductStatus $status, string $format): Collection
    {
        return $status->products()
            ->select('products.created_at')
            ->whereDate('products.created_at', '>', ($format == 'd.m') ? now()->subMonth() : now()->subYear())
            ->leftJoin('product_statuses', 'product_statuses.id', 'products.product_status_id')
            ->orderBy('products.created_at')
            ->get();
    }

    public function getTechniciansWithProducts()
    {
        return User::technicians()->active()->withCount('products')->withCount('repairedProducts')
            ->get();
    }

    /**
     * @return string
     */
    public function randomColorPart(): string
    {
        return str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT);
    }

    /**
     * @return string
     */
    public function randomColor(): string
    {
        return '#' . $this->randomColorPart() . $this->randomColorPart() . $this->randomColorPart();
    }
}
