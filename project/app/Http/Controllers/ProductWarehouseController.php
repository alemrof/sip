<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Warehouse;
use App\Models\Company;
use App\Models\Product;

class ProductWarehouseController extends Controller
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
    public function index($id)
    {
        $warehouse = Warehouse::find($id);
        if ($warehouse) {
            $products = $warehouse->products;
            return view('offers.index', compact('products', 'warehouse'));
        } else {
            return redirect('/warehouses/' . $id);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $warehouse = Warehouse::find($id);
        if ($warehouse) {
            $products = Product::all();
            if ($products) {
                return view('offers.create', compact('products', 'warehouse'));
            } else {
                return redirect('/products/');    
            }
        } else {
            return redirect('/warehouses/' . $id);
        }
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
            'warehouse_id'=>'required|exists:warehouses,id',
            'product_id'=>'required|exists:products,id',
            'price'=>'required|max:999|min:0'
        ]);
        $warehouse = Warehouse::find($request->warehouse_id);
        if ($warehouse) {
            $warehouse->products()->detach($request->product_id);
            $warehouse->products()->attach($request->product_id, ['price' => $request->price]);
        } else {
            return redirect('/warehouses/');
        }
        return redirect('/warehouses/' . $request->warehouse_id . '/offer')
            ->with('success', 'Dodano produkt do oferty magazynu.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Warehouse  $warehouse
     * @return \Illuminate\Http\Response
     */
    public function show($warehouse_id, $id)
    {
        $warehouse = Warehouse::find($warehouse_id);

        if ($warehouse) {
            $products = $warehouse->products;
            if ($products) {
                foreach ($products as $product) {
                    if ($product->pivot->id == $id) {
                        return view('offers.show', compact('product', 'warehouse'));
                    }
                }
            }
            return redirect('/warehouses/' . $warehouse_id . '/offer');
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
    public function edit($warehouse_id, $id)
    {
        $warehouse = Warehouse::find($warehouse_id);

        if ($warehouse) {
            $products = $warehouse->products;
            if ($products) {
                foreach ($products as $product) {
                    if ($product->pivot->id == $id) {
                        return view('offers.edit', compact('product', 'warehouse'));
                    }
                }
            }
            return redirect('/warehouses/' . $warehouse_id . '/offer');
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
    public function update(Request $request)
    {
        $this->validate($request, [
            'warehouse_id'=>'required|exists:warehouses,id',
            'product_id'=>'required|exists:products,id',
            'price'=>'required|max:999|min:0'
        ]);
        $warehouse = Warehouse::find($request->warehouse_id);
        if ($warehouse) {
            $warehouse->products()->detach($request->product_id);
            $warehouse->products()->attach($request->product_id, ['price' => $request->price]);
        } else {
            return redirect('/warehouses/');
        }
        return redirect('/warehouses/' . $request->warehouse_id . '/offer')
            ->with('success', 'Zaktualizowano ofertę magazynu.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Warehouse  $warehouse
     * @return \Illuminate\Http\Response
     */
    public function destroy($warehouse_id, $id)
    {
        $warehouse = Warehouse::find($warehouse_id);
        if ($warehouse) {
            $warehouse->products()->detach($id);
        }
        return redirect('/warehouses/'. $warehouse_id . '/offer')
            ->with('success', 'Usunięto produkt z oferty magazynu.');
    }
}
