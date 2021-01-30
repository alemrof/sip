<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Role;
use App\Models\User;
use App\Models\Company;
use App\Models\Product;
use App\Models\Category;
use App\Models\Warehouse;
use App\Models\OpeningHours;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Grimzy\LaravelMysqlSpatial\Types\Point;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name'=>'User']);
        Role::create(['name'=>'Admin']);
        
        User::create([
            'role_id' => 1,
            'name' => 'Tomasz Formela',
            'email' => 'tomek@tomek.com',
            'password' => Hash::make('tomek123')
        ]);

        User::create([
            'role_id'=>2,
            'name'=>'Admin',
            'email'=>'admin@admin.com', 
            'password'=>Hash::make('password')
        ]);

        $castorama = Company::create(['name' => 'Castorama']);
        $leroyMerlin = Company::create(['name' => 'Leroy Merlin']);

        $wh1 = Warehouse::create([
            'name' => 'Castorama Gdańsk Oliwa',
            'company_id' => $castorama->id,
            'address' => 'aleja Grunwaldzka 262, 80-314 Gdańsk',
            'location' => new Point(54.396006808244124, 18.577674827404387)
        ]);
        $wh2 = Warehouse::create([
            'name' => 'Castorama Odyseusza',
            'company_id' => $castorama->id,
            'address' => 'Odyseusza 2, 80-299 Gdańsk',
            'location' => new Point(54.43233463765607, 18.486433086502654)
        ]);
        $wh3 = Warehouse::create([
            'name' => 'Leroy Merlin Gdańsk Oliwa',
            'company_id' => $leroyMerlin->id,
            'address' => 'aleja Grunwaldzka 309, 80-309 Gdańsk',
            'location' => new Point(54.39463073834571, 18.58101521551848)
        ]);
        $wh4 = Warehouse::create([
            'name' => 'Leroy Merlin Gdańsk',
            'company_id' => $leroyMerlin->id,
            'address' => 'Szczęśliwa 7, 80-176 Gdańsk',
            'location' => new Point(54.35313340101314, 18.521470337609315)
        ]);

        // Opening Hours
        $warehouses = [$wh1, $wh2, $wh3, $wh4];
        foreach($warehouses as $wh) {
            $weekDays = ["monday", "wednesday", "tuesday", "thursday", "friday", "saturday", "sunday"];
            foreach ($weekDays as $day) {
                $startHour = Carbon::createFromTime(rand(6, 10), 0, 0, "Europe/Warsaw");
                $endHour = Carbon::createFromTime(rand(16, 22), 0, 0, "Europe/Warsaw");
                $this->createOpeningHours($wh->id, $day, $startHour, $endHour);
            }
        }

        Category::create(['name'=>'Cementy i zaprawy']);
        Category::create(['name'=>'Izolacja']);

        Product::create([
            'name'=>'Zaprawa murarska Huzar 25 kg',
            'category_id'=>1,
            'manufacturer'=>'Huzar'
        ]);
        Product::create([
            'name'=>'Zaprawa tynkowa Atlas 25 kg',
            'category_id'=>1,
            'manufacturer'=>'Atlas'
        ]);
        Product::create([
            'name'=>'Gotowa gładź Rapid 25 kg',
            'category_id'=>1,
            'manufacturer'=>'Atlas'
        ]);
        Product::create([
            'name'=>'Klej gipsowy Dolina Nidy T 22,5 kg',
            'category_id'=>1,
            'manufacturer'=>'Dolina Nidy'
        ]);
        Product::create([
            'name'=>'Masa szpachlowa Rigips Vario 5 kg',
            'category_id'=>1,
            'manufacturer'=>'Rigips'
        ]);
        Product::create([
            'name'=>'Fuga do klinkieru Kreisel piaskowa 10 kg',
            'category_id'=>1,
            'manufacturer'=>'Kreisel'
        ]);
        Product::create([
            'name'=>'Cement Adept 32,5R 25 kg',
            'category_id'=>1,
            'manufacturer'=>'Górażdże Cement'
        ]);
        Product::create([
            'name'=>'Wełna Rockwool Steprock Plus 50 mm 2,4 m2',
            'category_id'=>2,
            'manufacturer'=>'Rockwool'
        ]);
        Product::create([
            'name'=>'Styropian Aqua frezowany 100 mm 0,365 m3 5 szt.',
            'category_id'=>2,
            'manufacturer'=>'Aqua'
        ]);
        Product::create([
            'name'=>'Mata izolacyjna Diall do drzwi garażowych z taśmą 1 x 6 m',
            'category_id'=>2,
            'manufacturer'=>'Diall'
        ]);
        Product::create([
            'name'=>'Uszczelka pianka Diall wsuwana podwójna 1 m',
            'category_id'=>2,
            'manufacturer'=>'Diall'
        ]);
        Product::create([
            'name'=>'Płyta akustyczna Diall EPDM RAC002 50 x 50 cm',
            'category_id'=>2,
            'manufacturer'=>'Diall'
        ]);
        Product::create([
            'name'=>'Wełna Isover Aku-Płyta 1200 x 600 x 100 mm 7,2 m2',
            'category_id'=>2,
            'manufacturer'=>'Isover'
        ]);

        $warehouse = Warehouse::where('id', 1)->first();
        $warehouse->products()->attach(1, ['price' => 10]);
        $warehouse->products()->attach(2, ['price' => 15]);
        $warehouse->products()->attach(3, ['price' => 8]);
        $warehouse->products()->attach(4, ['price' => 4.50]);
        $warehouse->products()->attach(6, ['price' => 2.35]);
        $warehouse->products()->attach(8, ['price' => 6]);
        $warehouse->products()->attach(9, ['price' => 3]);
        
        $warehouse = Warehouse::where('id', 2)->first();
        $warehouse->products()->attach(1, ['price' => 12]);
        $warehouse->products()->attach(2, ['price' => 11]);
        $warehouse->products()->attach(3, ['price' => 9]);
        $warehouse->products()->attach(5, ['price' => 6.70]);
        $warehouse->products()->attach(7, ['price' => 4.20]);
        $warehouse->products()->attach(8, ['price' => 5]);
        $warehouse->products()->attach(9, ['price' => 64]);
    }

    private function createOpeningHours(int $id, string $day, $startHour, $endHour) {
        OpeningHours::create([
            "warehouse_id" => $id,
            "weekday" => $day,
            "start_hour" => $startHour,
            "end_hour" => $endHour,
        ]);
    }
}
