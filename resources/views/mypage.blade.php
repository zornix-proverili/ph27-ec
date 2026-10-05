@extends('layouts.base')

@section('title', 'マイページ')

@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ul>
            <li><a href="/">ホーム</a></li>
            <li>マイページ</li>
        </ul>
    </nav>
@endsection

@section('content')
    <h1>マイページ</h1>
    <p>ようこそ、{{ $user->name }}さん！</p>

    <h2>お気に入り商品</h2>
    @if ($favoriteProducts->isEmpty())
        <p>お気に入り登録している商品はありません。</p>
    @else
        <ul>
            @foreach ($favoriteProducts as $product)
                <li>
                    <a href="/products/{{ $product->id }}">{{ $product->name }}</a> （{{ number_format($product->price) }}円）
                </li>
            @endforeach
        </ul>
    @endif

    <h2>注文履歴</h2>
    <p><a href="/orders">注文履歴一覧を見る</a></p>
@endsection
