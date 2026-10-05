<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MyPageController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $orders = $user->orders()->latest()->get();
        $favoriteProducts = $user->favoriteProducts()->latest('favorites.created_at')->get();

        // ▼ 'mypage.index' ではなく 'mypage' にする
        return view('mypage', [
            'user' => $user,
            'orders' => $orders,
            'favoriteProducts' => $favoriteProducts,
        ]);
    }
}