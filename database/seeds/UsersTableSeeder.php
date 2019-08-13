<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create(
            [
                'firstname' => 'John',
                'lastname' => 'Doe',
                'email' => 'john.doe@gmail.com',
                'password' => bcrypt('fancqspserfftydu'),
                'sources' => '{"De Morgen":true,"De Standaard":true, "De Tijd": true, "Gazet van Antwerpen": true, "Het Belang van Limburg": true, "Het Laatste Nieuws":true, "Het Nieuwsblad":true, "VRT":true, "VTM":true}',
            ]
        );
        User::create(
            [
                'firstname' => 'Robin',
                'lastname' => 'Kelchtermans',
                'email' => 'robin.kelchtermans@gmail.com',
                'email_verified_at' => '2019-02-17 13:52:45',
                'password' => bcrypt('fancqspserfftydu'),
                'is_admin' => 1,
                'sources' => '{"De Morgen":true,"De Standaard":true, "De Tijd": true, "Gazet van Antwerpen": true, "Het Belang van Limburg": true, "Het Laatste Nieuws":true, "Het Nieuwsblad":true, "VRT":true, "VTM":true}',
                'survey_hexad' => '{"S2":"-1","D1":"1","A2":"1","S1":"-2","P4":"1","F4":"3","F2":"-2","P1":"-2","P3":"2","D2":"-1","D3":"3","S3":"2","A4":"3","S4":"-1","A1":"2","D4":"-1","F3":"1","A3":"0","F1":"-2","P2":"2","userType":"Achiever","userInfo":"Achievers worden gemotiveerd door meesterschap. Ze willen nieuwe dingen leren en zichzelf verbeteren. Ze willen uitdagingen kunnen overwinnen."}',
                'survey_media' => '{}',
            ]
        );
    }
}
