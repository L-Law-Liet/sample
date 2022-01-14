<?php


namespace App\Http\Livewire;


use App\Http\Livewire\Traits\SortBy;
use App\Http\Livewire\Traits\WithDelete;
use App\Http\Livewire\Traits\WithFiltering;
use App\Http\Livewire\Traits\WithPageable;
use App\Http\Livewire\Traits\WithRestore;
use App\Http\Livewire\Traits\WithThs;
use Livewire\Component;
use Livewire\WithPagination;

class BaseComponent extends Component
{
    use WithPagination;
    use SortBy;
    use WithFiltering;
    use WithDelete;
    use WithRestore;
    use WithPageable;
    use WithThs;
}
