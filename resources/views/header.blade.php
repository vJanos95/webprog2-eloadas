<header class="site-header">
    <div class="header-inner">
        <a href="{{ route('introduction') }}" class="site-brand">
            Iskolai napló
        </a>

        <nav class="main-nav" aria-label="Fő navigáció">
            <a
                href="{{ auth()->check() ? route('dashboard') : route('introduction') }}"
                class="nav-link"
            >
                Kezdőlap
            </a>

            @auth
                <a
                    href="{{ route('students.index') }}"
                    class="nav-link {{ request()->routeIs('students.*') ? 'active' : '' }}"
                >
                    Diákok
                </a>

                <a
                    href="{{ route('subjects.index') }}"
                    class="nav-link {{ request()->routeIs('subjects.*') ? 'active' : '' }}"
                >
                    Tantárgyak
                </a>

                <a
                    href="{{ route('grades.index') }}"
                    class="nav-link {{ request()->routeIs('grades.*') ? 'active' : '' }}"
                >
                    Jegyek
                </a>

                @if ((int) auth()->user()->role === 1)
                    <a
                        href="{{ route('admin') }}"
                        class="nav-link {{ request()->routeIs('admin') ? 'active' : '' }}"
                    >
                        Adminisztráció
                    </a>
                @endif

                <span class="nav-user">
                    {{ auth()->user()->name }}
                    ({{ (int) auth()->user()->role === 1 ? 'Admin' : 'Tanár' }})
                </span>

                <form action="{{ route('logout') }}" method="POST" class="logout-form">
                    @csrf
                    <button type="submit" class="nav-button">
                        Kijelentkezés
                    </button>
                </form>
            @else
                <a
                    href="{{ route('login') }}"
                    class="nav-link {{ request()->routeIs('login') ? 'active' : '' }}"
                >
                    Bejelentkezés
                </a>

                <a
                    href="{{ route('register') }}"
                    class="nav-link {{ request()->routeIs('register') ? 'active' : '' }}"
                >
                    Regisztráció
                </a>
            @endauth
        </nav>
    </div>
</header>