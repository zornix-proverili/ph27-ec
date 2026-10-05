@extends('layouts.base')

@section('title', '商品一覧')

@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ul>
            <li>ホーム</li>
        </ul>
    </nav>
@endsection

@section('content')

    {{-- カテゴリ一覧 --}}
    <h3>カテゴリ</h3>
    <ul>
        @foreach ($categories as $category)
            <li>
                {{-- slugを使っている場合はこちら --}}
                <a href="/categories/{{ $category->slug ?? $category->id }}">
                    {{ $category->name }}
                </a>
            </li>
        @endforeach
    </ul>

    <h2>売れ筋ランキング</h2>
    <ol>
        @foreach ($rankingProducts as $product)
            <li>
                <a href="/products/{{ $product->id }}">
                    {{ $product->name }} （{{ number_format($product->price) }}円）
                </a>
            </li>
        @endforeach
    </ol>

    <h2>商品一覧</h2>

    <form action="/search" method="GET">
        <input type="text" name="keyword" value="{{ request('keyword') }}">
        <input type="submit" value="検索">
    </form>

    @if (request('keyword'))
        <a href="/">検索結果をクリア</a>
    @endif

    {{-- 商品一覧 --}}
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1rem; margin-top: 1rem;">
        @foreach ($products as $product)
            <article style="padding: 1rem;">
                <a href="/products/{{ $product->id }}" style="text-decoration: none;">
                    <img src="{{ $product->imageUrl() }}" width="200" alt="{{ $product['name'] }}"
                        style="width: 100%; height: auto;">
                    <p style="margin-top: 0.5rem; font-weight: bold;">{{ $product['name'] }}</p>
                    <p>{{ number_format($product->price) }}円</p>
                </a>
            </article>
        @endforeach
    </div>

    {{-- お知らせ --}}
    <h2 class="news-title" style="margin-top: 2rem;">NEWS</h2>
    <h3 class="news-subtitle">お知らせ</h3>

    <div class="news-list">
        @foreach ($news as $item)
            <div class="news-item" style="margin-bottom: 1rem;">
                <h4 class="news-item-title">
                    <a href="/news/{{ $item->id }}">
                        {{ $item->title }}
                    </a>
                </h4>
                <p class="news-item-body">
                    {!! $item->content !!}
                </p>
            </div>
        @endforeach
    </div>

@endsection
