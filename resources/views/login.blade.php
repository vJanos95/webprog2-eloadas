
<x-mainpage>
    <h1>Bejelentkezés</h1>

    @if ($errors->any())
        <div>
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('login.store') }}">
        @csrf

        <div>
            <label for="username">Felhasználónév</label>
            <input
                id="username"
                type="text"
                name="username"
                value="{{ old('username') }}"
                required
                autocomplete="username"
            >
        </div>

        <div>
            <label for="password">Jelszó</label>
            <input
                id="password"
                type="password"
                name="password"
                required
                autocomplete="current-password"
            >
        </div>

        <button type="submit">Bejelentkezés</button>
    </form>

    <p>
        Még nincs fiókod?
        <a href="{{ route('register') }}">Regisztráció</a>
    </p>
</x-mainpage>
