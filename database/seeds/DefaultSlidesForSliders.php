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
            'slide_title' => 'Uncharted: The Lost Legacy',
            'slide_description' => 'Uncharted: The Lost Legacy is the first standalone adventure in Uncharted franchise history.',
            'button_text' => 'Watch Gameplay',
            'button_link' => 'https://img.youtube.com/vi/K5tRSwd-Sc0/maxresdefault.jpg',
            'image' => 'https://img.youtube.com/vi/K5tRSwd-Sc0/maxresdefault.jpg',
            'order' => '1',
            'active' => '1',
            'start_date' => '2018-08-01 02:00:00',
            'end_date' => '2025-08-01 02:00:00'
        ]);

        $slide2 = Slider::create([
            'slider_slug' => 'home-page',
            'slide_title' => 'The Witcher 3: Blood and Wine',
            'slide_description' => 'The world is in chaos. The air is thick with tension and the smoke of burnt villages.',
            'button_text' => 'Watch Gameplay',
            'button_link' => '/img/carousel/carousel-2.jpg',
            'image' => '/img/carousel/carousel-1.jpg',
            'order' => '1',
            'active' => '1',
            'start_date' => '2018-08-01 02:00:00',
            'end_date' => '2025-08-01 02:00:00'
        ]);

        $slide3 = Slider::create([
            'slider_slug' => 'home-page',
            'slide_title' => 'The Last of Us: Remastered',
            'slide_description' => 'Survive an apocalypse on Earth in The Last of Us, a PlayStation 4-exclusive title.',
            'button_text' => 'Watch Gameplay',
            'button_link' => '/img/carousel/carousel-2.jpg',
            'image' => '/img/carousel/carousel-2.jpg',
            'order' => '1',
            'active' => '1',
            'start_date' => '2018-08-01 02:00:00',
            'end_date' => '2025-08-01 02:00:00'
        ]);
    }
}
