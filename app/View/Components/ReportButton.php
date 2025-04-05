<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Restroom;

class ReportButton extends Component
{
    public $restroom;

    public function __construct(Restroom $restroom)
    {
        $this->restroom = $restroom;
    }

    public function render()
    {
        return view('ipoop.components.report-button');
    }
}