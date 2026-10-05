<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\News;
use App\Models\Category;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();

        $news = News::orderBy('id', 'desc')
            ->limit(3)
            ->get();

        $categories = Category::all();

// キャッシュキーを変更し、余計なトラブルを防ぐ
        $rankingIds = Cache::remember('new_ranking_ids_v3', 60, function () {
            return OrderDetail::select('product_id', DB::raw('sum(quantity) as total_quantity'))
                ->groupBy('product_id')
                ->orderBy('total_quantity', 'desc')
                ->limit(5)
                ->pluck('product_id')
                ->toArray(); // ← 配列として確実に保存する
        });

        // 取得したIDから商品モデルを再取得
        $rankingProducts = Product::whereIn('id', $rankingIds)->get();

        // 万が一注文データが少なくてランキングが取れない場合のフォールバック（新着順）
        if ($rankingProducts->isEmpty()) {
            $rankingProducts = Product::orderBy('id', 'desc')->limit(5)->get();
        }

        return view('index', [
            'products' => $products,
            'news' => $news,
            'categories' => $categories,
            'rankingProducts' => $rankingProducts,
        ]);
    }

    public function show(Product $product)
    {
        // 購入者判定（ログイン中かつ、この商品を購入したことがあるか）
        $hasPurchased = false;
        if (auth()->check()) {
            $hasPurchased = auth()->user()->orders()
                ->whereHas('details', function ($query) use ($product) {
                    $query->where('product_id', $product->id);
                })->exists();
        }

        // レビュー一覧を取得
        $reviews = $product->reviews()->with('user')->latest()->get();

        return view('products.show', [
            'product' => $product,
            'hasPurchased' => $hasPurchased,
            'reviews' => $reviews,
        ]);
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');

        $products = Product::where('name', 'like', "%{$keyword}%")->get();
        $categories = Category::all();
        $news = News::orderBy('id', 'desc')
            ->limit(3)
            ->get();
        $rankingProducts = Product::limit(5)->get();

        return view('index', [
            'products' => $products,
            'news' => $news,
            'categories' => $categories,
            'rankingProducts' => $rankingProducts,
        ]);
    }

    public function category(Category $category)
    {
        return view('category', [
            'category' => $category,
        ]);
    }
}