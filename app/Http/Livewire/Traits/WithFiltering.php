<?php


namespace App\Http\Livewire\Traits;


trait WithFiltering
{
    protected int $LIKE = 1;
    protected int $MORE = 2;
    protected int $LESS = 3;
    protected int $CHECKBOX = 4;

    protected array $toReset;

    public string $filter = 'none';

    public function filter($q, array $filters)
    {
        foreach ($filters as $filter) {
            $key = $filter[0];
            $val = $filter[1];
            $type = $filter[2] ?? 0;
            if ($val) {
                if (count($filter) > 2) {
                    switch ($type){
                        case $this->LIKE:
                            $q->where($key, 'like', '%' . $val . '%');
                            break;
                        case $this->MORE:
                            $q->where($key, '>=', $val);
                            break;
                        case $this->LESS:
                            $q->where($key, '<=', $val);
                            break;
                        case $this->CHECKBOX:
                            $q->where($key, $val - 1);
                            break;
                    }
                } else {
                    $q->where($key, $val);
                }
            }
        }
        return $q;
    }

    public function filterToggle()
    {
        ($this->filter == 'none') ? $this->filter = 'block' : $this->filter = 'none';
    }

    public function resetFilters()
    {
        $this->reset($this->toReset);
        $this->dispatchBrowserEvent('livewire:reset-filters');
    }
}
