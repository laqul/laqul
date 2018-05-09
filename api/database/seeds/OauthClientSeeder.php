<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OauthClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('oauth_clients')->insert([
            'id' => '71d4f8ea-1138-11e8-a472-002163944a0x',
            'name' => 'Default',
            'secret' => 'y1d4f8ea113811e8a472002163944a0x1234',
            'redirect' => '#',
            'personal_access_client' => false,
            'password_client' => true,
            'revoked' => false
        ]);
    }
}
