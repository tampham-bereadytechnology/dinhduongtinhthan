<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TwoCols extends Component
{
    /**
     * Create a new component instance.
     */
    public $header;
    public function __construct($header = null)
    {
        //
        $this->header = $header;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.two-cols', [
            'defaultAside' => view('aside')->render(),
        ]);
    }
}
