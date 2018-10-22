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
        for($i=1;$i<47;$i++){
            UserInfo::create([
                'id' => $i,
                'bio' => '',
                'social_meta' => '{}',
                'ip_address' => '127.0.0.1'
            ]);
        }
        $userInfo47 = UserInfo::create([
            'id' => '47',
            'bio' => 'Though employed by S.I.N. in reality, I am a secret agent under the employ of a U.S. government agency, the CIA.',
            'social_meta' => '{"facebook":"crimson.viper.fans","youtube":"ThaBamboozler","twitter":"code_cviper","website":"http://streetfighter.wikia.com/wiki/C._Viper"}',
            'ip_address' => '127.0.0.1'
        ]);
    }
}
