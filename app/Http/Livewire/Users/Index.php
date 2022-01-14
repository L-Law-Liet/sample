<?php

namespace App\Http\Livewire\Users;

use App\Http\Livewire\BaseComponent;
use App\Modules\Admin\Facades\UsersFacade;

class Index extends BaseComponent
{

    public string $deleted = '';

    public string $idx = '';
    public string $name = '';
    public string $email = '';
    public string $dateStart = '';
    public string $dateEnd = '';
    public int $status = 0;

    public array $statuses = ['Both', 'Not Active', 'Active'];

    protected array $toReset = ['idx', 'name', 'email', 'dateStart', 'dateEnd'];

    public array $ths = [
        'id' => ['name' => 'ID', 'class' => ''],
        'name' => ['name' => 'Name', 'class' => ''],
        'email' => ['name' => 'Email', 'class' => ''],
        'created_at' => ['name' => 'Created', 'class' => ''],
        'is_active' => ['name' => 'Status', 'class' => '']
    ];

    public function mount()
    {
        $this->setThs();
        $this->setSortBy();
        $this->setPerPage();
    }

    public function render()
    {
        $technicians = $this->getFacade()->technicians($this->deleted);
        $technicians = $this->filter($technicians, [
            ['id', $this->idx],
            ['name', $this->name, $this->LIKE],
            ['email', $this->email, $this->LIKE],
            ['created_at', $this->dateStart, $this->MORE],
            ['created_at', $this->dateEnd, $this->LESS],
            ['is_active', $this->status, $this->CHECKBOX],
        ]);

       $technicians = $this->sorting($technicians);
        $technicians = $technicians->paginate($this->perPage);
        $this->dispatchBrowserEvent('loaded');
        return view('livewire.users.index', compact('technicians'));
    }

    /**
     * @return UsersFacade
     */
    public function getFacade(): UsersFacade
    {
        return resolve(UsersFacade::class);
    }
}
