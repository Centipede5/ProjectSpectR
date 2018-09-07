<?php

use Illuminate\Database\Seeder;
use App\Game;

class GameTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $game1 = Game::create([
            'slug'  => 'spider-man-ps4',
            'title' => 'Marvel\'s Spider-Man',
            'publisher' => 'Sony Interactive Entertainment',
            'developer' => 'Insomniac Games',
            'platforms' => 'PS4',
            'release_date_na' => '2018-09-07',
            'release_date_jp' => '2018-09-07',
            'release_date_eu' => '2018-09-07',
            'synopsis' => 'When a new villain threatens New York City, Peter Parker and Spider-Man’s worlds collide. To save the city and those he loves, he must rise up and be greater.',
            'summary'  => ''
        ]);
        $game2 = Game::create([
            'slug'  => 'shadow-of-the-tomb-raider',
            'title' => 'Shadow of the Tomb Raider',
            'publisher' => 'Square Enix',
            'developer' => 'Eidos Montreal',
            'platforms' => "{'PS4','Xbox','PC'}",
            'release_date_na' => '2018-09-14',
            'release_date_jp' => '2018-09-14',
            'release_date_eu' => '2018-09-14',
            'synopsis' => 'Experience Lara Croft’s defining moment as she becomes the Tomb Raider. Lara must master a deadly jungle and persevere through her darkest hour.',
            'summary'  => ''
        ]);
        $game3 = Game::create([
            'slug'  => 'mega-man-11',
            'title' => 'Mega Man 11',
            'publisher' => 'Capcom',
            'developer' => 'Capcom',
            'platforms' => "{'PS4','Xbox','Switch','PC'}",
            'release_date_na' => '2018-10-02',
            'release_date_jp' => '2018-10-04',
            'release_date_eu' => '2018-10-02',
            'synopsis' => 'The Blue Bomber is Back! The newest entry in this iconic series blends classic, challenging 2D platforming action with a fresh look.',
            'summary'  => ''
        ]);
        $game4 = Game::create([
            'slug'  => 'super-mario-party',
            'title' => 'Super Mario Party',
            'publisher' => 'Nintendo',
            'developer' => 'ND Cube',
            'platforms' => 'Switch',
            'release_date_na' => '2018-10-05',
            'release_date_jp' => '2018-10-05',
            'release_date_eu' => '2018-10-05',
            'synopsis' => 'The Mario Party series is coming to the Nintendo Switch system with super-charged fun for everyone! The original board game style has been kicked up a notch with deeper strategic elements.',
            'summary'  => ''
        ]);
        $game6 = Game::create([
            'slug'  => 'assassins-creed-odyssey',
            'title' => 'Assassin\'s Creed Odyssey',
            'publisher' => 'Ubisoft',
            'developer' => 'Ubisoft Quebec',
            'platforms' => "{'PS4','Xbox','PC'}",
            'release_date_na' => '2018-10-05',
            'release_date_jp' => '2018-10-05',
            'release_date_eu' => '2018-10-05',
            'synopsis' => 'Write your own epic odyssey and become a legendary Spartan hero in Assassin\'s Creed® Odyssey, an inspiring adventure where you must forge your destiny and define your own path in a world on the brink of tearing itself apart.',
            'summary'  => ''
        ]);
        $game7 = Game::create([
            'slug'  => 'cod-black-ops-4',
            'title' => 'CoD: Black Ops 4',
            'publisher' => 'Activision',
            'developer' => 'Treyarch',
            'platforms' => "{'PS4','Xbox','PC'}",
            'release_date_na' => '2018-10-12',
            'release_date_jp' => '2018-10-12',
            'release_date_eu' => '2018-10-12',
            'synopsis' => 'Featuring gritty, grounded, fluid Multiplayer combat, the biggest Zombies offering ever with three full undead adventures at launch, and Blackout.',
            'summary'  => ''
        ]);
        $game8 = Game::create([
            'slug'  => 'soulcalibur-6',
            'title' => 'Soulcalibur 6',
            'publisher' => 'Bandai Namco Entertainment',
            'developer' => 'Project Soul',
            'platforms' => "{'PS4','Xbox','PC'}",
            'release_date_na' => '2018-10-19',
            'release_date_jp' => '2018-10-19',
            'release_date_eu' => '2018-10-19',
            'synopsis' => 'Soulcalibur VI represents the latest entry in the premier weapons-based, head-to-head fighting series and continues the epic struggle of warriors searching for the legendary Soul Swords.',
            'summary'  => ''
        ]);
        $game9 = Game::create([
            'slug'  => 'red-dead-redemption-2',
            'title' => 'Red Dead Redemption 2',
            'publisher' => 'Rockstar Games',
            'developer' => 'Rockstar Studios',
            'platforms' => "{'PS4','Xbox'}",
            'release_date_na' => '2018-10-26',
            'release_date_jp' => '2018-10-26',
            'release_date_eu' => '2018-10-26',
            'synopsis' => 'America, 1899. The end of the Wild West era has begun. After a robbery goes badly wrong in the western town of Blackwater, Arthur Morgan and the Van der Linde gang are forced to flee.',
            'summary'  => 'America, 1899. The end of the Wild West era has begun. After a robbery goes badly wrong in the western town of Blackwater, Arthur Morgan and the Van der Linde gang are forced to flee. With federal agents and the best bounty hunters in the nation massing on their heels, the gang must rob, steal and fight their way across the rugged heartland of America in order to survive. As deepening internal divisions threaten to tear the gang apart, Arthur must make a choice between his own ideals and loyalty to the gang who raised him.'
        ]);
        $game10 = Game::create([
            'slug'  => 'fallout-76',
            'title' => 'Fallout 76',
            'publisher' => 'Bethesda Softworks',
            'developer' => 'Bethesda Game Studios',
            'platforms' => "{'PS4','Xbox','PC'}",
            'release_date_na' => '2018-11-14',
            'release_date_jp' => '2018-11-14',
            'release_date_eu' => '2018-11-14',
            'synopsis' => 'Work together, or not, to survive. Under the threat of nuclear annihilation, you’ll experience the largest, most dynamic world ever created in the legendary Fallout universe.',
            'summary'  => 'Work together, or not, to survive. Under the threat of nuclear annihilation, you’ll experience the largest, most dynamic world ever created in the legendary Fallout universe.'
        ]);
        $game11 = Game::create([
            'slug'  => 'battlefield-5',
            'title' => 'Battlefield V',
            'publisher' => 'Electronic Arts',
            'developer' => 'EA Dice',
            'platforms' => "{'PS4','Xbox','PC'}",
            'release_date_na' => '2018-11-14',
            'release_date_jp' => '2018-11-14',
            'release_date_eu' => '2018-11-14',
            'synopsis' => 'The most intense, immersive Battlefield yet. Every battle is different. Every soldier is unique. Every story is untold.',
            'summary'  => 'The most intense, immersive Battlefield yet. Every battle is different. Every soldier is unique. Every story is untold. Find out everything you want to know about Battlefield V\'s maps, modes, and exciting new details on single-player and multiplayer. '
        ]);
    }
}
