<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Alerts extends Component
{
    public $type;
    public $message;

    /**
     * Create a new component instance.
     *
     * @param string $type
     * @param string $message
     */
    public function __construct($type = 'info', $message = '')
    {
        $this->type = $type;
        $this->message = $message;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('layouts.alerts');
    }
}