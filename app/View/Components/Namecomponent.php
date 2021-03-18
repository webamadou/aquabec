<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Namecomponent extends Component
{
    public $publicationTitle;
    public $item;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($publicationTitle,$item)
    {
        $this->publicationTitle = $publicationTitle;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.namecomponent');
    }
}
