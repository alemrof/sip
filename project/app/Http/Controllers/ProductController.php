<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
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
        $products = Product::with('category')->get();
        return view('products.index', ['products' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('products.create', ['categories' => $categories]);
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
            'name'=>'required|max:128',
            'category_id'=>'required',
            'manufacturer'=>'required|max:15'
        ]);
        Product::create($request->all());

        return redirect('/products')
            ->with('success', 'Dodano nowy produkt.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::with('category')->find($id);
        if ($product) {
            $comments = $product->productComments;
            $images = $product->productImages;

            return view('products.show', compact('product', 'comments', 'images'));
        } else {
            return redirect('/products');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::with('category')->find($id);
        $categories = Category::all();

        if ($product) {
            return view('products.edit', compact('product', 'categories'));
        } else {
            return redirect('/products');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        if ($product) {
            $this->validate($request, [
                'name'=>'required|max:128',
                'company_id'=>'required',
                'manufacturer'=>'required|max:15'
            ]);

            Product::find($id)->update($request->all());
        }
        return redirect('/products')
            ->with('success', 'Pomyślnie zedytowano produkt.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        if ($product) {
            Product::find($id)->delete();
        }
        return redirect('/products')
            ->with('success', 'Pomyślnie usunięto produkt.');
    }
}
