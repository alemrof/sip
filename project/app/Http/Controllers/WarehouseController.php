<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Warehouse;
use App\Models\Company;

class WarehouseController extends Controller
{
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

        return redirect('/warehouses');
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
            return view('warehouses.show', compact('warehouse'));
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
        return redirect('/warehouses');
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
        return redirect('/warehouses');
    }
}