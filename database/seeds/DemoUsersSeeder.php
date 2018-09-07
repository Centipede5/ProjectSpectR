<?php

use Illuminate\Database\Seeder;
use App\User;

class DemoUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user1 = User::create([
            'name' => 'Pending User',
            'display_name' => 'PENDING',
            'email' => 'pending@example.com',
            'password' => bcrypt('pending123'),
            'uniqid' => '..5b5b40fa8b4b1',
            'profile_image' => '00-default-avatar.jpg',
            'background_image' => '00-default-canopy.jpg'
        ]);
        $user2 = User::create([
            'name' => 'Basic User',
            'display_name' => 'BASIC',
            'email' => 'basic@example.com',
            'password' => bcrypt('basic123'),
            'uniqid' => '..5b5b40fa8b4b2',
            'profile_image' => '00-default-avatar.jpg',
            'background_image' => '00-default-canopy.jpg'
        ]);
        $user3 = User::create([
            'name' => 'Contributor User',
            'display_name' => 'CONTRIBUTOR',
            'email' => 'contributor@example.com',
            'password' => bcrypt('contributor123'),
            'uniqid' => '..5b5b40fa8b4b3',
            'profile_image' => '00-default-avatar.jpg',
            'background_image' => '00-default-canopy.jpg'
        ]);
        $user4 = User::create([
            'name' => 'Author User',
            'display_name' => 'AUTHOR',
            'email' => 'author@example.com',
            'password' => bcrypt('author123'),
            'uniqid' => '..5b5b40fa8b4b4',
            'profile_image' => '00-default-avatar.jpg',
            'background_image' => '00-default-canopy.jpg'
        ]);
        $user5 = User::create([
            'name' => 'Editor User',
            'display_name' => 'EDITOR',
            'email' => 'editor@example.com',
            'password' => bcrypt('editor123'),
            'uniqid' => '..5b5b40fa8b4b5',
            'profile_image' => '00-default-avatar.jpg',
            'background_image' => '00-default-canopy.jpg'
        ]);
        $user6 = User::create([
            'name' => 'Admin User',
            'display_name' => 'ADMIN',
            'email' => 'admin@example.com',
            'password' => bcrypt('admin123'),
            'uniqid' => '..5b5b40fa8b4b6',
            'profile_image' => '00-default-avatar.jpg',
            'background_image' => '00-default-canopy.jpg'
        ]);
        $user7 = User::create([
            'name' => 'Super User',
            'display_name' => 'SUPER',
            'email' => 'super@example.com',
            'password' => bcrypt('super123'),
            'uniqid' => '..5b5b40fa8b4b7',
            'profile_image' => '00-default-avatar.jpg',
            'background_image' => '00-default-canopy.jpg'
        ]);
        $user8 = User::create([
            'name' => 'Marcus Fenix',
            'display_name' => 'MarcusFenix',
            'email' => 'marc@this.com',
            'password' => bcrypt('Avi123?'),
            'uniqid' => '..5b5f1716e80568',
            'profile_image' => '00-default-avatar.jpg',
            'background_image' => '00-default-canopy.jpg'
        ]);
        $user9 = User::create([
            'name' => 'Leon Kennedy',
            'display_name' => 'LeonKennedy',
            'email' => 'leon@this.com',
            'password' => bcrypt('Avi123?'),
            'uniqid' => '..5b5f1716e806c9',
            'profile_image' => '00-default-avatar.jpg',
            'background_image' => '00-default-canopy.jpg'
        ]);
        $user10 = User::create([
            'name' => 'Simon Belmont',
            'display_name' => 'SimonBelmont',
            'email' => 'simo@this.com',
            'password' => bcrypt('Avi123?'),
            'uniqid' => '..5b5f1716e807c10',
            'profile_image' => '00-default-avatar.jpg',
            'background_image' => '00-default-canopy.jpg'
        ]);
        $user11 = User::create([
            'name' => 'Nathan Drake',
            'display_name' => 'NathanDrake',
            'email' => 'nath@this.com',
            'password' => bcrypt('Avi123?'),
            'uniqid' => '..5b5f1716e808b11',
            'profile_image' => '00-default-avatar.jpg',
            'background_image' => '00-default-canopy.jpg'
        ]);
        $user12 = User::create([
            'name' => 'Lara Croft',
            'display_name' => 'LaraCroft',
            'email' => 'lara@this.com',
            'password' => bcrypt('Avi123?'),
            'uniqid' => '..5b5f1716e809a12',
            'profile_image' => '00-default-avatar.jpg',
            'background_image' => '00-default-canopy.jpg'
        ]);
        $user13 = User::create([
            'name' => 'Sam Fisher',
            'display_name' => 'SamFisher',
            'email' => 'sam@this.com',
            'password' => bcrypt('Avi123?'),
            'uniqid' => '..5b5f1716e80a913',
            'profile_image' => '00-default-avatar.jpg',
            'background_image' => '00-default-canopy.jpg'
        ]);
        $user14 = User::create([
            'name' => 'Sarah Kerrigan',
            'display_name' => 'SarahKerrigan',
            'email' => 'sara@this.com',
            'password' => bcrypt('Avi123?'),
            'uniqid' => '..5b5f1716e80b814',
            'profile_image' => '00-default-avatar.jpg',
            'background_image' => '00-default-canopy.jpg'
        ]);
        $user15 = User::create([
            'name' => 'John Marston',
            'display_name' => 'JohnMarston',
            'email' => 'john@this.com',
            'password' => bcrypt('Avi123?'),
            'uniqid' => '..5b5f1716e80c615',
            'profile_image' => '00-default-avatar.jpg',
            'background_image' => '00-default-canopy.jpg'
        ]);
        $user16 = User::create([
            'name' => 'Tommy Vercetti',
            'display_name' => 'TommyVercetti',
            'email' => 'tomm@this.com',
            'password' => bcrypt('Avi123?'),
            'uniqid' => '..5b5f1716e80d516',
            'profile_image' => '00-default-avatar.jpg',
            'background_image' => '00-default-canopy.jpg'
        ]);
        $user17 = User::create([
            'name' => 'Gordon Freeman',
            'display_name' => 'GordonFreeman',
            'email' => 'gord@this.com',
            'password' => bcrypt('Avi123?'),
            'uniqid' => '..5b5f1716e80e417',
            'profile_image' => '00-default-avatar.jpg',
            'background_image' => '00-default-canopy.jpg'
        ]);
        $user18 = User::create([
            'name' => 'Joel Miller',
            'display_name' => 'JoelMiller',
            'email' => 'joel@this.com',
            'password' => bcrypt('Avi123?'),
            'uniqid' => '..5b5f1716e810a18',
            'profile_image' => '00-default-avatar.jpg',
            'background_image' => '00-default-canopy.jpg'
        ]);
        $user19 = User::create([
            'name' => 'Chun Li',
            'display_name' => 'ChunLi',
            'email' => 'chun@this.com',
            'password' => bcrypt('Avi123?'),
            'uniqid' => '..5b5f1716e811f19',
            'profile_image' => '00-default-avatar.jpg',
            'background_image' => '00-default-canopy.jpg'
        ]);
        $user20 = User::create([
            'name' => 'Jill Valentine',
            'display_name' => 'Jill Valentine',
            'email' => 'jill@this.com',
            'password' => bcrypt('Avi123?'),
            'uniqid' => '..5b5f1716e812f20',
            'profile_image' => '00-default-avatar.jpg',
            'background_image' => '00-default-canopy.jpg'
        ]);
        $user21 = User::create([
            'name' => 'Garrus Vakarian',
            'display_name' => 'GarrusV',
            'email' => 'garr@this.com',
            'password' => bcrypt('Avi123?'),
            'uniqid' => '..5b5f1716e813e21',
            'profile_image' => '00-default-avatar.jpg',
            'background_image' => '00-default-canopy.jpg'
        ]);
        $user22 = User::create([
            'name' => 'Samus Aran',
            'display_name' => 'SamusAran',
            'email' => 'samu@this.com',
            'password' => bcrypt('Avi123?'),
            'uniqid' => '..5b5f1716e814d22',
            'profile_image' => '00-default-avatar.jpg',
            'background_image' => '00-default-canopy.jpg'
        ]);
        $user23 = User::create([
            'name' => 'Elena Fisher',
            'display_name' => 'ElenaFisher',
            'email' => 'elen@this.com',
            'password' => bcrypt('Avi123?'),
            'uniqid' => '..5b5f1716e815d23',
            'profile_image' => '00-default-avatar.jpg',
            'background_image' => '00-default-canopy.jpg'
        ]);
        $user24 = User::create([
            'name' => 'Joanna Dark',
            'display_name' => 'JoannaDark',
            'email' => 'joan@this.com',
            'password' => bcrypt('Avi123?'),
            'uniqid' => '..5b5f1716e816c24',
            'profile_image' => '00-default-avatar.jpg',
            'background_image' => '00-default-canopy.jpg'
        ]);
        $user25 = User::create([
            'name' => 'Faith Connors',
            'display_name' => 'FaithConnors',
            'email' => 'fait@this.com',
            'password' => bcrypt('Avi123?'),
            'uniqid' => '..5b5f1716e817b25',
            'profile_image' => '00-default-avatar.jpg',
            'background_image' => '00-default-canopy.jpg'
        ]);
        $user26 = User::create([
            'name' => 'Preston Garvey',
            'display_name' => 'PGarvey',
            'email' => 'pres@this.com',
            'password' => bcrypt('Avi123?'),
            'uniqid' => '..5b5f1716e818926',
            'profile_image' => '26-5b5f1716e818926-projectspectr-pgarvey-avatar.jpg',
            'background_image' => '26-5b5f1716e818926-projectspectr-pgarvey-canopy.jpg'
        ]);
        $user27 = User::create([
            'name' => 'Juliet Starling',
            'display_name' => 'JulietStar',
            'email' => 'juli@this.com',
            'password' => bcrypt('Avi123?'),
            'uniqid' => '..5b5f1716e819827',
            'profile_image' => '00-default-avatar.jpg',
            'background_image' => '00-default-canopy.jpg'
        ]);
        $user28 = User::create([
            'name' => 'Jodie Holmes',
            'display_name' => 'JodieH',
            'email' => 'jodi@this.com',
            'password' => bcrypt('Avi123?'),
            'uniqid' => '..5b5f1716e81b528',
            'profile_image' => '00-default-avatar.jpg',
            'background_image' => '00-default-canopy.jpg'
        ]);
        $user29 = User::create([
            'name' => 'Delsin Rowe',
            'display_name' => 'DelsinRowe',
            'email' => 'dels@this.com',
            'password' => bcrypt('Avi123?'),
            'uniqid' => '..5b5f1716e81c429',
            'profile_image' => '00-default-avatar.jpg',
            'background_image' => '00-default-canopy.jpg'
        ]);
        $user30 = User::create([
            'name' => 'Trevor Phillips',
            'display_name' => 'Trevor2013',
            'email' => 'trev@this.com',
            'password' => bcrypt('Avi123?'),
            'uniqid' => '..5b5f1716e81d330',
            'profile_image' => '00-default-avatar.jpg',
            'background_image' => '00-default-canopy.jpg'
        ]);
        $user31 = User::create([
            'name' => 'Joseph Seed',
            'display_name' => 'JosephSeed',
            'email' => 'jose@this.com',
            'password' => bcrypt('Avi123?'),
            'uniqid' => '..5b5f1716e81e131',
            'profile_image' => '00-default-avatar.jpg',
            'background_image' => '00-default-canopy.jpg'
        ]);
        $user32 = User::create([
            'name' => 'Avery Johnson',
            'display_name' => 'AJohnson',
            'email' => 'aver@this.com',
            'password' => bcrypt('Avi123?'),
            'uniqid' => '..5b5f1716e81f032',
            'profile_image' => '00-default-avatar.jpg',
            'background_image' => '00-default-canopy.jpg'
        ]);
        $user33 = User::create([
            'name' => 'Cassie Cage',
            'display_name' => 'CassieCage',
            'email' => 'cass@this.com',
            'password' => bcrypt('Avi123?'),
            'uniqid' => '..5b5f1716e81ff33',
            'profile_image' => '00-default-avatar.jpg',
            'background_image' => '00-default-canopy.jpg'
        ]);
        $user34 = User::create([
            'name' => 'Miranda Lawson',
            'display_name' => 'MirandaLawson',
            'email' => 'mira@this.com',
            'password' => bcrypt('Avi123?'),
            'uniqid' => '..5b5f1716e820f34',
            'profile_image' => '00-default-avatar.jpg',
            'background_image' => '00-default-canopy.jpg'
        ]);
        $user35 = User::create([
            'name' => 'Cindy Aurum',
            'display_name' => 'CindyAurum',
            'email' => 'cind@this.com',
            'password' => bcrypt('Avi123?'),
            'uniqid' => '..5b5f1716e821d35',
            'profile_image' => '00-default-avatar.jpg',
            'background_image' => '00-default-canopy.jpg'
        ]);
        $user36 = User::create([
            'name' => 'Triss Merigold',
            'display_name' => 'Triss',
            'email' => 'tris@this.com',
            'password' => bcrypt('Avi123?'),
            'uniqid' => '..5b5f1716e822c36',
            'profile_image' => '00-default-avatar.jpg',
            'background_image' => '00-default-canopy.jpg'
        ]);
        $user37 = User::create([
            'name' => 'Edward Buck',
            'display_name' => 'EMBuck',
            'email' => 'edwa@this.com',
            'password' => bcrypt('Avi123?'),
            'uniqid' => '..5b5f1716e823b37',
            'profile_image' => '00-default-avatar.jpg',
            'background_image' => '00-default-canopy.jpg'
        ]);
        $user38 = User::create([
            'name' => 'Tifa Lockhart',
            'display_name' => 'Tifa',
            'email' => 'tifa@this.com',
            'password' => bcrypt('Avi123?'),
            'uniqid' => '..5b5f1716e824938',
            'profile_image' => '00-default-avatar.jpg',
            'background_image' => '00-default-canopy.jpg'
        ]);
        $user39 = User::create([
            'name' => 'John Price',
            'display_name' => 'JPrice',
            'email' => 'johnp@this.com',
            'password' => bcrypt('Avi123?'),
            'uniqid' => '..5b5f1716e825839',
            'profile_image' => '00-default-avatar.jpg',
            'background_image' => '00-default-canopy.jpg'
        ]);
        $user40 = User::create([
            'name' => 'Chloe Frazer',
            'display_name' => 'ChloeFrazer',
            'email' => 'chlo@this.com',
            'password' => bcrypt('Avi123?'),
            'uniqid' => '..5b5f1716e826740',
            'profile_image' => '00-default-avatar.jpg',
            'background_image' => '00-default-canopy.jpg'
        ]);
        $user41 = User::create([
            'name' => 'Nova Terra',
            'display_name' => 'NovaTerra',
            'email' => 'nova@this.com',
            'password' => bcrypt('Avi123?'),
            'uniqid' => '..5b5f1716e827541',
            'profile_image' => '00-default-avatar.jpg',
            'background_image' => '00-default-canopy.jpg'
        ]);
        $user42 = User::create([
            'name' => 'Billy Lee',
            'display_name' => 'BillyLee87',
            'email' => 'bill@this.com',
            'password' => bcrypt('Avi123?'),
            'uniqid' => '..5b5f1716e828442',
            'profile_image' => '00-default-avatar.jpg',
            'background_image' => '00-default-canopy.jpg'
        ]);
        $user43 = User::create([
            'name' => 'Nina Williams',
            'display_name' => 'Nina',
            'email' => 'nina@this.com',
            'password' => bcrypt('Avi123?'),
            'uniqid' => '..5b5f1716e829343',
            'profile_image' => '00-default-avatar.jpg',
            'background_image' => '00-default-canopy.jpg'
        ]);
        $user44 = User::create([
            'name' => 'Morrigan',
            'display_name' => 'Morrigan',
            'email' => 'morr@this.com',
            'password' => bcrypt('Avi123?'),
            'uniqid' => '..5b5f1716e82a244',
            'profile_image' => '00-default-avatar.jpg',
            'background_image' => '00-default-canopy.jpg'
        ]);
        $user45 = User::create([
            'name' => 'Gabriel Logan',
            'display_name' => 'GLogan',
            'email' => 'gabr@this.com',
            'password' => bcrypt('Avi123?'),
            'uniqid' => '..5b5f1716e82b045',
            'profile_image' => '00-default-avatar.jpg',
            'background_image' => '00-default-canopy.jpg'
        ]);
        $user46 = User::create([
            'name' => 'Yennefer',
            'display_name' => 'Yennefer',
            'email' => 'yenn@this.com',
            'password' => bcrypt('Avi123?'),
            'uniqid' => '..5b5f1716e82bf46',
            'profile_image' => '00-default-avatar.jpg',
            'background_image' => '00-default-canopy.jpg'
        ]);
        $user47 = User::create([
            'name' => 'Crimson Viper',
            'display_name' => 'CrimsonViper',
            'email' => 'crim@this.com',
            'password' => bcrypt('Avi123?'),
            'uniqid' => '..5b5f1716e82ce47',
            'profile_image' => '47-5b5f1716e82ce47-projectspectr-crimsonviper-avatar.png',
            'background_image' => '47-5b5f1716e82ce47-projectspectr-crimsonviper-canopy.png'
        ]);
    }
}
