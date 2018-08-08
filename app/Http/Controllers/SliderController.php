<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Slider;
use Symfony\Component\HttpKernel\EventListener\SessionListener;

class SliderController extends Controller
{
    public function getSlider ($sliderSlug = 'home-page') {

        $currentDateTime = date('Y-m-d G:i:s');
        $slides = Slider::where('slider_slug', $sliderSlug)
            ->where('active',1)
            ->where('end_date', '>', $currentDateTime)
            ->orderBy('order')
            ->take(10)
            ->get();

        return $slides;
    }
}
