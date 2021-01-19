<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Company;
use App\Models\Warehouse;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name'=>'Tomasz Formela',
            'email'=>'tomek@tomek.com', 
            'password'=>Hash::make('tomek123')
        ]);
        Company::create(['name'=>'Castorama']);
        Company::create(['name'=>'Leroy Merlin']);
        Warehouse::create([
            'name'=>'Castorama Gdańsk Oliwa',
            'company_id'=>1,
            'address'=>'aleja Grunwaldzka 262, 80-314 Gdańsk',
            'location'=>new Point(54.396006808244124, 18.577674827404387)
        ]);
        Warehouse::create([
            'name'=>'Castorama Odyseusza',
            'company_id'=>1,
            'address'=>'Odyseusza 2, 80-299 Gdańsk',
            'location'=>new Point(54.43233463765607, 18.486433086502654)
        ]);
        Warehouse::create([
            'name'=>'Leroy Merlin Gdańsk Oliwa',
            'company_id'=>2,
            'address'=>'aleja Grunwaldzka 309, 80-309 Gdańsk',
            'location'=>new Point(54.39463073834571, 18.58101521551848)
        ]);
        Warehouse::create([
            'name'=>'Leroy Merlin Gdańsk',
            'company_id'=>2,
            'address'=>'Szczęśliwa 7, 80-176 Gdańsk',
            'location'=> new Point(54.35313340101314, 18.521470337609315)
        ]);
    }
}
