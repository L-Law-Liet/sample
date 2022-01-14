<?php


namespace App\Http\Livewire\Traits;


trait SortBy
{
    public string $sortBy = '';

    public function sort(string $key)
    {
        foreach ($this->ths as $k => $th) {
            if ($k != $key)
                $this->ths[$k]['class'] = '';
        }
        ($this->ths[$key]['class'] == 'sorting_asc text-primary')
            ? $this->ths[$key]['class'] = 'sorting_desc '
            : $this->ths[$key]['class'] = 'sorting_asc ';
        $this->ths[$key]['class'] .= 'text-primary';
        $this->dispatchBrowserEvent('livewire:sorted', [$key => $this->ths[$key]]);
    }

    public function setSortBy()
    {
        if ($this->sortBy){
            $sortBy = json_decode($this->sortBy, 1);
            if ($sortBy){
                $key = key($sortBy);
                if (key_exists($key, $this->ths)){
                    $this->ths[$key]['class'] = $sortBy[$key]['class'];
                }
            }
        }
    }

    /**
     * @param $items
     * @return mixed
     */
    public function sorting($items)
    {
        foreach ($this->ths as $key => $th){
            if ($th['class']){
                if (strpos($th['class'], 'desc') !== false){
                    $items = $items->orderByDesc($key);
                }
                else if(strpos($th['class'], 'asc') !== false) {
                    $items = $items->orderBy($key);
                }
                $this->dispatchBrowserEvent('livewire:sorted', [$key => $this->ths[$key]]);
                break;
            }
        }
        return $items;
    }
}
