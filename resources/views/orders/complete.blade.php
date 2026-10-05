@extends('layouts.base')

@section('title', '注文完了')

@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ul>
            <li><a href="/">ホーム</a></li>
            <li><a href="/cart">ショッピングカート</a></li>
            <li>注文完了</li>
        </ul>
    </nav>
@endsection

@section('content')
    @if (session('message'))
        <article>{{ session('message') }}</article>
    @endif
    @if ($order)
        <p>注文ID: {{ $order->id }}</p>
    @endif
@endsection
