<?php

namespace App\Http\Livewire\Products;

use App\Http\Livewire\BaseComponent;
use App\Http\Livewire\Traits\WithDisclaim;
use App\Modules\Category\Facades\CategoriesFacade;
use App\Modules\Client\Facades\ClientsFacade;
use App\Modules\Problem\Facades\ProblemTypesFacade;
use App\Modules\Product\Facades\ProductsFacade;
use App\Modules\Status\Facades\StatusesFacade;

class Index extends BaseComponent
{
    use WithDisclaim;

    public string $idx = '';
    public int $productStatusId = 0;
    public int $categoryId = 0;
    public int $problemTypeId = 0;
    public int $clientId = 0;

    public string $deleted = '';

    public array $problems = [];
    public array $clients = [];
    public array $categories = [];
    public array $statuses = [];

    protected array $toReset = ['idx', 'clientId', 'categoryId', 'problemTypeId', 'productStatusId'];

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
        $this->setAll();
    }

    public function render()
    {
        $products = $this->getFacade()->productsWithRelations($this->deleted);
        $products = $this->filter($products, [
            ['id', $this->idx],
            ['category_id', $this->categoryId],
            ['problem_type_id', $this->problemTypeId],
            ['client_id', $this->clientId],
            ['product_status_id', $this->productStatusId],
        ]);
        $products = $this->sorting($products);
        $products = $products->paginate($this->perPage);
        $this->dispatchBrowserEvent('loaded');
        return view('livewire.products.index',
            compact('products'));
    }

    public function getFacade(): ProductsFacade
    {
        return resolve(ProductsFacade::class);
    }

    public function claim(int $id)
    {
        $this->getFacade()->claim($id);
    }

    public function setAll()
    {
        $this->setCategories();
        $this->setClients();
        $this->setProblems();
        $this->setStatuses();
    }

    public function setProblems()
    {
        $this->problems = $this->getProblemTypesFacade()->getAll()->pluck('name', 'id')->toArray();
    }

    public function setCategories()
    {
        $this->categories = $this->getCategoriesFacade()->getAll()->pluck('name', 'id')->toArray();
    }

    public function setStatuses()
    {
        $this->statuses = $this->getStatusesFacade()->getAll()->pluck('name', 'id')->toArray();
    }

    public function setClients()
    {
        $this->clients = $this->getClientsFacade()->getAll()->pluck('name', 'id')->toArray();
    }

    /**
     * @return ClientsFacade
     */
    public function getClientsFacade(): ClientsFacade
    {
        return resolve(ClientsFacade::class);
    }

    /**
     * @return CategoriesFacade
     */
    public function getCategoriesFacade(): CategoriesFacade
    {
        return resolve(CategoriesFacade::class);
    }

    /**
     * @return StatusesFacade
     */
    public function getStatusesFacade(): StatusesFacade
    {
        return resolve(StatusesFacade::class);
    }

    /**
     * @return ProblemTypesFacade
     */
    public function getProblemTypesFacade(): ProblemTypesFacade
    {
        return resolve(ProblemTypesFacade::class);
    }
}
