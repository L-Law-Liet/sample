<?php

namespace App\Http\Livewire\ProblemTypes;

use App\Models\ProblemType;
use App\Modules\Problem\Facades\ProblemTypesFacade;
use App\Modules\Problem\Requests\StoreProblemTypeRequest;
use App\Modules\Problem\Requests\UpdateProblemTypeRequest;
use Livewire\Component;

class Add extends Component
{
    public string $name = '';
    public string $description = '';
    public string $payout = '';

    //Edit
    public ?ProblemType $problemType = null;

    protected $listeners = ['problemTypeClose'];

    public function mount()
    {
        if ($this->problemType){
            $this->name = $this->problemType->name;
            $this->description = $this->problemType->description;
            $this->payout = $this->problemType->payout;
        }
    }
    /**
     * @return \string[][]
     */
    protected function rules(): array
    {

        return ($this->problemType) ? (new UpdateProblemTypeRequest())->rules() : (new StoreProblemTypeRequest())->rules();
    }

    /**
     * @return ProblemTypesFacade
     */
    public function getProblemTypesFacade(): ProblemTypesFacade
    {
        return resolve(ProblemTypesFacade::class);
    }

    public function submit()
    {
        $data = $this->validate();
        if ($this->problemType){
            $message = __('text.Updated!');
            $this->getProblemTypesFacade()->update($data, $this->problemType->id);
        }
        else {
            $message = __('text.Created!');
            $this->getProblemTypesFacade()->create($data);
            $this->emit('problemAdded');
            $this->clear();
        }
        $this->dispatchBrowserEvent('problem:created', compact('message'));
    }

    public function clear()
    {
        $this->resetValidation();
        $this->name = '';
        $this->description = '';
        $this->payout = '';
    }

    public function render()
    {
        return view('livewire.problem-types.add');
    }

    public function problemTypeClose()
    {
        $this->clear();
    }
}
