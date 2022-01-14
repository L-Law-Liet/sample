<?php

namespace App\Http\Livewire\Categories;

use App\Models\Category;
use App\Modules\Category\Facades\CategoriesFacade;
use App\Modules\Category\Requests\StoreCategoryRequest;
use App\Modules\Category\Requests\UpdateCategoryRequest;
use Livewire\Component;

class Add extends Component
{
    public string $name = '';

    //Edit
    public ?Category $category = null;

    protected $listeners = ['categoryClose'];

    public function mount()
    {
        if ($this->category){
            $this->name = $this->category->name;
        }
    }

    /**
     * @return \string[][]
     */
    protected function rules(): array
    {

        return ($this->category)
            ? (new UpdateCategoryRequest())->rules()
            : (new StoreCategoryRequest())->rules();
    }

    /**
     * @return CategoriesFacade
     */
    public function getFacade(): CategoriesFacade
    {
        return resolve(CategoriesFacade::class);
    }

    public function submit()
    {
        $data = $this->validate();
        if ($this->category){
            $message = __('text.Updated!');
            $this->getFacade()->update($data, $this->category->id);
        }
        else {
            $message = __('text.Created!');
            $this->getFacade()->create($data);
            $this->emit('categoryAdded');
            $this->clear();
        }
        $this->dispatchBrowserEvent('category:event', compact('message'));

    }

    public function clear()
    {
        $this->resetValidation();
        $this->name = '';
    }

    public function render()
    {
        return view('livewire.categories.add');
    }

    public function categoryClose()
    {
        $this->clear();
    }
}
