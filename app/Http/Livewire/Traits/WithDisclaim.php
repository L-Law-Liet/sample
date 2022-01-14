<?php


namespace App\Http\Livewire\Traits;


trait WithDisclaim
{
    /**
     * @param int $id
     */
    public function disclaim(int $id)
    {
        $this->getFacade()->disclaim($id);
    }
}
