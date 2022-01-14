<?php

namespace App\Http\Livewire\Clients;

use App\Http\Livewire\BaseComponent;
use App\Modules\Client\Facades\ClientsFacade;

class Index extends BaseComponent
{

    public string $deleted = '';

    public string $idx = '';
    public string $name = '';
    public string $email = '';
    public string $phone = '';
    public string $address = '';
    public int $type = 0;

    protected array $toReset = ['idx', 'name', 'email', 'phone', 'address'];

    public array $types = ['Both', 'External', 'Internal'];

    public array $ths = [
        'id' => ['name' => 'ID', 'class' => ''],
        'name' => ['name' => 'Name', 'class' => ''],
        'email' => ['name' => 'Email', 'class' => ''],
        'phone' => ['name' => 'Phone', 'class' => ''],
        'address' => ['name' => 'Address', 'class' => ''],
        'internal' => ['name' => 'Type', 'class' => ''],
    ];

    public function mount()
    {
        $this->setThs();
        $this->setSortBy();
        $this->setPerPage();
    }

    public function render()
    {
        $clients = $this->getFacade()->clients($this->deleted);

        $clients = $this->filter($clients, [
            ['id', $this->idx],
            ['name', $this->name, $this->LIKE],
            ['email', $this->email, $this->LIKE],
            ['phone', $this->phone, $this->LIKE],
            ['address', $this->address, $this->LIKE],
            ['internal', $this->type, $this->CHECKBOX],
        ]);
        $clients = $this->sorting($clients);
        $clients = $clients->paginate($this->perPage);
        $this->dispatchBrowserEvent('loaded');
        return view('livewire.clients.index',
            compact('clients'));
    }

    /**
     * @return ClientsFacade
     */
    public function getFacade(): ClientsFacade
    {
        return resolve(ClientsFacade::class);
    }
}
