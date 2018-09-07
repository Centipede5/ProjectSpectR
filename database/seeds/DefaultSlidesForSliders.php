<?php

use Illuminate\Database\Seeder;
use App\Slider;

class DefaultSlidesForSliders extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $slide1 = Slider::create([
            'slider_slug' => 'home-page',
            'slide_title' => 'Shadow of the Tomb Raider',
            'slide_description' => 'Experience Lara Croft’s defining moment as she becomes the Tomb Raider.',
            'button_text' => 'MORE',
            'button_link' => '/img/sliders/slider-01-Shadow-of-the-Tomb-Raider.jpg',
            'image' => '/img/sliders/slider-01-Shadow-of-the-Tomb-Raider.jpg',
            'order' => '1',
            'active' => '1',
            'start_date' => '2018-08-01 02:00:00',
            'end_date' => '2025-08-01 02:00:00'
        ]);

        $slide2 = Slider::create([
            'slider_slug' => 'home-page',
            'slide_title' => 'Ghost of Tsushima',
            'slide_description' => 'In 1274, the fearsome Mongol Empire invades the Japanese island of Tsushima and slaughters its legendary samurai defenders. ',
            'button_text' => 'MORE',
            'button_link' => '/img/sliders/slider-07-Ghost-of-Tsushima.jpg',
            'image' => '/img/sliders/slider-07-Ghost-of-Tsushima.jpg',
            'order' => '1',
            'active' => '1',
            'start_date' => '2018-08-01 02:00:00',
            'end_date' => '2025-08-01 02:00:00'
        ]);

        $slide3 = Slider::create([
            'slider_slug' => 'home-page',
            'slide_title' => 'Spider-Man',
            'slide_description' => 'When a new villain threatens New York City, Peter Parker and Spider-Man’s worlds collide. To save the city and those he loves, he must rise up and be greater.',
            'button_text' => 'MORE',
            'button_link' => '/img/sliders/slider-08-Spider-Man.jpg',
            'image' => '/img/sliders/slider-08-Spider-Man.jpg',
            'order' => '1',
            'active' => '1',
            'start_date' => '2018-08-01 02:00:00',
            'end_date' => '2025-08-01 02:00:00'
        ]);
    }
}
