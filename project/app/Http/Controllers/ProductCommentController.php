<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductComment;
use App\Models\Product;

class ProductCommentController extends Controller
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

    public function store(Request $request, $product_id)
    {
        $this->validate($request, [
            'content'=>'required|max:255'
        ]);
        $comment = new ProductComment;
        $comment->content = $request->content;
        $comment->rating = $request->rating;
        $comment->product_id = $product_id;
        $comment->user_id = auth()->user()->id;
        $comment->save();

        if ($comment->rating != 0)
        {
            $product = Product::find($product_id);
            if ($product) 
            {
                $product->calculateRating();
            }
        }
        return back()
            ->with('success', 'Dziękujemy za Twoją ocenę!.');
    }

    public function destroy(Request $request)
    {
        $comment = ProductComment::find($request->id);
        if ($comment) 
        {
            ProductComment::find($request->id)->delete();
            $product = Product::find($request->product_id);
            if ($product) 
            {
                $product->calculateRating();
            }
        }
        return redirect('/products/'. $request->product_id);
    }
}
