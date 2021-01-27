<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Company;
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
        User::create([
            'name' => 'Tomasz Formela',
            'email' => 'tomek@tomek.com',
            'password' => Hash::make('tomek123')
        ]);

        $castorama = Company::create(['name' => 'Castorama']);
        $leroyMerlin = Company::create(['name' => 'Leroy Merlin']);

        $castoOliva = Warehouse::create([
            'name' => 'Castorama Gdańsk Oliwa',
            'company_id' => $castorama->id,
            'address' => 'aleja Grunwaldzka 262, 80-314 Gdańsk',
            'location' => new Point(54.396006808244124, 18.577674827404387)
        ]);
        Warehouse::create([
            'name' => 'Castorama Odyseusza',
            'company_id' => $castorama->id,
            'address' => 'Odyseusza 2, 80-299 Gdańsk',
            'location' => new Point(54.43233463765607, 18.486433086502654)
        ]);
        Warehouse::create([
            'name' => 'Leroy Merlin Gdańsk Oliwa',
            'company_id' => $leroyMerlin->id,
            'address' => 'aleja Grunwaldzka 309, 80-309 Gdańsk',
            'location' => new Point(54.39463073834571, 18.58101521551848)
        ]);
        Warehouse::create([
            'name' => 'Leroy Merlin Gdańsk',
            'company_id' => $leroyMerlin->id,
            'address' => 'Szczęśliwa 7, 80-176 Gdańsk',
            'location' => new Point(54.35313340101314, 18.521470337609315)
        ]);

        // Opening Hours
        $weekDays = ["monday", "wednesday", "tuesday", "thursday", "friday", "saturday", "sunday"];
        foreach ($weekDays as $day) {
            $startHour = Carbon::createFromTime(9, 0, 0, "Europe/Warsaw");
            $endHour = Carbon::createFromTime(18, 0, 0, "Europe/Warsaw");
            $this->createOpeningHours($castoOliva->id, $day, $startHour, $endHour);
        }
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
