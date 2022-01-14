<?php

namespace App\Http\Livewire\ProblemTypes;

use App\Http\Livewire\BaseComponent;
use App\Modules\Problem\Facades\ProblemTypesFacade;

class Index extends BaseComponent
{

    public string $deleted = '';

    public string $idx = '';
    public string $name = '';
    public string $description = '';
    public string $payoutStart = '';
    public string $payoutEnd = '';

    protected array $toReset = ['idx', 'name', 'description', 'payoutStart', 'payoutEnd'];

    public array $ths = [
        'id' => ['name' => 'ID', 'class' => ''],
        'name' => ['name' => 'Name', 'class' => ''],
        'description' => ['name' => 'Description', 'class' => ''],
        'payout' => ['name' => 'Payout', 'class' => '']
    ];

    public function mount()
    {
        $this->setThs();
        $this->setSortBy();
        $this->setPerPage();
    }

    public function render()
    {
        $problems = $this->getFacade()->problems($this->deleted);

        $problems = $this->filter($problems, [
            ['id', $this->idx],
            ['name', $this->name, $this->LIKE],
            ['description', $this->description, $this->LIKE],
            ['payout', (int)$this->payoutStart, $this->MORE],
            ['payout', (int)$this->payoutEnd, $this->LESS],
        ]);

        $problems = $this->sorting($problems);
        $problems = $problems->paginate($this->perPage);
        $this->dispatchBrowserEvent('loaded');
        return view('livewire.problem-types.index',
            compact('problems'));
    }

    public function getFacade(): ProblemTypesFacade
    {
        return resolve(ProblemTypesFacade::class);
    }
}
