<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Category;
use App\Models\OpeningHours;
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
        $warehouses = Warehouse::with('company')->get();
        $warehouses = $warehouses->where('location', '!=' ,null);
        $openingHours = OpeningHours::all();
        $companies = Company::all();
        $categories = Category::all();
        $products = DB::select(DB::raw('
                            select distinct name from
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
                            WHERE (j.category = ? AND g.company = ?)'),["Cementy i Zaprawy", "Castorama"]);

          return view('search.index',['companies' => $companies, 'categories' => $categories, 'products' => $products,'warehouses' => $warehouses]);
    }

    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'cat' => 'required|max:255',
            'comp' => 'required|max:255'
        ]);

        if ($request['comp'] == 'Dowolna')
            $queryResult = DB::select(DB::raw('
                            select distinct name from
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
                            select distinct name from
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
    public function show(Request $request)
    {
        $request->validate([
            'cat' => 'required|max:255',
            'comp' => 'required|max:255',
            'name' => 'required|max:255',

        ]);

        if ($request['comp'] == 'Dowolna'){
            $queryResult = DB::select(DB::raw('
                            select distinct name,product_id as id, manufacturer, category,price,warehouse_id, x, y,company from
                                        (SELECT c.name as category, k.name, k.manufacturer,k.company_id,k.price,k.warehouse_id, ST_X(k.location) as x, ST_Y(k.location) as y, k.product_id
                                        from categories as c
                                        INNER JOIN
                                            (SELECT  p.name, p.category_id, p.manufacturer,pww.company_id ,pww.price,pww.warehouse_id, pww.location,pww.product_id
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
                            WHERE (j.category = ? AND j.name = ?)
                            ORDER BY j.price'),[$request['cat'],$request['name']]);}

        else
            $queryResult = DB::select(DB::raw('
                            select distinct name,product_id as id, manufacturer, category,price,warehouse_id, x, y, company from
                                        (SELECT c.name as category, k.name, k.manufacturer,k.company_id,k.price,k.warehouse_id,ST_X(k.location) as x, ST_Y(k.location) as y,k.product_id
                                        from categories as c
                                        INNER JOIN
                                            (SELECT  p.name, p.category_id, p.manufacturer,pww.company_id ,pww.price,pww.warehouse_id,pww.location,pww.product_id
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
                            WHERE (j.category = ? AND g.company = ? AND j.name = ?)
                            ORDER BY j.price'),[$request['cat'], $request['comp'],$request['name']]);
        $products=$queryResult;

        return view('search.show', compact('products'));

    }

}
