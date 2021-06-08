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
    public function index($id=0) {

        if ($id == 0){
            $warehouses = Warehouse::with('company')->get();
            $warehouses = $warehouses->where('location', '!=' ,null);
            $openingHours = OpeningHours::all();
        }
        else{
            $warehouses = Warehouse::with('company')->get();
            $warehouses = $warehouses->where('id', '=' ,$id);
            $openingHours = OpeningHours::all();
        }

        return view(
            'index',
            [
                'warehouses' => $warehouses,
                'openingHours' => $openingHours
            ]
        );
    }
    public function updateCoords(Request $request)
    {
        $data = $request->validate([
            'x' => 'required',
            'y' => 'required'
        ]);

        session()->put('x',(float)$data['x']);
        session()->put('y',(float)$data['y']);
        session()->save();
        return response()->json($data);
    }

}
