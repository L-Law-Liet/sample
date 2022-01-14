<?php


namespace App\Http\Livewire\Traits;


trait WithDelete
{

    /**
     * @param $id
     */
    public function delete($id)
    {
        $this->getFacade()->delete($id);
        $this->resetPage();
    }
}
