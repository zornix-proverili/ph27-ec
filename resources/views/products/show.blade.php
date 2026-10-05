@extends('layouts.base')

@section('title', $product->name)

@section('breadcrumbs')
    <nav aria-label="breadcrumb" class="breadcrumb-nav">
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
    <article>
        <h2>{{ $product->name }}</h2>
        <div>
            カテゴリー:
            @if ($product->category)
                <a href="/categories/{{ $product->category->id }}">
                    {{ $product->category->name }}
                </a>
            @else
                未分類
            @endif
        </div>

        <div style="margin: 1.5rem 0;">
            <img src="{{ $product->imageUrl() }}" width="400" alt="{{ $product->name }}">
        </div>

        <p style="font-size: 1.25rem; font-weight: bold;">{{ number_format($product->price) }}円</p>
        <p>{{ $product->description }}</p>

        @if ($product->stock <= 0)
            <p style="color: red; font-weight: bold;">売り切れ</p>
        @elseif ($product->stock <= 5)
            <p style="color: orange; font-weight: bold;">残りわずか（在庫: {{ $product->stock }}個）</p>
        @else
            <p>在庫あり（在庫: {{ $product->stock }}個）</p>
        @endif

        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <article style="background-color: #ffe3e3; color: #c92a2a; padding: 0.5rem; margin-bottom: 0.5rem;">
                    {{ $error }}
                </article>
            @endforeach
        @endif

        @if ($product->stock > 0)
            <form action="/cart" method="POST">
                @csrf
                <label>
                    個数:
                    <input type="number" name="quantity" min="1" max="{{ $product->stock }}"
                        class="@error('quantity') error @enderror" value="{{ old('quantity', 1) }}">
                </label>
                <input type="hidden" name="productId" value="{{ $product->id }}">
                <input type="submit" value="カートに入れる">
            </form>
        @endif
    </article>
@endsection
