<?php

namespace App\View\Components\Auth;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SubHeader extends Component
{
    public $title;
    public $subTitle;

    /**
     * Create a new component instance.
     */
    public function __construct($title, $subTitle)
    {
        $this->title = $title;
        $this->subTitle = $subTitle;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.auth.sub-header');
    }
}
