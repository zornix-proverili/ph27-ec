<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>@yield('title') - すごい文房具サイト</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.tsx'])
</head>

<body class="container">
    <header>
        <a href="/">
            <img src="{{ asset('images/ec-logo.png') }}" width="100" alt="ECロゴ">
        </a>
        <nav>
            <ul>
                <li><a href="/cart">カートを見る</a></li>
                @auth
                    <li><a href="/mypage">マイページ</a></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                            @csrf
                            <button type="submit" class="outline secondary">ログアウト</button>
                        </form>
                    </li>
                @endauth
                @guest
                    <li><a href="{{ route('login') }}">ログイン</a></li>
                @endguest
            </ul>
        </nav>
    </header>

    {{-- パンくずリスト挿入エリア --}}
    @yield('breadcrumbs')

    <main>
        @yield('content')
    </main>

    <footer>
        <small>© HAL東京</small>
    </footer>
</body>

</html>
