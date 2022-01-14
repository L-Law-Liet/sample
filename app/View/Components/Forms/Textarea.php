<?php

namespace App\View\Components\forms;

use Illuminate\View\Component;

class Textarea extends Component
{
    public string $label;
    public string $name;
    public string $value;

    /**
     * Textarea constructor.
     * @param string $label
     * @param string $name
     * @param string $value
     */
    public function __construct(string $label, string $name, string $value)
    {
        $this->label = $label;
        $this->name = $name;
        $this->value = $value;
    }


    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.forms.textarea');
    }
}
