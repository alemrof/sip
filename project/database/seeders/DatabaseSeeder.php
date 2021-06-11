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
        $userRole = Role::create(['name'=>'User']);
        $adminRole = Role::create(['name'=>'Admin']);
        $moderatorRole = Role::create(['name'=>'Moderator']);
        
        User::create([
            'role_id' => $userRole->id,
            'name' => 'Użytkownik 1',
            'email' => 'user1@mail.com',
            'password' => Hash::make('password')
        ]);

        User::create([
            'role_id' => $userRole->id,
            'name' => 'Użytkownik 2',
            'email' => 'user2@mail.com',
            'password' => Hash::make('password')
        ]);

        User::create([
            'role_id'=> $adminRole->id,
            'name'=>'Admin',
            'email'=>'admin@mail.com', 
            'password'=>Hash::make('password')
        ]);

        User::create([
            'role_id'=> $moderatorRole->id,
            'name'=>'Moderator',
            'email'=>'moderator@mail.com', 
            'password'=>Hash::make('password')
        ]);

        $castorama = Company::create(['name' => 'Castorama']);
        $leroyMerlin = Company::create(['name' => 'Leroy Merlin']);
        $gdanskieSkladyDrewna = Company::create(['name' => 'Gdańskie Składy Drewna']);
        $psb = Company::create(['name' => 'Grupa Polskie Składy Budowlane']);
        $rudzki = Company::create(['name' => 'RUDZKI']);
        $inplus = Company::create(['name' => 'INPLUS']);
        $gmbhurt = Company::create(['name' => 'GMB Hurt']);
        $abbechcicki = Company::create(['name' => 'AB Bechcicki']);
        $domarus = Company::create(['name' => 'Domarus']);
        $matbud = Company::create(['name' => 'Mat Bud']);
        $bysewo = Company::create(['name' => 'BYSEWO - Hurtownia materiałów budowlanych']);
        $bugerman = Company::create(['name' => 'BUGERMAN']);
        $ambit = Company::create(['name' => 'AMBIT']);
        $extradach = Company::create(['name' => 'extraDACH']);
        $dekabud = Company::create(['name' => 'Dekabud']);
        $elgrom = Company::create(['name' => 'Elgrom']);
        $bobi = Company::create(['name' => 'BOBI BUDOWLANY']);
        $oltrans = Company::create(['name' => 'Oltrans']);
        $budulec = Company::create(['name' => 'Budulec']);
        $domator = Company::create(['name' => 'Domator']);
        $bho = Company::create(['name' => 'BHO']);
        $phuLange = Company::create(['name' => 'P.H.U. LANGE']);
        $skladNowicki = Company::create(['name' => 'Skład Nowicki']);
        $marpol = Company::create(['name' => 'Mar-Pol']);
        $emag = Company::create(['name' => 'Emag']);
        $czapiewskimichal = Company::create(['name' => 'Czapiewski Michał']);
        $gssamopomocchlopska = Company::create(['name' => 'GS Samopomoc Chłopska']);
        $damet = Company::create(['name' => 'Damet']);
        $ginterkazimierz = Company::create(['name' => 'Ginet Kazimierz']);
        $almiron = Company::create(['name' => 'Almiron']);
        $rozynskiczeslaw = Company::create(['name' => 'Różyński Czesław']);
        $bokerfhu = Company::create(['name' => 'Boker FHU']);
        $bowmat = Company::create(['name' => 'BOWMAT']);
        $zaborowskijan = Company::create(['name' => 'Zaborowski Jan']);
        $izobud = Company::create(['name' => 'Izobud']);
        $almares = Company::create(['name' => 'Almares']);
        $delta = Company::create(['name' => 'Delta']);
        $cmbtim = Company::create(['name' => 'CMB TIM']);
        $puhSmok = Company::create(['name' => 'P.U.H. Smok']);
        $obi = Company::create(['name' => 'OBI']);
        $agaM = Company::create(['name' => 'Aga-M']);
        $jazbud = Company::create(['name' => 'JAZBUD']);
        $millenium = Company::create(['name' => 'Millenium']);
        $koszalka = Company::create(['name' => 'Koszałka']);
        $bricomarche = Company::create(['name' => 'Bricomarche']);
        $rodlo = Company::create(['name' => 'Rodło']);
        $ppuekobud = Company::create(['name' => 'PPU Ekobud']);
        $paulin = Company::create(['name' => 'Paulin']);
        $wasilak = Company::create(['name' => 'Wasilak']);
        $westa = Company::create(['name' => 'Westa']);
        $nordbud = Company::create(['name' => 'NordBud']);
        $sambor = Company::create(['name' => 'Sambor']);
        $slawbud = Company::create(['name' => 'Sław-Bud']);
        $celbud = Company::create(['name' => 'Cel-Bud. FHU.']);

        $wh1 = Warehouse::create([
            'name' => 'Castorama Gdańsk Oliwa',
            'company_id' => $castorama->id,
            'address' => 'aleja Grunwaldzka 262, 80-314 Gdańsk',
            'location' => new Point(54.396006808244124, 18.577674827404387),
            'rating' => 0
        ]);
        $wh2 = Warehouse::create([
            'name' => 'Castorama Odyseusza',
            'company_id' => $castorama->id,
            'address' => 'Odyseusza 2, 80-299 Gdańsk',
            'location' => new Point(54.43233463765607, 18.486433086502654),
            'rating' => 0
        ]);
        $wh3 = Warehouse::create([
            'name' => 'Leroy Merlin Gdańsk Oliwa',
            'company_id' => $leroyMerlin->id,
            'address' => 'aleja Grunwaldzka 309, 80-309 Gdańsk',
            'location' => new Point(54.39463073834571, 18.58101521551848),
            'rating' => 0
        ]);
        $wh4 = Warehouse::create([
            'name' => 'Leroy Merlin Gdańsk',
            'company_id' => $leroyMerlin->id,
            'address' => 'Szczęśliwa 7, 80-176 Gdańsk',
            'location' => new Point(54.35313340101314, 18.521470337609315),
            'rating' => 0
        ]);
        $wh5 = Warehouse::create([
            'name' => 'Gdańskie Składy Drewna',
            'company_id' => $gdanskieSkladyDrewna->id,
            'address' => 'aleja Generała Józefa Hallera 140, 80-416 Gdańsk',
            'location' => new Point(54.39614242995577, 18.62188590903475),
            'rating' => 0
        ]);

        $wh6 = Warehouse::create([
            'name' => 'BAT Gdańsk',
            'company_id' => $psb->id,
            'address' => 'Nowatorów 13, 80-298 Gdańsk',
            'location' => new Point(54.36393480598213, 18.493725571179674),
            'rating' => 0
        ]);

        $wh7 = Warehouse::create([
            'name' => 'BROKER Gdańsk',
            'company_id' => $psb->id,
            'address' => 'Galaktyczna 38, 80-299 Gdańsk',
            'location' => new Point(54.41703673536524, 18.485289380365504),
            'rating' => 0
        ]);

        $wh8 = Warehouse::create([
            'name' => 'RUDZKI Gdańsk Jasień',
            'company_id' => $rudzki->id,
            'address' => 'Limbowa 15, Gdańsk 80-175',
            'location' => new Point(54.337101402925306, 18.56954434722886),
            'rating' => 0
        ]);

        $wh9 = Warehouse::create([
            'name' => 'INPLUS Sopot',
            'company_id' => $inplus->id,
            'address' => 'Rzemieślnicza 9, 81-855 Sopot',
            'location' => new Point(54.428661571753864, 18.56462549658255),
            'rating' => 0
        ]);

        $wh10 = Warehouse::create([
            'name' => 'GMB Hurt Gdańsk',
            'company_id' => $gmbhurt->id,
            'address' => 'Marynarki Polskiej 71, 80-557 Gdańsk',
            'location' => new Point(54.38602441955519, 18.64534413372561),
            'rating' => 0
        ]);

        $wh11 = Warehouse::create([
            'name' => 'AB Bechcicki',
            'company_id' => $abbechcicki->id,
            'address' => 'Budowlanych 27, 80-298 Gdańsk',
            'location' => new Point(54.36519554334521, 18.478253147090193),
            'rating' => 0
        ]);

        $wh12 = Warehouse::create([
            'name' => 'Domarus S.c. Phu.',
            'company_id' => $abbechcicki->id,
            'address' => 'Piastowska 155, 80-358 Gdańsk',
            'location' => new Point(54.41748046414054, 18.59129563729168),
            'rating' => 0
        ]);

        $wh13 = Warehouse::create([
            'name' => 'Mat Bud Kowale',
            'company_id' => $matbud->id,
            'address' => 'Glazurowa 9, 80-180 Kowale',
            'location' => new Point(54.30787070582372, 18.565832542592346),
            'rating' => 0
        ]);

        $wh14 = Warehouse::create([
            'name' => 'BYSEWO Gdańsk',
            'company_id' => $bysewo->id,
            'address' => 'trakt świętego Wojciecha 57, 80-043 Gdańsk',
            'location' => new Point(54.331195123775714, 18.63449122446893),
            'rating' => 0
        ]);

        $wh15 = Warehouse::create([
            'name' => 'BUGERMAN Banino',
            'company_id' => $bugerman->id,
            'address' => 'Lotnicza 58, 80-297 Gdańsk',
            'location' => new Point(54.39521859898513, 18.397734390377725),
            'rating' => 0
        ]);

        $wh16 = Warehouse::create([
            'name' => 'AMBIT. Pokrycia dachowe',
            'company_id' => $ambit->id,
            'address' => 'Cementowa 5, 80-298 Gdańsk',
            'location' => new Point(54.36210936830079, 18.490296169536812),
            'rating' => 0
        ]);

        $wh17 = Warehouse::create([
            'name' => 'extraDACH Gdańsk',
            'company_id' => $extradach->id,
            'address' => 'Nowatorów 103, 80-298 Gdańsk',
            'location' => new Point(54.38020615708801, 18.453294182375096),
            'rating' => 0
        ]);

        $wh18 = Warehouse::create([
            'name' => 'Mat Bud Gdynia',
            'company_id' => $matbud->id,
            'address' => 'Hutnicza 25a, 81-036 Gdynia',
            'location' => new Point(54.55100365849732, 18.465510169112207),
            'rating' => 0
        ]);

        $wh19 = Warehouse::create([
            'name' => 'Dekabud',
            'company_id' => $dekabud->id,
            'address' => 'Szczęśliwa 46, 80-176 Gdańsk',
            'location' => new Point(54.3577247067046, 18.522949737335885),
            'rating' => 0
        ]);

        $wh20 = Warehouse::create([
            'name' => 'Elgrom Gdynia',
            'company_id' => $elgrom->id,
            'address' => 'Hutnicza 44, 81-061 Gdynia',
            'location' => new Point(54.558903816151805, 18.437487453224044),
            'rating' => 0
        ]);

        $wh21 = Warehouse::create([
            'name' => 'BOBI BUDOWLANY',
            'company_id' => $bobi->id,
            'address' => 'Zimna 11A, 80-606 Gdańsk',
            'location' => new Point(54.36196355292522, 18.71089864433659),
            'rating' => 0
        ]);

        $wh22 = Warehouse::create([
            'name' => 'Oltrans Gdynia',
            'company_id' => $oltrans->id,
            'address' => 'Wiejska 88, 81-198 Gdynia',
            'location' => new Point(54.58119046493906, 18.488253607746074),
            'rating' => 0
        ]);

        $wh23 = Warehouse::create([
            'name' => 'BAT Reda',
            'company_id' => $psb->id,
            'address' => 'Obwodowa 66, 84-240 Reda',
            'location' => new Point(54.61116582070189, 18.364486703126307),
            'rating' => 0
        ]);

        $wh24 = Warehouse::create([
            'name' => 'Budulec',
            'company_id' => $budulec->id,
            'address' => 'Spółdzielcza 22, 84-240 Reda',
            'location' => new Point(54.615768812952346, 18.343813836438706),
            'rating' => 0
        ]);

        $wh25 = Warehouse::create([
            'name' => 'Oltrans Puck',
            'company_id' => $oltrans->id,
            'address' => 'Wojska Polskiego 28, 84-100 Puck',
            'location' => new Point(54.72125230153406, 18.411754167732397),
            'rating' => 0
        ]);

        $wh26 = Warehouse::create([
            'name' => 'Profi Almares',
            'company_id' => $psb->id,
            'address' => 'Przemysłowa 17B, 84-200 Wejherowo',
            'location' => new Point(54.62071728270868, 18.21612553096143),
            'rating' => 0
        ]);

        $wh27 = Warehouse::create([
            'name' => 'Domator',
            'company_id' => $domator->id,
            'address' => 'I Bryg. Panc. W.P. 86B, 84-200 Wejherowo',
            'location' => new Point(54.618113910098984, 18.2050357365748),
            'rating' => 0
        ]);

        $wh28 = Warehouse::create([
            'name' => 'Budulec',
            'company_id' => $budulec->id,
            'address' => 'Leszczynowa 17, 84-239 Bolszewo',
            'location' => new Point(54.625282667469406, 18.173392627397845),
            'rating' => 0
        ]);

        $wh29 = Warehouse::create([
            'name' => 'BHO Wierzchucino',
            'company_id' => $bho->id,
            'address' => 'Leśna 6, 84-113 Wierzchucino',
            'location' => new Point(54.79525916920419, 17.995203853373646),
            'rating' => 0
        ]);

        $wh30 = Warehouse::create([
            'name' => 'P.H.U. LANGE',
            'company_id' => $phuLange->id,
            'address' => 'Pierwszych Osadników 21, 84-210 Choczewo',
            'location' => new Point(54.750797550497204, 17.894920686694874),
            'rating' => 0
        ]);

        $wh31 = Warehouse::create([
            'name' => 'BAT Lębork',
            'company_id' => $psb->id,
            'address' => 'Majkowskiego 10, 84-300 Lębork',
            'location' => new Point(54.5441977087958, 17.7702776568129),
            'rating' => 0
        ]);

        $wh32 = Warehouse::create([
            'name' => 'Skład Nowicki',
            'company_id' => $skladNowicki->id,
            'address' => 'Racławicka 16, 76-230 Potęgowo',
            'location' => new Point(54.49157249877584, 17.486612400901656),
            'rating' => 0
        ]);

        $wh33 = Warehouse::create([
            'name' => 'Mar-Pol Słupsk',
            'company_id' => $marpol->id,
            'address' => 'Pomorska 1, 76-200 Słupsk',
            'location' => new Point(54.469630470290646, 17.017768210802565),
            'rating' => 0
        ]);

        $wh34 = Warehouse::create([
            'name' => 'Emag Ustka',
            'company_id' => $emag->id,
            'address' => 'Słupska 12, Ustka',
            'location' => new Point(54.59249730637572, 16.865734000158383),
            'rating' => 0
        ]);

        $wh35 = Warehouse::create([
            'name' => 'F.H.U. AMBIT',
            'company_id' => $ambit->id,
            'address' => 'Przemysłowa 2, 76-248 Dębica Kaszubska',
            'location' => new Point(54.39465090766654, 17.153151607618756),
            'rating' => 0
        ]);

        $wh36 = Warehouse::create([
            'name' => 'BAT Czarna Dąbrówka',
            'company_id' => $psb->id,
            'address' => 'Przemysłowa 16, 77-116 Czarna Dąbrówka',
            'location' => new Point(54.37519653359302, 17.56071777880781),
            'rating' => 0
        ]);

        $wh37 = Warehouse::create([
            'name' => 'BAT Bytów',
            'company_id' => $psb->id,
            'address' => 'Generała Wybickiego 16, 77-100 Bytów',
            'location' => new Point(54.20499554383568, 17.49411708428024),
            'rating' => 0
        ]);

        $wh38 = Warehouse::create([
            'name' => 'BAT Kościerzyna',
            'company_id' => $psb->id,
            'address' => 'Żurawinowa 52, 83-400 Kościerzyna',
            'location' => new Point(54.13735036273762, 17.94275315040338),
            'rating' => 0
        ]);

        $wh39 = Warehouse::create([
            'name' => 'Profi Harat',
            'company_id' => $psb->id,
            'address' => 'Dworcowa 16, 77-200 Miastko',
            'location' => new Point(54.01825402955259, 16.963474527698374),
            'rating' => 0
        ]);

        $wh40 = Warehouse::create([
            'name' => 'Czapiewski Michał',
            'company_id' => $czapiewskimichal->id,
            'address' => 'Dąbrowska 31, 83-441 Wiele',
            'location' => new Point(53.940430430681, 17.857572988911105),
            'rating' => 0
        ]);

        $wh41 = Warehouse::create([
            'name' => 'GS Samopomoc Chłopska',
            'company_id' => $gssamopomocchlopska->id,
            'address' => 'Dworcowa 13, 89-632 Brusy',
            'location' => new Point(53.89837479840425, 17.73123022573519),
            'rating' => 0
        ]);

        $wh42 = Warehouse::create([
            'name' => 'Damet',
            'company_id' => $damet->id,
            'address' => 'Chojnicka 57, 89-652 Łąg',
            'location' => new Point(53.8461394320946, 18.067572635612912),
            'rating' => 0
        ]);

        $wh43 = Warehouse::create([
            'name' => 'Ginter Kazimierz',
            'company_id' => $ginterkazimierz->id,
            'address' => 'Długa 1, 89-600 Chojnice',
            'location' => new Point(53.715133018506, 17.591243686665344),
            'rating' => 0
        ]);

        $wh44 = Warehouse::create([
            'name' => 'Almiron',
            'company_id' => $almiron->id,
            'address' => 'Jabłoniowa 43, 89-600 Chojnice',
            'location' => new Point(53.72138134456072, 17.549602375981582),
            'rating' => 0
        ]);

        $wh45 = Warehouse::create([
            'name' => 'Trops',
            'company_id' => $psb->id,
            'address' => 'dr Karasiewicza 12, 89-500 Tuchola',
            'location' => new Point(53.60670939760487, 17.858604151848184),
            'rating' => 0
        ]);

        $wh46 = Warehouse::create([
            'name' => 'Różyński Czesław',
            'company_id' => $rozynskiczeslaw->id,
            'address' => 'Szkolna 32, 86-150 Osie',
            'location' => new Point(53.6430064917837, 18.346879716430124),
            'rating' => 0
        ]);

        $wh47 = Warehouse::create([
            'name' => 'BAT Zblewo',
            'company_id' => $psb->id,
            'address' => 'Pinczyńska 1, 83-210 Zblewo',
            'location' => new Point(53.97816684023596, 18.324890520110067),
            'rating' => 0
        ]);

        $wh48 = Warehouse::create([
            'name' => 'Boker FHU',
            'company_id' => $bokerfhu->id,
            'address' => 'Klasztorna 27, 83-400 Kościerzyna',
            'location' => new Point(54.12306232229195, 17.981576452801647),
            'rating' => 0
        ]);

        $wh49 = Warehouse::create([
            'name' => 'BAT Stara Kiszewa',
            'company_id' => $psb->id,
            'address' => 'Kościerska 42, 83-430 Stara Kiszewa',
            'location' => new Point(54.001327548527094, 18.18050261463189),
            'rating' => 0
        ]);

        $wh50 = Warehouse::create([
            'name' => 'BOWMAT',
            'company_id' => $bowmat->id,
            'address' => 'Długa 19, 83-323 Kamienica Szlachecka',
            'location' => new Point(54.227880806881, 18.09765761066617),
            'rating' => 0
        ]);

        $wh51 = Warehouse::create([
            'name' => 'Zaborowski Jan',
            'company_id' => $zaborowskijan->id,
            'address' => 'Długa 43, 83-315 Szymbark',
            'location' => new Point(54.227880806881, 18.09765761066617),
            'rating' => 0
        ]);
        
        $wh52 = Warehouse::create([
            'name' => 'Izobud',
            'company_id' => $izobud->id,
            'address' => 'Dworcowa 3, 83-314 Somonino',
            'location' => new Point(54.27375689870203, 18.18913977238194),
            'rating' => 0
        ]);

        $wh53 = Warehouse::create([
            'name' => 'BAT Kartuzy',
            'company_id' => $psb->id,
            'address' => 'Węglowa 8, 83-300 Kartuzy',
            'location' => new Point(54.3395733060761, 18.20912477162248),
            'rating' => 0
        ]);

        $wh54 = Warehouse::create([
            'name' => 'BAT Sierkawice Centrala',
            'company_id' => $psb->id,
            'address' => 'Mirachowska 31, 83-340 Sierakowice',
            'location' => new Point(54.36235885518814, 17.900248948046322),
            'rating' => 0
        ]);

        $wh55 = Warehouse::create([
            'name' => 'BAT Sierkawice',
            'company_id' => $psb->id,
            'address' => 'Ks. B. Sychty. 42, 83-340 Sierakowice',
            'location' => new Point(54.354551625040166, 17.882025181890754),
            'rating' => 0
        ]);

        $wh56 = Warehouse::create([
            'name' => 'BAT Lębork',
            'company_id' => $psb->id,
            'address' => 'Majkowskiego 10, 84-300 Lębork',
            'location' => new Point(54.54219822545325, 17.767075929708323),
            'rating' => 0
        ]);

        $wh57 = Warehouse::create([
            'name' => 'Leroy Merlin Rumia',
            'company_id' => $leroyMerlin->id,
            'address' => 'Grunwaldzka 108, 84-230 Rumia',
            'location' => new Point(54.58928879401227, 18.370650787275732),
            'rating' => 0
        ]);

        $wh58 = Warehouse::create([
            'name' => 'Almares',
            'company_id' => $almares->id,
            'address' => 'Krótka 4, 84-110 Krokowa',
            'location' => new Point(54.77804572872941, 18.161471992273746),
            'rating' => 0
        ]);

        $wh59 = Warehouse::create([
            'name' => 'Delta',
            'company_id' => $delta->id,
            'address' => 'Kolejowa 21, 81-110 Krokowa',
            'location' => new Point(54.78256820068881, 18.16067516192641),
            'rating' => 0
        ]);

        $wh60 = Warehouse::create([
            'name' => 'CMB TIM',
            'company_id' => $cmbtim->id,
            'address' => 'Pucka 87, 81-061 Gdynia',
            'location' => new Point(54.5512295237829, 18.467367942732167),
            'rating' => 0
        ]);

        $wh61 = Warehouse::create([
            'name' => 'P.U.H. Smok',
            'company_id' => $puhSmok->id,
            'address' => 'Chwaszczyńska 2, 81-571 Gdynia',
            'location' => new Point(54.471316546970606, 18.497129661810256),
            'rating' => 0
        ]);

        $wh62 = Warehouse::create([
            'name' => 'OBI Kołobrzeska',
            'company_id' => $obi->id,
            'address' => 'Kołobrzeska 26, 80-394 Gdańsk',
            'location' => new Point(54.40160704220366, 18.583452046388594),
            'rating' => 0
        ]);

        $wh63 = Warehouse::create([
            'name' => 'Aga-M',
            'company_id' => $agaM->id,
            'address' => 'Kartuska 249, 80-125 Gdańsk',
            'location' => new Point(54.3462294796281, 18.595778099854552),
            'rating' => 0
        ]);

        $wh64 = Warehouse::create([
            'name' => 'FHU Millenium',
            'company_id' => $millenium->id,
            'address' => 'Generała Władysława Sikorskiego 2C, 83-004 Pruszcz Gdański',
            'location' => new Point(54.24841772300915, 18.638628910189798),
            'rating' => 0
        ]);

        $wh65 = Warehouse::create([
            'name' => 'Koszałka Pruszcz Gdański',
            'company_id' => $koszalka->id,
            'address' => 'Kupiecka 2, 83-000 Pruszcz Gdański',
            'location' => new Point(54.24490718047673, 18.618029546628506),
            'rating' => 0
        ]);

        $wh66 = Warehouse::create([
            'name' => 'Trops',
            'company_id' => $psb->id,
            'address' => 'Zastawna 31, 83-000 Pruszcz Gdański',
            'location' => new Point(54.24244161303529, 18.619951189763658),
            'rating' => 0
        ]);

        $wh67 = Warehouse::create([
            'name' => 'BAT Pruszcz Gdański',
            'company_id' => $psb->id,
            'address' => 'Tczewska 6, 83-000 Pruszcz Gdański',
            'location' => new Point(54.241355148930744, 18.627885929513546),
            'rating' => 0
        ]);

        $wh68 = Warehouse::create([
            'name' => 'BROKER Tczew',
            'company_id' => $psb->id,
            'address' => 'Aleja Solidarności 29, 83-110 Tczew',
            'location' => new Point(54.11254594999396, 18.76126349225795),
            'rating' => 0
        ]);

        $wh69 = Warehouse::create([
            'name' => 'Mrówka',
            'company_id' => $psb->id,
            'address' => 'Jagiellońska 55, 83-110 Tczew',
            'location' => new Point(54.09271145076282, 18.78698269991742),
            'rating' => 0
        ]);

        $wh70 = Warehouse::create([
            'name' => 'Trops',
            'company_id' => $psb->id,
            'address' => '30 Stycznia, 83-110 Tczew',
            'location' => new Point(54.071961941242726, 18.780575987495777),
            'rating' => 0
        ]);

        $wh71 = Warehouse::create([
            'name' => 'Profi Sambor',
            'company_id' => $psb->id,
            'address' => '30 Stycznia 40, 83-110 Tczew',
            'location' => new Point(54.067276087111, 18.77490792728774),
            'rating' => 0
        ]);

        $wh72 = Warehouse::create([
            'name' => 'Grzesik Tczewska',
            'company_id' => $psb->id,
            'address' => 'Tczewska 12, 82-200 Malbork',
            'location' => new Point(54.043644770183334, 19.012970384295517),
            'rating' => 0
        ]);

        $wh73 = Warehouse::create([
            'name' => 'Grzesik Koszykowa',
            'company_id' => $psb->id,
            'address' => 'Koszykowa 7, 82-200 Malbork',
            'location' => new Point(54.03757204026103, 19.062743249015977),
            'rating' => 0
        ]);

        $wh74 = Warehouse::create([
            'name' => 'Mrówka',
            'company_id' => $psb->id,
            'address' => 'Zblewska 9, 83-200 Starogard Gdański',
            'location' => new Point(53.963986679793884, 18.502200255228697),
            'rating' => 0
        ]);

        $wh75 = Warehouse::create([
            'name' => 'MAT BUD',
            'company_id' => $matbud->id,
            'address' => 'Skarszewska 2, 83-250 Starogard Gdański',
            'location' => new Point(53.973726719009655, 18.5238650357204),
            'rating' => 0
        ]);

        $wh76 = Warehouse::create([
            'name' => 'BROKER',
            'company_id' => $psb->id,
            'address' => 'Hieronima Derdowskiego 4, 83-200 Starogard Gdański',
            'location' => new Point(53.98452239391569, 18.52810085544784),
            'rating' => 0
        ]);

        $wh77 = Warehouse::create([
            'name' => 'Mrówka',
            'company_id' => $psb->id,
            'address' => 'Malborska 122, 82-500 Kwidzyn',
            'location' => new Point(53.751176387856304, 18.937382862567407),
            'rating' => 0
        ]);

        $wh78 = Warehouse::create([
            'name' => 'Mrówka',
            'company_id' => $psb->id,
            'address' => 'Malborska 122, 82-500 Kwidzyn',
            'location' => new Point(53.751176387856304, 18.937382862567407),
            'rating' => 0
        ]);

        $wh79 = Warehouse::create([
            'name' => 'Ambit',
            'company_id' => $ambit->id,
            'address' => 'Długa 44, 82-500 Kwidzyn',
            'location' => new Point(53.744559089745515, 18.944440892241758),
            'rating' => 0
        ]);

        $wh80 = Warehouse::create([
            'name' => 'Bricomarche Kwidzyn',
            'company_id' => $bricomarche->id,
            'address' => 'Warszawska 76, 82-500 Kwidzyn',
            'location' => new Point(53.73560470270051, 18.94686971363011),
            'rating' => 0
        ]);

        $wh81 = Warehouse::create([
            'name' => 'Rodło',
            'company_id' => $rodlo->id,
            'address' => '11 Listopada 26, 82-500 Kwidzyn',
            'location' => new Point(53.73016293440011, 18.92585066033325),
            'rating' => 0
        ]);

        $wh82 = Warehouse::create([
            'name' => 'Paulin',
            'company_id' => $paulin->id,
            'address' => 'Spacerowa 2, 82-500 Rakowiec',
            'location' => new Point(53.730819178887494, 19.03526787623519),
            'rating' => 0
        ]);

        $wh83 = Warehouse::create([
            'name' => 'Wasilak',
            'company_id' => $wasilak->id,
            'address' => 'Ignacego Daszyńskiego 17, 82-550 Prabuty',
            'location' => new Point(53.75663539978384, 19.205788680894866),
            'rating' => 0
        ]);

        $wh84 = Warehouse::create([
            'name' => 'Westa',
            'company_id' => $westa->id,
            'address' => '82-450 Stary Dzierzgoń',
            'location' => new Point(53.84196688281221, 19.403092977273978),
            'rating' => 0
        ]);

        $wh85 = Warehouse::create([
            'name' => 'NordBud',
            'company_id' => $nordbud->id,
            'address' => 'Kopernika 2, 82-230 Nowy Staw',
            'location' => new Point(54.138125523120394, 19.008369164933),
            'rating' => 0
        ]);

        $wh86 = Warehouse::create([
            'name' => 'Sambor',
            'company_id' => $sambor->id,
            'address' => 'Generała Józefa Bema 2, 82-230 Nowy Staw',
            'location' => new Point(54.133999475833626, 19.015040836530623),
            'rating' => 0
        ]);

        $wh87 = Warehouse::create([
            'name' => 'Sław-Bud',
            'company_id' => $slawbud->id,
            'address' => 'Warszawska 44, 82-100 Nowy Dwór Gdański',
            'location' => new Point(54.208795703398835, 19.12913696136301),
            'rating' => 0
        ]);

        $wh88 = Warehouse::create([
            'name' => 'Koszałka Kartuzy',
            'company_id' => $koszalka->id,
            'address' => '3 Maja 35, 83-300 Kartuzy',
            'location' => new Point(54.338260302189966, 18.205049177044224),
            'rating' => 0
        ]);

        $wh89 = Warehouse::create([
            'name' => 'Cel-Bud FHU.',
            'company_id' => $celbud->id,
            'address' => 'Lęborska 16, 83-321 Mściszewice',
            'location' => new Point(54.2622442253592, 17.85497081998566),
            'rating' => 0
        ]);

        $wh90 = Warehouse::create([
            'name' => 'Mrówka Lębork',
            'company_id' => $psb->id,
            'address' => 'Żeromskiego 7A, 84-300 Lębork',
            'location' => new Point(54.53119134550482, 17.7462440863949),
            'rating' => 0
        ]);

        $wh91 = Warehouse::create([
            'name' => 'Koszałka Lębork',
            'company_id' => $koszalka->id,
            'address' => 'Długa 34, 84-300 Mosty',
            'location' => new Point(54.55126829175914, 17.79760787026624),
            'rating' => 0
        ]);


        // Opening Hours
        $warehouses = [$wh1, $wh2, $wh3, $wh4, $wh5, $wh6, $wh7, $wh8, $wh9, 
            $wh10, $wh11, $wh12, $wh13, $wh14, $wh15, $wh16, $wh17, $wh18, $wh19, 
            $wh20, $wh21, $wh22, $wh23, $wh24, $wh25, $wh26, $wh27, $wh28, $wh29, 
            $wh30, $wh31, $wh32, $wh33, $wh34, $wh35, $wh36, $wh37, $wh38, $wh39, 
            $wh30, $wh31, $wh32, $wh33, $wh34, $wh35, $wh36, $wh37, $wh38, $wh39,
            $wh40, $wh41, $wh42, $wh43, $wh44, $wh45, $wh46, $wh47, $wh48, $wh49,
            $wh50, $wh51, $wh52, $wh53, $wh54, $wh55, $wh56, $wh57, $wh58, $wh59,
            $wh60, $wh61, $wh62, $wh63, $wh64, $wh65, $wh66, $wh67, $wh68, $wh69,
            $wh70, $wh71, $wh72, $wh73, $wh74, $wh75, $wh76, $wh77, $wh78, $wh79,
            $wh80, $wh81, $wh82, $wh83, $wh84, $wh85, $wh86, $wh87, $wh88, $wh89,
            $wh90, $wh91];
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
