<?php

namespace App\Http\Livewire\Statuses;

use App\Http\Livewire\BaseComponent;
use App\Modules\Status\Facades\StatusesFacade;

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
        $statuses = $this->getFacade()->statuses($this->deleted);

        $statuses = $this->filter($statuses, [
            ['id', $this->idx],
            ['name', $this->name, $this->LIKE],
        ]);
        $statuses = $this->sorting($statuses);
        $statuses = $statuses->paginate($this->perPage);
        $this->dispatchBrowserEvent('loaded');
        return view('livewire.statuses.index',
            compact('statuses'));
    }

    /**
     * @return StatusesFacade
     */
    public function getFacade(): StatusesFacade
    {
        return resolve(StatusesFacade::class);
    }
}
