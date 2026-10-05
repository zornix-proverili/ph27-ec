@extends('layouts.base')

@section('title', $news->title)

@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ul>
            <li><a href="/">ホーム</a></li>
            <li>お知らせ詳細</li>
        </ul>
    </nav>
@endsection

@section('content')

    <div class="news-detail">

        <h1 class="news-detail-title">
            {{ $news->title }}
        </h1>

        <div class="news-detail-body">
            {!! $news->content !!}
        </div>

        <a href="/" class="back-link">← 戻る</a>

    </div>

@endsection
