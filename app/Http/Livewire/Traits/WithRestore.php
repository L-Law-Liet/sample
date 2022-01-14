<?php


namespace App\Http\Livewire\Traits;


trait WithRestore
{

    /**
     * @param int $id
     */
    public function restore(int $id)
    {
        $this->getFacade()->restore($id);
    }
}
