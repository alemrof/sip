<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Warehouse;

class WarehouseController extends Controller
{
    public function show(Warehouse $warehouse) {
        return view('warehouse', ['warehouse'=>$warehouse]);
    }
}
