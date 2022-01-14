<?php

namespace App\Http\Livewire\Products;

use App\Http\Livewire\Traits\SortBy;
use App\Http\Livewire\Traits\WithDisclaim;
use App\Http\Livewire\Traits\WithPageable;
use App\Http\Livewire\Traits\WithThs;
use App\Modules\Product\Facades\ProductsFacade;
use Livewire\Component;
use Livewire\WithPagination;

class Claimed extends Component
{
    use WithPagination;
    use WithPageable;
    use WithThs;
    use SortBy;
    use WithDisclaim;

    public array $ths = [
        'id' => ['name' => 'ID', 'class' => ''],
        'category_id' => ['name' => 'Category', 'class' => ''],
        'problem_type_id' => ['name' => 'Problem Type', 'class' => ''],
        'client_id' => ['name' => 'Client', 'class' => ''],
        'product_status_id' => ['name' => 'Status', 'class' => ''],
        'created_at' => ['name' => 'Created', 'class' => ''],
    ];

    public function mount()
    {
        $this->setThs();
        $this->setSortBy();
        $this->setPerPage();
    }

    public function render()
    {
        $products = auth()->user()->products();
        $products = $this->sorting($products);
        $products = $products->paginate($this->perPage);
        $this->dispatchBrowserEvent('loaded');
        return view('livewire.products.claimed',
            compact('products'));
    }

    /**
     * @return ProductsFacade
     */
    public function getFacade(): ProductsFacade
    {
        return resolve(ProductsFacade::class);
    }
}
