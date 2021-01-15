<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Warehouse;


class AdminsController extends Controller
{
    public function index() {
        $warehouses = Warehouse::with('company')->get();
        $warehouses = $warehouses->where('location', '!=' ,null);
        return view('admin.index', ['warehouses' => $warehouses]);
    }
}