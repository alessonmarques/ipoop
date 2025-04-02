<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class Map extends Component
{
    public $lat, $lng, $zoom, $height, $width;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($lat = -22.8742, $lng = -43.4686, $zoom = 13, $height = '90vh', $width = NULL)
    {
        $this->lat = $lat;
        $this->lng = $lng;
        $this->zoom = $zoom;
        $this->height = $height;
        $this->width = $width;
    }

     /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return view('ipoop.components.map');
    }
}