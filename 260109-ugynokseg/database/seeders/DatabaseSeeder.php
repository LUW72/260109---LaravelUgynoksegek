<?php

namespace Database\Seeders;

use App\Models\Agency;
use App\Models\Event;
use App\Models\Participate;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Users (min 3)
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'ZamboJimmyAdmin@csepel.hu',
            'vip' => false,
            'permission' => 2,
            'password' => Hash::make('password'),
        ]);

        $vip = User::create([
            'name' => 'VIP Guest',
            'email' => 'ZamboArpiVIP@csepel.hu',
            'vip' => true,
            'permission' => 0,
            'password' => Hash::make('password'),
        ]);

        $user = User::create([
            'name' => 'Normal Guest',
            'email' => 'ZamboKrisztianNormal@csepel.hu',
            'vip' => false,
            'permission' => 0,
            'password' => Hash::make('password'),
        ]);

        $a1 = Agency::create(['name'=>'Csepel Agency of Music','country'=>'HU','type'=>'PR']);
        $a2 = Agency::create(['name'=>'JimmySlovensko','country'=>'SK','type'=>'Event']);
        $a3 = Agency::create(['name'=>'Jimmy Deutschland','country'=>'DE','type'=>'Travel']);

        $e1 = Event::create([
            'agency_id'=>$a1->id, 'name'=>'Jimmy téli gála 1998', 'limit'=>2, 'type'=>'gála',
            'date'=>now()->addDays(2), 'location'=>'Budapest', 'status'=>0
        ]);
        $e2 = Event::create([
            'agency_id'=>$a2->id, 'name'=>'Sajtóreggeli Zámbó Árpi lakásán', 'limit'=>10, 'type'=>'PR',
            'date'=>now()->addDays(5), 'location'=>'Vienna', 'status'=>0
        ]);
        $e3 = Event::create([
            'agency_id'=>$a3->id, 'name'=>'Workshop (3 oktáv)', 'limit'=>15, 'type'=>'oktatás',
            'date'=>now()->subWeeks(4), 'location'=>'Berlin', 'status'=>0
        ]);

        Participate::create(['user_id'=>$vip->id,'event_id'=>$e1->id,'present'=>true]);
        Participate::create(['user_id'=>$user->id,'event_id'=>$e1->id,'present'=>true]);
        Participate::create(['user_id'=>$user->id,'event_id'=>$e2->id,'present'=>true]);



    }


}