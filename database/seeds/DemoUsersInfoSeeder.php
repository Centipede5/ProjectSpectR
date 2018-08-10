<?php

use Illuminate\Database\Seeder;
use App\UserInfo;

class DemoUsersInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userInfo47 = UserInfo::create([
            'id' => '47',
            'bio' => 'Though employed by S.I.N. in reality, I am a secret agent under the employ of a U.S. government agency, the CIA.',
            'social_meta' => '{"facebook":"crimson.viper.fans","twitter":"code_cviper","website":"http://streetfighter.wikia.com/wiki/C._Viper"}',
            'ip_address' => '127.0.0.1'
        ]);
    }
}
