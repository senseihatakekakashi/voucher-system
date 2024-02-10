<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class VoucherCard extends Component
{
    public $key;
    public $code;
    /**
     * Create a new component instance.
     */
    public function __construct($key, $code)
    {
        $this->key = $key;
        $this->code = $code;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.voucher-card');
    }
}
