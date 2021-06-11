<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\WarehouseImage;
use App\Models\Warehouse;


class WarehouseImageController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'isAdmin'], ['except' => ['index', 'show']]);
    }

    public function store(Request $request, $warehouse_id)
    {
        $this->validate($request, [
            'image'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        $imageName = "warehouse_" . time() . '.' . $request->image->extension();
        $request->image->move(public_path('imgs/warehouses'), $imageName);

        $image = new WarehouseImage;
        $image->name = $imageName;
        $image->warehouse_id = $warehouse_id;
        $image->save();

        return back()
            ->with('success', 'Dodano nowe zdjęcie.')
            ->with('image', $imageName);
    }

    public function destroy(Request $request)
    {
        $image = WarehouseImage::find($request->id);
        if ($image) 
        {
            WarehouseImage::find($request->id)->delete();
            if (File::exists(public_path('imgs/warehouses').'/'.$image->name))
            {
                File::delete(public_path('imgs/warehouses').'/'.$image->name);
            }
        }
        return back()
            ->with('success', 'Zdjęcie zostało usunięte.');
    }
}
