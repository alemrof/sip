<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\ProductImage;
use App\Models\Product;

class ProductImageController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'isAdmin'], ['except' => ['index', 'show']]);
    }

    public function store(Request $request, $product_id)
    {
        $this->validate($request, [
            'image'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        $imageName = "product_" . time() . '.' . $request->image->extension();
        $request->image->move(public_path('imgs/products'), $imageName);

        $image = new ProductImage;
        $image->name = $imageName;
        $image->product_id = $product_id;
        $image->save();

        return back()
            ->with('success', 'Dodano nowe zdjęcie.')
            ->with('image', $imageName);
    }

    public function destroy(Request $request)
    {
        $image = ProductImage::find($request->id);
        if ($image) 
        {
            ProductImage::find($request->id)->delete();
            if (File::exists(public_path('imgs/products/').$image->name))
            {
                File::delete(public_path('imgs/products/').$image->name);
            }
        }
        return back()
            ->with('success', 'Zdjęcie zostało usunięte.');
    }
}
