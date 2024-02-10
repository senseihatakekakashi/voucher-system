<?php

namespace App\View\Components\Admin;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SideBarItem extends Component
{
    public $state;
    public $uri;
    public $icon;
    public $item;
    /**
     * Create a new component instance.
     */
    public function __construct($state, $uri, $icon, $item)
    {
        $this->state = $state;
        $this->uri = $uri;
        $this->icon = $icon;
        $this->item = $item;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin.side-bar-item');
    }
}
