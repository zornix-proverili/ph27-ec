@extends('layouts.base')

@section('title', 'カート')

@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ul>
            <li><a href="/">ホーム</a></li>
            <li>ショッピングカート</li>
        </ul>
    </nav>
@endsection

@section('content')
    <h2>ショッピングカート</h2>

    @if (session('message'))
        <article style="background-color: #e3f8ff; color: #00658f; padding: 1rem; margin-bottom: 1rem;">
            {{ session('message') }}
        </article>
    @endif

    @if (empty($items) || count($items) === 0)
        <p>カートに商品がありません。</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>商品名</th>
                    <th>価格</th>
                    <th>数量</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
                    <tr>
                        <td>{{ $item['product']->name }}</td>
                        <td>{{ number_format($item['product']->price) }}円</td>
                        <td>{{ $item['quantity'] }}個</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <p style="font-size: 1.25rem; font-weight: bold;">合計: {{ number_format($totalPrice) }}円</p>

        <div style="display: flex; gap: 1rem; align-items: center; margin-top: 1rem;">
            <form action="/orders" method="POST">
                @csrf
                <button type="submit">購入する</button>
            </form>
            <a href="/cart/clear" role="button" class="secondary outline">カートを空にする</a>
        </div>
    @endif
@endsection
