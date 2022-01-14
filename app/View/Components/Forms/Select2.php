<?php

namespace App\View\Components\forms;

use Illuminate\View\Component;

class Select2 extends Component
{
    public $name;
    public $label;
    public $value;
    public $items;

    /**
     * Select2 constructor.
     * @param $name
     * @param $label
     * @param $value
     * @param $items
     */
    public function __construct($name, $label, $value, $items)
    {
        $this->name = $name;
        $this->label = $label;
        $this->value = $value;
        $this->items = $items;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.forms.select2');
    }
}
