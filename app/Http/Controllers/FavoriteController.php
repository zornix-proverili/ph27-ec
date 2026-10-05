<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Favorite;

class FavoriteController extends Controller
{
    // お気に入りの追加・解除（トグル処理）
    public function toggle(Product $product)
    {
        $user = auth()->user();

        $favorite = Favorite::where('user_id', $user->id)
            ->where('product_id', $product->id)
            ->first();

        if ($favorite) {
            $favorite->delete();
            return back()->with('message', 'お気に入りから解除しました。');
        } else {
            Favorite::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
            ]);
            return back()->with('message', 'お気に入りに追加しました。');
        }
    }
}