<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\OpeningHours;
use App\Models\Warehouse;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {
        $warehouses = Warehouse::with('company')->get();
        $warehouses = $warehouses->where('location', '!=' ,null);
        $openingHours = OpeningHours::all();
        return view(
            'index', 
            [
                'warehouses' => $warehouses,
                'openingHours' => $openingHours
            ]
        );
    }
}
