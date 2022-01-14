<?php


namespace App\Http\Livewire\Traits;


trait WithThs
{
    public function setThs()
    {
        foreach($this->ths as $key => $th){
            $this->ths[$key]['name'] = __('text.'.$this->ths[$key]['name']);
        }
    }
}
