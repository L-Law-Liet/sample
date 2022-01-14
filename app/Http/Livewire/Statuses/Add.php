<?php

namespace App\Http\Livewire\Statuses;

use App\Models\ProductStatus;
use App\Modules\Status\Facades\StatusesFacade;
use App\Modules\Status\Requests\StoreStatusRequest;
use App\Modules\Status\Requests\UpdateStatusRequest;
use Livewire\Component;

class Add extends Component
{
    public string $name = '';

    //Edit
    public ?ProductStatus $productStatus = null;

    public function mount()
    {
        if ($this->productStatus){
            $this->name = $this->productStatus->name;
        }
    }

    /**
     * @return \string[][]
     */
    protected function rules(): array
    {

        return ($this->productStatus)
            ? (new UpdateStatusRequest())->rules()
            : (new StoreStatusRequest())->rules();
    }

    /**
     * @return StatusesFacade
     */
    public function getFacade(): StatusesFacade
    {
        return resolve(StatusesFacade::class);
    }

    public function submit()
    {
        $data = $this->validate();
        if ($this->productStatus){
            $message = __('text.Updated!');
            $this->getFacade()->update($data, $this->productStatus->id);
        }
        else {
            $message = __('text.Created!');
            $this->getFacade()->create($data);
            $this->emit('productStatusAdded');
            $this->clear();
        }
        $this->dispatchBrowserEvent('productStatus:event', compact('message'));

    }

    public function clear()
    {
        $this->resetValidation();
        $this->name = '';
    }

    public function render()
    {
        return view('livewire.statuses.add');
    }
}
