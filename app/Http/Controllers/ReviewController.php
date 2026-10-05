<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Product;

class ReviewController extends Controller
{
    public function store(Request $request, Product $product)
    {
        // 購入者判定
        $hasPurchased = auth()->user()->orders()
            ->whereHas('details', function ($query) use ($product) {
                $query->where('product_id', $product->id);
            })->exists();

        if (!$hasPurchased) {
            return back()->withErrors(['review' => 'この商品を購入した方のみレビューを投稿できます。']);
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        Review::create([
            'product_id' => $product->id,
            'user_id' => auth()->id(),
            'rating' => $request->input('rating'),
            'comment' => $request->input('comment'),
        ]);

        return redirect()->route('products.show', $product->id)->with('message', 'レビューを投稿しました。');
    }
}