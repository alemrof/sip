<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Warehouse;
use App\Models\Company;
use App\Models\WarehouseComment;
use Grimzy\LaravelMysqlSpatial\Types\Point;

class WarehouseController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'isAdmin'], ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $warehouses = Warehouse::with('company')->get();
        return view('warehouses.index', ['warehouses' => $warehouses]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $companies = Company::all();
        return view('warehouses.create', ['companies' => $companies]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'=>'required|max:15',
            'company_id'=>'required',
            'address'=>'required|max:40'
        ]);
        Warehouse::create($request->all());

        return redirect('/warehouses')
            ->with('success', 'Dodano nowy magazyn.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Warehouse  $warehouse
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $warehouse = Warehouse::with('company')->find($id);
        
        if ($warehouse) {
            $comments = $warehouse->warehouseComments;
            $images = $warehouse->warehouseImages;
            
            return view('warehouses.show', compact('warehouse', 'comments', 'images'));
        } else {
            return redirect('/warehouses');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Warehouse  $warehouse
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $warehouse = Warehouse::with('company')->find($id);
        $companies = Company::all();

        if ($warehouse) {
            return view('warehouses.edit', compact('warehouse', 'companies'));
        } else {
            return redirect('/warehouses');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Warehouse  $warehouse
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $warehouse = Warehouse::find($id);

        if ($warehouse) {
            $this->validate($request, [
                'name'=>'required|max:15',
                'company_id'=>'required',
                'address'=>'required|max:40'
            ]);
            
            Warehouse::find($id)->update($request->all());
        }
        return redirect('/warehouses')
            ->with('success', 'Pomyślnie zedytowano magazyn.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Warehouse  $warehouse
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $warehouse = Warehouse::find($id);
        if ($warehouse) {
            Warehouse::find($id)->delete();
        }
        return redirect('/warehouses')
            ->with('success', 'Pomyślnie usunięto magazyn.');
    }

    public function editMap($id)
    {
        $warehouses = Warehouse::with('company')->get();
        $warehouses = $warehouses->where('location', '!=' ,null);

        if ($warehouses) {
            return view('warehouses.editMap', compact('warehouses', 'id'));
        } else {
            return redirect('/warehouses');
        }
    }

    public function updateMap(Request $request, $id)
    {
        $warehouse = Warehouse::find($id);
        
        if ($warehouse) {
            $newLocation = new Point($request->lon, $request->lat);
            $warehouse->location = $newLocation;
            $warehouse->save();
        } 

        return redirect('/');
    }
}