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
            'uniqid' => '5b5b40fa8b4b1'
        ]);
        $user2 = User::create([
            'name' => 'Basic User',
            'display_name' => 'BASIC',
            'email' => 'basic@example.com',
            'password' => bcrypt('basic123'),
            'uniqid' => '5b5b40fa8b4b2'
        ]);
        $user3 = User::create([
            'name' => 'Contributor User',
            'display_name' => 'CONTRIBUTOR',
            'email' => 'contributor@example.com',
            'password' => bcrypt('contributor123'),
            'uniqid' => '5b5b40fa8b4b3'
        ]);
        $user4 = User::create([
            'name' => 'Author User',
            'display_name' => 'AUTHOR',
            'email' => 'author@example.com',
            'password' => bcrypt('author123'),
            'uniqid' => '5b5b40fa8b4b4'
        ]);
        $user5 = User::create([
            'name' => 'Editor User',
            'display_name' => 'EDITOR',
            'email' => 'editor@example.com',
            'password' => bcrypt('editor123'),
            'uniqid' => '5b5b40fa8b4b5'
        ]);
        $user6 = User::create([
            'name' => 'Admin User',
            'display_name' => 'ADMIN',
            'email' => 'admin@example.com',
            'password' => bcrypt('admin123'),
            'uniqid' => '5b5b40fa8b4b6'
        ]);
        $user7 = User::create([
            'name' => 'Super User',
            'display_name' => 'SUPER',
            'email' => 'super@example.com',
            'password' => bcrypt('super123'),
            'uniqid' => '5b5b40fa8b4b7'
        ]);
        $user8 = User::create([
            'name' => 'Marcus Fenix',
            'display_name' => 'Marcus Fenix',
            'email' => 'marc@this.com',
            'password' => bcrypt('Avi123?'),
            'uniqid' => '5b5f1716e80568'
        ]);
        $user9 = User::create([
            'name' => 'Leon Kennedy',
            'display_name' => 'Leon Kennedy',
            'email' => 'leon@this.com',
            'password' => bcrypt('Avi123?'),
            'uniqid' => '5b5f1716e806c9'
        ]);
        $user10 = User::create([
            'name' => 'Simon Belmont',
            'display_name' => 'Simon Belmont',
            'email' => 'simo@this.com',
            'password' => bcrypt('Avi123?'),
            'uniqid' => '5b5f1716e807c10'
        ]);
        $user11 = User::create([
            'name' => 'Nathan Drake',
            'display_name' => 'Nathan Drake',
            'email' => 'nath@this.com',
            'password' => bcrypt('Avi123?'),
            'uniqid' => '5b5f1716e808b11'
        ]);
        $user12 = User::create([
            'name' => 'Lara Croft',
            'display_name' => 'Lara Croft',
            'email' => 'lara@this.com',
            'password' => bcrypt('Avi123?'),
            'uniqid' => '5b5f1716e809a12'
        ]);
        $user13 = User::create([
            'name' => 'Sam Fisher',
            'display_name' => 'Sam Fisher',
            'email' => 'sam@this.com',
            'password' => bcrypt('Avi123?'),
            'uniqid' => '5b5f1716e80a913'
        ]);
        $user14 = User::create([
            'name' => 'Sarah Kerrigan',
            'display_name' => 'Sarah Kerrigan',
            'email' => 'sara@this.com',
            'password' => bcrypt('Avi123?'),
            'uniqid' => '5b5f1716e80b814'
        ]);
        $user15 = User::create([
            'name' => 'John Marston',
            'display_name' => 'John Marston',
            'email' => 'john@this.com',
            'password' => bcrypt('Avi123?'),
            'uniqid' => '5b5f1716e80c615'
        ]);
        $user16 = User::create([
            'name' => 'Tommy Vercetti',
            'display_name' => 'Tommy Vercetti',
            'email' => 'tomm@this.com',
            'password' => bcrypt('Avi123?'),
            'uniqid' => '5b5f1716e80d516'
        ]);
        $user17 = User::create([
            'name' => 'Gordon Freeman',
            'display_name' => 'Gordon Freeman',
            'email' => 'gord@this.com',
            'password' => bcrypt('Avi123?'),
            'uniqid' => '5b5f1716e80e417'
        ]);
        $user18 = User::create([
            'name' => 'Joel Miller',
            'display_name' => 'Joel Miller',
            'email' => 'joel@this.com',
            'password' => bcrypt('Avi123?'),
            'uniqid' => '5b5f1716e810a18'
        ]);
        $user19 = User::create([
            'name' => 'Chun Li',
            'display_name' => 'Chun Li',
            'email' => 'chun@this.com',
            'password' => bcrypt('Avi123?'),
            'uniqid' => '5b5f1716e811f19'
        ]);
        $user20 = User::create([
            'name' => 'Jill Valentine',
            'display_name' => 'Jill Valentine',
            'email' => 'jill@this.com',
            'password' => bcrypt('Avi123?'),
            'uniqid' => '5b5f1716e812f20'
        ]);
        $user21 = User::create([
            'name' => 'Garrus Vakarian',
            'display_name' => 'Garrus Vakarian',
            'email' => 'garr@this.com',
            'password' => bcrypt('Avi123?'),
            'uniqid' => '5b5f1716e813e21'
        ]);
        $user22 = User::create([
            'name' => 'Samus Aran',
            'display_name' => 'Samus Aran',
            'email' => 'samu@this.com',
            'password' => bcrypt('Avi123?'),
            'uniqid' => '5b5f1716e814d22'
        ]);
        $user23 = User::create([
            'name' => 'Elena Fisher',
            'display_name' => 'Elena Fisher',
            'email' => 'elen@this.com',
            'password' => bcrypt('Avi123?'),
            'uniqid' => '5b5f1716e815d23'
        ]);
        $user24 = User::create([
            'name' => 'Joanna Dark',
            'display_name' => 'Joanna Dark',
            'email' => 'joan@this.com',
            'password' => bcrypt('Avi123?'),
            'uniqid' => '5b5f1716e816c24'
        ]);
        $user25 = User::create([
            'name' => 'Faith Connors',
            'display_name' => 'Faith Connors',
            'email' => 'fait@this.com',
            'password' => bcrypt('Avi123?'),
            'uniqid' => '5b5f1716e817b25'
        ]);
        $user26 = User::create([
            'name' => 'Preston Garvey',
            'display_name' => 'Preston Garvey',
            'email' => 'pres@this.com',
            'password' => bcrypt('Avi123?'),
            'uniqid' => '5b5f1716e818926'
        ]);
        $user27 = User::create([
            'name' => 'Juliet Starling',
            'display_name' => 'Juliet Starling',
            'email' => 'juli@this.com',
            'password' => bcrypt('Avi123?'),
            'uniqid' => '5b5f1716e819827'
        ]);
        $user28 = User::create([
            'name' => 'Jodie Holmes',
            'display_name' => 'Jodie Holmes',
            'email' => 'jodi@this.com',
            'password' => bcrypt('Avi123?'),
            'uniqid' => '5b5f1716e81b528'
        ]);
        $user29 = User::create([
            'name' => 'Delsin Rowe',
            'display_name' => 'Delsin Rowe',
            'email' => 'dels@this.com',
            'password' => bcrypt('Avi123?'),
            'uniqid' => '5b5f1716e81c429'
        ]);
        $user30 = User::create([
            'name' => 'Trevor Phillips',
            'display_name' => 'Trevor Phillips',
            'email' => 'trev@this.com',
            'password' => bcrypt('Avi123?'),
            'uniqid' => '5b5f1716e81d330'
        ]);
        $user31 = User::create([
            'name' => 'Joseph Seed',
            'display_name' => 'Joseph Seed',
            'email' => 'jose@this.com',
            'password' => bcrypt('Avi123?'),
            'uniqid' => '5b5f1716e81e131'
        ]);
        $user32 = User::create([
            'name' => 'Avery Johnson',
            'display_name' => 'Avery Johnson',
            'email' => 'aver@this.com',
            'password' => bcrypt('Avi123?'),
            'uniqid' => '5b5f1716e81f032'
        ]);
        $user33 = User::create([
            'name' => 'Cassie Cage',
            'display_name' => 'Cassie Cage',
            'email' => 'cass@this.com',
            'password' => bcrypt('Avi123?'),
            'uniqid' => '5b5f1716e81ff33'
        ]);
        $user34 = User::create([
            'name' => 'Miranda Lawson',
            'display_name' => 'Miranda Lawson',
            'email' => 'mira@this.com',
            'password' => bcrypt('Avi123?'),
            'uniqid' => '5b5f1716e820f34'
        ]);
        $user35 = User::create([
            'name' => 'Cindy Aurum',
            'display_name' => 'Cindy Aurum',
            'email' => 'cind@this.com',
            'password' => bcrypt('Avi123?'),
            'uniqid' => '5b5f1716e821d35'
        ]);
        $user36 = User::create([
            'name' => 'Triss Merigold',
            'display_name' => 'Truss Merigold',
            'email' => 'trus@this.com',
            'password' => bcrypt('Avi123?'),
            'uniqid' => '5b5f1716e822c36'
        ]);
        $user37 = User::create([
            'name' => 'Edward Buck',
            'display_name' => 'Edward Buck',
            'email' => 'edwa@this.com',
            'password' => bcrypt('Avi123?'),
            'uniqid' => '5b5f1716e823b37'
        ]);
        $user38 = User::create([
            'name' => 'Tifa Lockhart',
            'display_name' => 'Tifa Lockhart',
            'email' => 'tifa@this.com',
            'password' => bcrypt('Avi123?'),
            'uniqid' => '5b5f1716e824938'
        ]);
        $user39 = User::create([
            'name' => 'John Price',
            'display_name' => 'John Price',
            'email' => 'johnp@this.com',
            'password' => bcrypt('Avi123?'),
            'uniqid' => '5b5f1716e825839'
        ]);
        $user40 = User::create([
            'name' => 'Chloe Frazer',
            'display_name' => 'Chloe Frazer',
            'email' => 'chlo@this.com',
            'password' => bcrypt('Avi123?'),
            'uniqid' => '5b5f1716e826740'
        ]);
        $user41 = User::create([
            'name' => 'Nova Terra',
            'display_name' => 'Nova Terra',
            'email' => 'nova@this.com',
            'password' => bcrypt('Avi123?'),
            'uniqid' => '5b5f1716e827541'
        ]);
        $user42 = User::create([
            'name' => 'Billy Lee',
            'display_name' => 'Billy Lee',
            'email' => 'bill@this.com',
            'password' => bcrypt('Avi123?'),
            'uniqid' => '5b5f1716e828442'
        ]);
        $user43 = User::create([
            'name' => 'Nina Williams',
            'display_name' => 'Nina Williams',
            'email' => 'nina@this.com',
            'password' => bcrypt('Avi123?'),
            'uniqid' => '5b5f1716e829343'
        ]);
        $user44 = User::create([
            'name' => 'Morrigan',
            'display_name' => 'Morrigan',
            'email' => 'morr@this.com',
            'password' => bcrypt('Avi123?'),
            'uniqid' => '5b5f1716e82a244'
        ]);
        $user45 = User::create([
            'name' => 'Gabriel Logan',
            'display_name' => 'Gabriel Logan',
            'email' => 'gabr@this.com',
            'password' => bcrypt('Avi123?'),
            'uniqid' => '5b5f1716e82b045'
        ]);
        $user46 = User::create([
            'name' => 'Yennefer',
            'display_name' => 'Yennefer',
            'email' => 'yenn@this.com',
            'password' => bcrypt('Avi123?'),
            'uniqid' => '5b5f1716e82bf46'
        ]);
        $user47 = User::create([
            'name' => 'Chrimson Viper',
            'display_name' => 'Chrimson Viper',
            'email' => 'chri@this.com',
            'password' => bcrypt('Avi123?'),
            'uniqid' => '5b5f1716e82ce47'
        ]);
    }
}
