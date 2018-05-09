<?php

use Illuminate\Database\Seeder;
use App\Models\User\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'client_id' => '71d4f8ea-1138-11e8-a472-002163944a0x',
            'name' => 'Test User',
            'email' =>  'test@test.com',
            'password' => bcrypt('12345678'),
            'timezone' => 'America/Mexico_City'
        ]);
    }
}
