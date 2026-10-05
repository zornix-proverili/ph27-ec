@extends('layouts.base')

@section('title', '注文履歴')

@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ul>
            <li><a href="/">ホーム</a></li>
            <li><a href="/mypage">マイページ</a></li>
            <li>注文履歴</li>
        </ul>
    </nav>
@endsection

@section('content')
    <h1>注文履歴</h1>
    <table>
        @foreach ($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ number_format($order->total_price) }}円</td>
                <td>
                    <a href="/orders/{{ $order->id }}">詳細</a>
                </td>
            </tr>
        @endforeach
    </table>
@endsection
