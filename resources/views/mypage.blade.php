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
    <h2>マイページ</h2>
    <ul>
        <li><a href="/orders">注文履歴を見る</a></li>
    </ul>
@endsection
