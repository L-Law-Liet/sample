<?php


namespace App\Http\Livewire\Traits;


trait WithPageable
{
    public array $pages = [50, 100, 500];
    public int $perPage;

    protected $paginationTheme = 'bootstrap';

    public function updated()
    {
        $this->resetPage();
    }

    public function setPerPage()
    {
        $this->perPage = $this->pages[0];
    }
}
