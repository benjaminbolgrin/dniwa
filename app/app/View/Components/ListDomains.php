<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ListDomains extends Component
{
	public $domains;
    /**
     * Create a new component instance.
     */
    public function __construct($domains)
    {
	$this->domains = $domains;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.list-domains');
    }
}
