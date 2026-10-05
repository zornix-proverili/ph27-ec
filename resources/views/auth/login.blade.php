@extends('layouts.base')

@section('title', 'ログイン')

@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ul>
            <li><a href="/">ホーム</a></li>
            <li>ログイン</li>
        </ul>
    </nav>
@endsection

@section('content')
    <h1>ログイン</h1>
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <article>{{ $error }}</article>
        @endforeach
    @endif

    <form action="{{ route('login') }}" method="POST">
        @csrf
        <div>
            メールアドレス:
            <input type="email" name="email" value="{{ old('email') }}">
        </div>
        <div>
            パスワード:
            <input type="password" name="password">
        </div>
        <button type="submit">ログイン</button>
    </form>
    <a href="/register">会員登録はこちら</a>
@endsection
