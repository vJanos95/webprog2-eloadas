
<!DOCTYPE HTML>
<html lang="hu">
<head>
    <title>Iskolai napló</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">

    <link rel="stylesheet" href="{{ asset('html5up/assets/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('html5up/assets/css/fontawesome-all.min.css') }}">

    <noscript>
        <link rel="stylesheet" href="{{ asset('html5up/assets/css/noscript.css') }}">
    </noscript>
</head>
<body class="is-preload">

    <section id="sidebar">
        <div class="inner">
            <nav>
                <ul>
                    <li><a href="/introduction">Kezdőlap</a></li>

                    @if (Auth::check())
                        <li><a href="/dashboard">Dashboard</a></li>
                        <li><a href="/user">Felhasználói oldal</a></li>

                        @if (Auth::user()->role == 1)
                            <li><a href="/admin">Admin</a></li>
                        @endif

                        <li>
                            <form method="POST" action="/logout">
                                @csrf
                                <button type="submit">Kijelentkezés</button>
                            </form>
                        </li>
                    @endif
                </ul>
            </nav>
        </div>
    </section>

    <div id="wrapper">
        <section class="wrapper style1">
            <div class="inner">
                {{ $slot }}
            </div>
        </section>
    </div>

    <footer id="footer" class="wrapper style1-alt">
        <div class="inner">
            <ul class="menu">
                <li>Iskolai napló</li>
                <li>Készítők: Varga János Zoltán - BKD4P6 / Bencze Szabolcs - </li>
                <li>Design: <a href="https://html5up.net/hyperspace">Hyperspace by HTML5 UP</a></li>
            </ul>
        </div>
    </footer>

    <script src="{{ asset('html5up/assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('html5up/assets/js/jquery.scrollex.min.js') }}"></script>
    <script src="{{ asset('html5up/assets/js/jquery.scrolly.min.js') }}"></script>
    <script src="{{ asset('html5up/assets/js/browser.min.js') }}"></script>
    <script src="{{ asset('html5up/assets/js/breakpoints.min.js') }}"></script>
    <script src="{{ asset('html5up/assets/js/util.js') }}"></script>
    <script src="{{ asset('html5up/assets/js/main.js') }}"></script>

</body>
</html>
