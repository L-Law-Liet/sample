<?php

namespace App\Http\Livewire\Clients;

use App\Models\Client;
use App\Modules\Client\Facades\ClientsFacade;
use App\Modules\Client\Requests\StoreClientRequest;
use App\Modules\Client\Requests\UpdateClientRequest;
use Livewire\Component;

class Add extends Component
{
    public string $name = '';
    public string $email = '';
    public string $phone = '';
    public string $address = '';
    public bool $internal = false;

    //Edit
    public ?Client $client = null;

    protected $listeners = ['clientClose'];
    public function mount()
    {
        if ($this->client){
            $this->name = $this->client->name;
            $this->email = $this->client->email;
            $this->phone = $this->client->phone;
            $this->address = $this->client->address;
            $this->internal = $this->client->internal;
        }
    }

    /**
     * @return \string[][]
     */
    protected function rules(): array
    {

        return ($this->client)
            ? (new UpdateClientRequest())->rules()
            : (new StoreClientRequest())->rules();
    }

    /**
     * @return ClientsFacade
     */
    public function getFacade(): ClientsFacade
    {
        return resolve(ClientsFacade::class);
    }

    public function submit()
    {
        $data = $this->validate();
        if ($this->client){
            $message = __('text.Updated!');
            $this->getFacade()->update($data, $this->client->id);
        }
        else {
            $message = __('text.Created!');
            $this->getFacade()->create($data);
            $this->emit('clientAdded');
            $this->clear();
        }
        $this->dispatchBrowserEvent('client:event', compact('message'));

    }

    public function clear()
    {
        $this->resetValidation();
        $this->name = '';
        $this->email = '';
        $this->phone = '';
        $this->address = '';
        $this->internal = false;
    }

    public function render()
    {
        return view('livewire.clients.add');
    }

    public function clientClose()
    {
        $this->clear();
    }
}
