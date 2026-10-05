@extends('layouts.base')

@section('title', $category->name)

@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ul>
            <li><a href="/">ホーム</a></li>
            <li>{{ $category->name }}</li>
        </ul>
    </nav>
@endsection

@section('content')
    <h1>{{ $category->name }}</h1>
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1rem;">
        @foreach ($category->products as $product)
            <article style="padding: 1rem;">
                <a href="/products/{{ $product->id }}" style="text-decoration: none;">
                    <img src="{{ $product->imageUrl() }}" alt="{{ $product->name }}" style="width: 100%; height: auto;">
                    <p style="margin-top: 0.5rem; font-weight: bold;">{{ $product->name }}</p>
                </a>
            </article>
        @endforeach
    </div>
@endsection
