<?php

namespace App\Http\Livewire\Categories;

use App\Http\Livewire\BaseComponent;
use App\Modules\Category\Facades\CategoriesFacade;

class Index extends BaseComponent
{

    public string $deleted = '';
    public string $idx = '';
    public string $name = '';

    protected array $toReset = ['idx', 'name'];

    public array $ths = [
        'id' => ['name' => 'ID', 'class' => ''],
        'name' => ['name' => 'Name', 'class' => ''],
    ];

    public function mount()
    {
        $this->setThs();
        $this->setSortBy();
        $this->setPerPage();
    }

    public function render()
    {
        $categories = $this->getFacade()->categories($this->deleted);

        $categories = $this->filter($categories, [
            ['id', $this->idx],
            ['name', $this->name, $this->LIKE],
        ]);

        $categories = $this->sorting($categories);
        $categories = $categories->paginate($this->perPage);
        $this->dispatchBrowserEvent('loaded');
        return view('livewire.categories.index',
            compact('categories'));
    }

    /**
     * @return CategoriesFacade
     */
    public function getFacade(): CategoriesFacade
    {
        return resolve(CategoriesFacade::class);
    }
}
