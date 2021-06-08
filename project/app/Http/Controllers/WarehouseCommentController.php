<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WarehouseComment;
use App\Models\Warehouse;

class WarehouseCommentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth'], ['except' => ['index', 'show']]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request, $warehouse_id)
    {
        $this->validate($request, [
            'content'=>'required|max:255'
        ]);
        $comment = new WarehouseComment;
        $comment->content = $request->content;
        $comment->rating = $request->rating;
        $comment->warehouse_id = $warehouse_id;
        $comment->user_id = auth()->user()->id;
        $comment->save();

        if ($comment->rating != 0)
        {
            $warehouse = Warehouse::find($warehouse_id);
            if ($warehouse) 
            {
                $warehouse->calculateRating();
            }
        }

        return redirect('/warehouses/' . $warehouse_id);
    }

    public function destroy(Request $request)
    {
        $comment = WarehouseComment::find($request->id);
        if ($comment) 
        {
            WarehouseComment::find($request->id)->delete();
            $warehouse = Warehouse::find($request->warehouse_id);
            if ($warehouse) 
            {
                $warehouse->calculateRating();
            }
        }
        return redirect('/warehouses/'. $request->warehouse_id);
    }
}