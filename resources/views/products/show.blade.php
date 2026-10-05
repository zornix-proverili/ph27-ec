@extends('layouts.base')

@section('title', $product->name)

@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ul>
            <li><a href="/">ホーム</a></li>
            @if ($product->category)
                <li><a href="/categories/{{ $product->category->id }}">{{ $product->category->name }}</a></li>
            @endif
            <li>{{ $product->name }}</li>
        </ul>
    </nav>
@endsection

@section('content')
    @if (session('message'))
        <article style="background-color: #e3f8ff; color: #00658f; padding: 1rem;">
            {{ session('message') }}
        </article>
    @endif

    <h2>{{ $product->name }}</h2>
    <div>
        カテゴリー:
        @if ($product->category)
            <a href="/categories/{{ $product->category->id }}">
                {{ $product->category->name }}
            </a>
        @endif
    </div>

    <img src="{{ $product->imageUrl() }}" width="400" alt="{{ $product->name }}">
    <p style="font-size: 1.25rem; font-weight: bold;">{{ number_format($product->price) }}円</p>
    <p>{{ $product->description }}</p>

    @if ($product->stock <= 0)
        <p style="color: red; font-weight: bold;">売り切れ</p>
    @elseif ($product->stock <= 5)
        <p style="color: orange;">残りわずか</p>
    @else
        <p>在庫あり</p>
    @endif

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <article style="background-color: #ffe3e3; color: #c92a2a; padding: 0.5rem;">
                {{ $error }}
            </article>
        @endforeach
    @endif

    @if ($product->stock > 0)
        <form action="/cart" method="POST">
            @csrf
            個数:<input type="number" name="quantity" min="1" max="{{ $product->stock }}"
                value="{{ old('quantity', 1) }}">
            <input type="hidden" name="productId" value="{{ $product->id }}">
            <input type="submit" value="カートに入れる">
        </form>
    @endif

    <hr style="margin: 2rem 0;">

    {{-- レビューセクション --}}
    <section>
        <h3>商品レビュー</h3>

        @if ($reviews->isEmpty())
            <p>まだレビューはありません。</p>
        @else
            @foreach ($reviews as $review)
                <article style="margin-bottom: 1rem; padding: 1rem; border: 1px solid #ddd;">
                    <p><strong>{{ $review->user->name }}</strong> （評価: {{ $review->rating }} / 5）</p>
                    <p>{{ $review->comment }}</p>
                    <small style="color: gray;">投稿日: {{ $review->created_at->format('Y/m/d H:i') }}</small>
                </article>
            @endforeach
        @endif

        @auth
            @if ($hasPurchased)
                <div style="margin-top: 2rem; background: #f9f9f9; padding: 1.5rem; border-radius: 8px;">
                    <h4>レビューを投稿する</h4>
                    <form action="/products/{{ $product->id }}/reviews" method="POST">
                        @csrf
                        <div>
                            <label>評価 (1〜5):</label>
                            <select name="rating" required>
                                <option value="5">★★★★★ (5)</option>
                                <option value="4">★★★★☆ (4)</option>
                                <option value="3">★★★☆☆ (3)</option>
                                <option value="2">★★☆☆☆ (2)</option>
                                <option value="1">★☆☆☆☆ (1)</option>
                            </select>
                        </div>
                        <div style="margin-top: 1rem;">
                            <label>コメント:</label>
                            <textarea name="comment" rows="4" required placeholder="商品の感想をご記入ください">{{ old('comment') }}</textarea>
                        </div>
                        <button type="submit" style="margin-top: 1rem;">レビューを送信</button>
                    </form>
                </div>
            @else
                <p style="color: #666; margin-top: 1rem; font-style: italic;">※この商品を購入されたお客様のみレビューを投稿できます。</p>
            @endif
        @else
            <p style="margin-top: 1rem;"><a href="{{ route('login') }}">ログイン</a>すると、購入済み商品のレビューを投稿できます。</p>
        @endauth
    </section>
@endsection
