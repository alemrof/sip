<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Category;
use App\Models\Product;
//use App\Models\ProductWarehouse;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class SearchController extends Controller
{
    public function __construct()
    {
       // $this->middleware(['auth', 'isAdmin'], ['except' => ['index', 'show']]);
    }

    public function index()
    {
        $companies = Company::all();
        $categories = Category::all();
        $products = DB::select('
                            select distinct name,warehouse_id, price,x, y  from
                                        (SELECT c.name as category, k.name, k.manufacturer,k.company_id,k.price,k.warehouse_id,k.category_id, ST_X(k.location) as x, ST_Y(k.location) as y
                                        from categories as c
                                        INNER JOIN
                                            (SELECT  p.name, p.category_id, p.manufacturer,pww.company_id ,pww.price,pww.warehouse_id,pww.location
                                            FROM products as p
                                            INNER JOIN
                                                (select pwh.warehouse_id, pwh.product_id,pwh.price,w.company_id, w.location
                                                    from product_warehouse as pwh
                                                    inner join warehouses as w
                                                    on pwh.warehouse_id = w.id
                                                ) as pww
                                            ON p.id = pww.product_id
                                            ) as k
                                        ON c.id = k.category_id) as j
                            INNER JOIN
                             (select companies.id,companies.name as company from companies) as g
                            on
                            g.id=j.company_id
                            WHERE (j.category_id = ?)',[1]);

          return view('search.index',['companies' => $companies, 'categories' => $categories, 'products' => $products]);
    }

    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->validate([
            'cat' => 'required|max:255',
            'comp' => 'required|max:255'
        ]);

        if ($request['comp'] == 'Dowolna')
            $queryResult = DB::select(DB::raw('
                            select distinct name,warehouse_id,price,x,y from
                                        (SELECT c.name as category, k.name, k.manufacturer,k.company_id,k.price,k.warehouse_id, ST_X(k.location) as x, ST_Y(k.location) as y
                                        from categories as c
                                        INNER JOIN
                                            (SELECT  p.name, p.category_id, p.manufacturer,pww.company_id ,pww.price,pww.warehouse_id, pww.location
                                            FROM products as p
                                            INNER JOIN
                                                (select pwh.warehouse_id, pwh.product_id,pwh.price,w.company_id, w.location
                                                    from product_warehouse as pwh
                                                    inner join warehouses as w
                                                    on pwh.warehouse_id = w.id
                                                ) as pww
                                            ON p.id = pww.product_id
                                            ) as k
                                        ON c.id = k.category_id) as j
                            INNER JOIN
                             (select companies.id,companies.name as company from companies) as g
                            on
                            g.id=j.company_id
                            WHERE (j.category = ?)'),[$request['cat']]);
        else
            $queryResult = DB::select(DB::raw('
                            select distinct name,warehouse_id,price,x,y from
                                        (SELECT c.name as category, k.name, k.manufacturer,k.company_id,k.price,k.warehouse_id,ST_X(k.location) as x, ST_Y(k.location) as y
                                        from categories as c
                                        INNER JOIN
                                            (SELECT  p.name, p.category_id, p.manufacturer,pww.company_id ,pww.price,pww.warehouse_id,pww.location
                                            FROM products as p
                                            INNER JOIN
                                                (select pwh.warehouse_id, pwh.product_id,pwh.price,w.company_id,w.location
                                                    from product_warehouse as pwh
                                                    inner join warehouses as w
                                                    on pwh.warehouse_id = w.id
                                                ) as pww
                                            ON p.id = pww.product_id
                                            ) as k
                                        ON c.id = k.category_id) as j
                            INNER JOIN
                             (select companies.id,companies.name as company from companies) as g
                            on
                            g.id=j.company_id
                            WHERE (j.category = ? AND g.company = ?)'),[$request['cat'], $request['comp']]);
        return response()->json($queryResult);
    }
}
